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
        ->orderBy('KEY')
        ->orderByRaw('CAST(LEWATHARI AS SIGNED) DESC')
        ->get();

        $grouped = $piutang45->groupBy('KEY')->map(function ($cust) {

            // Hitung total per KEY di akhir
            $ket2Groups = $cust->groupBy('KET2')->map(function ($piutangData) {
                return [
                    'rows' => $piutangData,
                    'total_ket2' => $piutangData->sum('PIUTANG'), // total per KET2
                ];
            });

            // total per KEY (jumlah total seluruh ket2)
            $totalKey = $ket2Groups->sum('total_ket2');

            return [
                'ket2' => $ket2Groups,
                'total_key' => $totalKey,
            ];
        });

        $summary = ReportPiutang45Hari::select('KEY', 'KET2', DB::raw('SUM(PIUTANG) AS JUMLAH'))
            ->whereIn('KEY', $divisiList)
            ->groupBy('KEY', 'KET2')
            ->orderBy('KEY')
            ->orderBy('KET2')
            ->orderByRaw("FIELD(KET2, 'Lebih 45 Hari', 'Lebih 60 Hari', 'Lebih 90 Hari')")
            ->get();

        $groupedSum = $summary->groupBy('KEY')->map(function ($key) {
            $firstKey = $key->first();
            $order = ['Lebih 45 Hari', 'Lebih 60 Hari', 'Lebih 90 Hari'];

            $ket2Groups = $key->groupBy('KET2')->map(function ($ket2) use ($order) {

                // Ambil total per ket2
                $totalKet2 = $ket2->sum('JUMLAH');

                return [
                    'total' => $totalKet2,
                ];
            });

            // Hitung total keseluruhan per KEY
            $totalAll = $ket2Groups->sum('total');

            return [
                'headerkey' => "{$firstKey->KEY}",
                'ket2' => $ket2Groups,
                'total_all' => $totalAll,
            ];
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
