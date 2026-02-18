<?php

namespace App\Http\Controllers\Report;

use App\Models\Report;
use App\Models\SyncLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Models\Report\ReportPiutang45Hari;

class Piutang45HariController extends Controller
{
    public function index(Request $request)
    {
        $report = Report::where('slug','piutang-45-hari')->first();
        $search = $request->input('search');
        $filter = $request->input('filter');
        $user = auth()->user();
        $divisiList = $user->divisions->pluck('div_name')->toArray();

        $piutang45 = ReportPiutang45Hari::when($search, function ($query, $search){
            $query->where(function ($q) use ($search) {
                $q->where('KODECUST', 'like', "%{$search}%")
                ->orWhere('NAMACUST', 'like', "%{$search}%")
                ->orWhere('JENISCUST', 'like', "%{$search}%")
                ->orWhere('GOLONGANCUST', 'like', "%{$search}%");
            });
        })
        ->when($filter, function ($query, $filter) {
            $query->where('KEY', $filter);
        })
        ->whereIn('KEY', $divisiList)
        ->where('LEWATHARI','>',0)
        ->orderBy('KET3')
        ->orderBy('KEY')
        ->orderByRaw('CAST(LEWATHARI AS SIGNED) DESC')
        ->get();

        $grouped = $piutang45->groupBy('KET3')->map(function ($ket3Group) {

            return $ket3Group->groupBy('KEY')->map(function ($keyGroup) {

                // Group per KET2
                $ket2Groups = $keyGroup->groupBy('KET2')->map(function ($rows) {
                    return [
                        'rows' => $rows,
                        'total_ket2' => $rows->sum('PIUTANG'),
                    ];
                });

                return [
                    'ket2' => $ket2Groups,
                    'total_key' => $ket2Groups->sum('total_ket2')
                ];
            });

        });

        $summary = ReportPiutang45Hari::select(
                'KET3',
                'KEY',
                'KET2',
                DB::raw('SUM(PIUTANG) AS JUMLAH')
            )
            ->whereIn('KEY', $divisiList)
            ->where('LEWATHARI','>',0)
            ->groupBy('KET3', 'KEY', 'KET2')
            ->orderBy('KET3')
            ->orderBy('KEY')
            ->orderBy('KET2')
            ->orderByRaw("FIELD(KET2, 'Lebih 45 Hari', 'Lebih 60 Hari', 'Lebih 90 Hari')")
            ->get();

        $groupedSum = $summary
            ->groupBy('KET3') // 🔥 grouping level pertama
            ->map(function ($ket3Group) {

                return $ket3Group->groupBy('KEY')->map(function ($keyGroup) {
                    $first = $keyGroup->first();

                    // urutan ket2
                    $order = ['Lebih 45 Hari', 'Lebih 60 Hari', 'Lebih 90 Hari'];

                    $ket2Groups = $keyGroup->groupBy('KET2')->map(function ($ket2) {
                        return [
                            'total' => $ket2->sum('JUMLAH'),
                        ];
                    });

                    $totalAll = $ket2Groups->sum('total');

                    return [
                        'headerkey' => $first->KEY,
                        'ket2' => $ket2Groups,
                        'total_all' => $totalAll,
                    ];
                });

            });


        $lastSync = SyncLog::where('name', 'report.piutang-45-hari')->orderByDesc('last_sync')->first();

        return view('reports.piutang_45_hari',[
            'title' => 'SCKKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'grouped' => $grouped,
            'groupedSum' => $groupedSum,
            'report' => $report,
            'lastSync' => $lastSync,
        ]);
    }

    public function refresh()
    {
        Artisan::call('sync:reportPiut45Hari');

        SyncLog::create(
            [
                'name' => 'report.piutang-45-hari',
                'last_sync' => now(),
                'desc' => 'Manual'
            ]
        );

        return back()->with('success', 'Data Piutang 45 Hari Berhasil Disinkronkan dari SAP');
    }
}
