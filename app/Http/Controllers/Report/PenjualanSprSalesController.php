<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Report\ReportSprSales;
use App\Models\SyncLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class PenjualanSprSalesController extends Controller
{
    public function index(Request $request)
    {
        $report = Report::where('slug', 'pencapaian-penjualan-sparepart-per-sales')->first();
        $user = Auth::user();

        // --- Ambil periode yang tersedia ---
        $availablePeriods = DB::table('report_spr_sales')
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
                $dashboard = ReportSprSales::where('KODESALES', $slpCode)
                    ->where('TAHUN', $tahun)
                    ->where('BULAN', $bulan)
                    ->orderBy('NAMASALES')
                    ->orderBy('DOCENTRY')
                    ->orderBy('KEY3')
                    ->orderBy('TYPE')
                    ->get();
            } else {
                // kalau belum ada relasi, return collection kosong
                $dashboard = collect();
            }
        } else {
            $dashboard = ReportSprSales::where('TAHUN', $tahun)->where('BULAN', $bulan)->orderBy('NAMASALES')->orderBy('DOCENTRY')->orderBy('KEY3')->orderBy('TYPE')->get();
        }
        $grouped = $dashboard->groupBy('NAMASALES')->map(function ($salesData) {
            return $salesData->groupBy('KEY3')->map(function ($segmentData) {
                return [
                    'rows' => $segmentData,
                    'sum_target' => $segmentData->sum('TARGET'),
                    'sum_capai' => $segmentData->sum('CAPAI'),
                    'sum_persentase' => $segmentData->avg('PERSENTASE'),
                ];
            });
        });
        $periode = ReportSprSales::select('tahun', 'bulan')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->first();
        $namaPeriode = null;
        if ($periode) {
            $namaPeriode = Carbon::createFromDate($tahun, $bulan, 1, 'Asia/Jakarta')
                ->locale('id')
                ->translatedFormat('F Y');
        }

        $lastSync = SyncLog::where('name', 'report.penjualan_spr_sales')->orderByDesc('last_sync')->first();
        
        return view('reports.penjualan_spr_sales', [
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
        Artisan::call('sync:reportSprSales', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);

        SyncLog::create(
            [
                'name' => 'report.penjualan_spr_sales',
                'last_sync' => now(),
                'desc' => 'Manual'
            ]
        );

        return back()->with('success', 'Data Penjualan IDS per Grup Berhasil Disinkronkan dari SAP');
    }
}
