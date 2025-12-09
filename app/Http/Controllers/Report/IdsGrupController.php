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

        // --- Ambil periode yang tersedia ---
        $availablePeriods = DB::table('report_ids_grup')
            ->select(DB::raw("BULAN, TAHUN, CONCAT(TAHUN, '-', BULAN) as period"))
            ->distinct()
            ->orderByDesc(DB::raw('CAST(TAHUN AS UNSIGNED)'))
            ->orderByDesc(DB::raw('CAST(BULAN AS UNSIGNED)'))
            ->pluck('period');

        // --- Periode yang dipilih ---
        $selectedPeriod = $request->input('period') ?? $availablePeriods->first();
        [$tahun, $bulan] = explode('-', $selectedPeriod);

        // --- Input pencarian ---
        $search = trim($request->input('search', ''));

        // --- Query utama data per grup ---
        $query = DB::table('report_ids_grup')
            ->select('TYPECUST', 'GROUPCUST', 'CARDCODE', 'CARDNAME', 'KILOLITER', 'PIUTANG', 'PIUTANGJT')
            ->where('TAHUN', $tahun)
            ->where('BULAN', $bulan);

        // Filter pencarian jika diisi
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('CARDNAME', 'like', "%{$search}%")
                ->orWhere('CARDCODE', 'like', "%{$search}%")
                ->orWhere('TYPECUST', 'like', "%{$search}%")
                ->orWhere('GROUPCUST', 'like', "%{$search}%");
            });
        }

        // Eksekusi dan kelompokkan
        $data = $query
            ->orderBy('TYPECUST')
            ->orderBy('GROUPCUST')
            ->orderBy('CARDNAME')
            ->get()
            ->groupBy(['TYPECUST', 'GROUPCUST'])
            ->map(function ($groupCusts) {
                return $groupCusts->map(function ($rows) {
                    return [
                        'rows' => $rows->sortByDesc('PIUTANG')->sortByDesc('KILOLITER'),
                        'total' => $rows->sum('KILOLITER'),
                        'total2' => $rows->sum('PIUTANGJT'),
                        'total3' => $rows->sum('PIUTANG'),
                    ];
                });
            });

        // Total per TYPECUST (terpengaruh pencarian juga)
        $typeTotal = DB::table('report_ids_grup')
            ->select('TYPECUST', DB::raw('SUM(KILOLITER) as TOTALKL'))
            ->where('TAHUN', $tahun)
            ->where('BULAN', $bulan)
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q2) use ($search) {
                    $q2->where('CARDNAME', 'like', "%{$search}%")
                    ->orWhere('CARDCODE', 'like', "%{$search}%")
                    ->orWhere('TYPECUST', 'like', "%{$search}%")
                    ->orWhere('GROUPCUST', 'like', "%{$search}%");
                });
            })
            ->groupBy('TYPECUST')
            ->orderBy('TYPECUST')
            ->pluck('TOTALKL', 'TYPECUST');

        $queryGrafik = DB::table('report_ids_grup_12bulan')
            ->select(
                'MAINKEY',
                'TYPECUST',
                'GROUPCUST',
                DB::raw('CAST(TAHUN AS SIGNED) as TAHUN'),
                DB::raw('CAST(BULAN AS SIGNED) as BULAN'),
                'KILOLITER',
                'TAHUNUPDATE',
                'BULANUPDATE'
            )
            ->where('TAHUNUPDATE', $tahun)
            ->where('BULANUPDATE', $bulan)
            ->orderBy('TAHUN', 'asc')
            ->orderBy('BULAN', 'asc');
        
        $grafik = $queryGrafik->get()->groupBy(['TYPECUST','GROUPCUST']);

        // Nama bulan human-readable
        $namaPeriode = Carbon::createFromDate($tahun, $bulan, 1, 'Asia/Jakarta')
            ->locale('id')
            ->translatedFormat('F Y');

        $lastSync = SyncLog::where('name', 'report.penjualan-industri-per-grup')
            ->orderByDesc('last_sync')
            ->first();

        return view('reports.ids_grup', [
            'title' => 'SCKKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'data' => $data,
            'grafik' => $grafik,
            'typeTotal' => $typeTotal,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'namaPeriode' => $namaPeriode,
            'availablePeriods' => $availablePeriods,
            'selectedPeriod' => $selectedPeriod,
            'lastSync' => $lastSync,
            'search' => $search,
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
        Artisan::call('sync:reportIdsGrup12Bln');

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
