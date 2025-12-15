<?php

namespace App\Http\Controllers\Report;

use Carbon\Carbon;
use App\Models\Report;
use App\Models\SyncLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Report\ReportRtlSales;
use Illuminate\Support\Facades\Artisan;

class PenjualanRtlSalesController extends Controller
{
    public function index(Request $request)
    {
        $report = Report::where('slug', 'pencapaian-penjualan-retail-per-sales')->first();
        $user = Auth::user();

        // --- Ambil periode yang tersedia ---
        $availablePeriods = DB::table('report_rtl_sales')
            ->select(DB::raw("BULAN, TAHUN, CONCAT(TAHUN, '-', BULAN) as period"))
            ->distinct()
            ->orderByDesc(DB::raw('CAST(TAHUN AS UNSIGNED)'))
            ->orderByDesc(DB::raw('CAST(BULAN AS UNSIGNED)'))
            ->pluck('period');

        // --- Periode yang dipilih ---
        $selectedPeriod = $request->input('period') ?? $availablePeriods->first();
        [$tahun, $bulan] = explode('-', $selectedPeriod);

        if ($user->role === 'salesman') {
            if ($user->oslpReg) {
                $slpCode = $user->oslpReg->RegSlpCode;
                $dashboard = ReportRtlSales::where('SLPCODE', $slpCode)
                    ->where('TAHUN', $tahun)
                    ->where('BULAN', $bulan)
                    ->orderBy('SLPNAME')
                    ->orderBy('SEGMENT')
                    ->get();
            } else {
                // kalau belum ada relasi, return collection kosong
                $dashboard = collect();
            }
        } else {
            $dashboard = ReportRtlSales::where('TAHUN', $tahun)->where('BULAN', $bulan)->orderBy('SLPNAME')->orderBy('SEGMENT')->get();
        }
        $grouped = $dashboard->groupBy('SLPNAME')->map(function ($salesData) {
                return [
                    'rows' => $salesData,
                    'sum_target' => $salesData->sum('TARGET'),
                    'sum_liter' => $salesData->sum('LITER'),
                    'sum_persen' => $salesData->sum('LITER')/$salesData->sum('TARGET')*100,
                ];
        });
        $periode = ReportRtlSales::select('TAHUN', 'BULAN')
            ->orderByDesc('TAHUN')
            ->orderByDesc('BULAN')
            ->first();
        // dd($periode);
        $namaPeriode = null;
        if ($periode) {
            $namaPeriode = Carbon::createFromDate($tahun, $bulan, 1, 'Asia/Jakarta')
                ->locale('id')
                ->translatedFormat('F Y');
        }

        $lastSync = SyncLog::where('name', 'report.penjualan_rtl_sales')->orderByDesc('last_sync')->first();
        
        return view('reports.penjualan_rtl_sales', [
            'title' => 'SCKKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'grouped' => $grouped,
            'namaPeriode' => $namaPeriode,
            'lastSync' => $lastSync,
            'report' => $report,
            'availablePeriods' => $availablePeriods,
            'selectedPeriod' => $selectedPeriod,
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
        Artisan::call('sync:reportRtlSales', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);

        SyncLog::create(
            [
                'name' => 'report.penjualan_rtl_sales',
                'last_sync' => now(),
                'desc' => 'Manual'
            ]
        );

        return back()->with('success', 'Data Penjualan Retail per Penjual Berhasil Disinkronkan dari SAP');
    }
}
