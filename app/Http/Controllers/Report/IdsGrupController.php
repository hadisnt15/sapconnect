<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report\ReportIdsGrup;
use App\Models\SyncLog;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IdsGrupController extends Controller
{
    public function index(Request $request)
    {
        $report = Report::where('slug', 'penjualan-industri-per-grup')->first();
        $monthInput = $request->input('month', now()->format('Y-m'));
        [$tahun, $bulan] = explode('-', $monthInput);

        $user = auth()->user();
        $role = $user->role ?? null;

        $availablePeriods = DB::table('report_ids_grup')
            ->select(DB::raw("BULAN, TAHUN, CONCAT(TAHUN, '-', BULAN) as period"))
            ->distinct()
            ->orderByDesc(DB::raw('CAST(TAHUN AS UNSIGNED)'))
            ->orderByDesc(DB::raw('CAST(BULAN AS UNSIGNED)'))
            ->pluck('period');

        $selectedPeriod = $request->input('period') ?? $availablePeriods->first();
        [$tahun, $bulan] = explode('-', $selectedPeriod);

        $data = DB::table('report_ids_grup')
            ->select('TYPECUST', 'GROUPCUST', 'CARDCODE', 'CARDNAME', 'KILOLITER')
            ->where('TAHUN', $tahun)
            ->where('BULAN', $bulan)
            ->orderBy('TYPECUST')
            ->orderBy('GROUPCUST')
            ->orderBy('CARDNAME')
            ->get()
            ->groupBy(['TYPECUST', 'GROUPCUST'])
            ->map(function ($groupCusts) {
                return $groupCusts->map(function ($rows) {
                    return [
                        'rows' => $rows,
                        'total' => $rows->sum('KILOLITER'),
                    ];
                });
            });
        
        $typeTotal = DB::table('report_ids_grup')
            ->select('TYPECUST', DB::raw('SUM(KILOLITER) as TOTALKL'))
            ->where('TAHUN', $tahun)
            ->where('BULAN', $bulan)
            ->groupBy('TYPECUST')
            ->orderBy('TYPECUST')
            ->pluck('TOTALKL','TYPECUST');

        $periode = ReportIdsGrup::select('tahun', 'bulan')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->first();
        // dd($data);
        $namaPeriode = null;
        if ($selectedPeriod) {
            $namaPeriode = Carbon::createFromDate($tahun, $bulan, 1, 'Asia/Jakarta')
                ->locale('id')
                ->translatedFormat('F Y');
        }

        $lastSync = SyncLog::where('name', 'report.penjualan-lub-retail')->orderByDesc('last_sync')->first();

        if ($data->isEmpty()) {
            return view('reports.ids_grup', [
                'title' => 'SCKKJ - Laporan ' . $report->name,
                'titleHeader' => $report->name,
                'data' => collect([]),
                'typeTotal' => collect([]),
                // 'data2' => collect([]),
                'tahun' => $tahun,
                'bulan' => $bulan,
                'namaPeriode' => '-',
                'availablePeriods' => $availablePeriods,
                'selectedPeriod' => $selectedPeriod,
                'lastSync' => $lastSync,
                'message' => 'Tidak ada data untuk periode ini.'
            ]);
        }

        return view('reports.ids_grup', [
            'title' => 'SCKKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'data' => $data,
            'typeTotal' => $typeTotal,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'namaPeriode' => $namaPeriode,
            'availablePeriods' => $availablePeriods,
            'selectedPeriod' => $selectedPeriod,
            'lastSync' => $lastSync,
        ]);
    }

    public function refresh(Request $request)
    {
        $month = $request->input('month'); // misal "2025-08"
        $carbon = Carbon::createFromFormat('Y-m', $month);
        $tahun = $carbon->format('Y'); // 2025
        $bulan = $carbon->format('m'); // 08
        $startDate = Carbon::parse($month . '-01')->startOfMonth()->format('d.m.Y');
        $endDate   = Carbon::parse($month . '-01')->endOfMonth()->format('d.m.Y');
        // dd($startDate, $endDate);
        Artisan::call('sync:reportIdsGrup', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);

        SyncLog::create(
            [
                'name' => 'report.penjualan-industri-per-grup',
                'last_sync' => now(),
                'desc' => 'Manual'
            ]
        );

        return back()->with('success', 'Data Penjualan IDS per Grup Berhasil Disinkronkan dari SAP');
    }
}
