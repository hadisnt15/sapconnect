<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Report\ReportSprSegment;
use App\Models\SyncLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class PenjualanSprSegmentController extends Controller
{
    public function index(Request $request)
    {
        $report = Report::where('slug', 'pencapaian-penjualan-sparepart-per-segment')->first();

        // --- Ambil periode yang tersedia ---
        $availablePeriods = DB::table('report_spr_segment')
            ->select(DB::raw("BULAN, TAHUN, CONCAT(TAHUN, '-', BULAN) as period"))
            ->distinct()
            ->orderByDesc(DB::raw('CAST(TAHUN AS UNSIGNED)'))
            ->orderByDesc(DB::raw('CAST(BULAN AS UNSIGNED)'))
            ->pluck('period');

        // --- Periode yang dipilih ---
        $selectedPeriod = $request->input('period') ?? $availablePeriods->first();
        [$tahun, $bulan] = explode('-', $selectedPeriod);

        $dashboard2 = ReportSprSegment::where('TAHUN', $tahun)->where('BULAN', $bulan)->orderBy('KEYPROFITCENTER')->get();
        $periode = ReportSprSegment::select('tahun', 'bulan')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->first();
        $namaPeriode = null;
        if ($periode) {
            $namaPeriode = Carbon::createFromDate($periode->tahun, $periode->bulan, 1, 'Asia/Jakarta')
                ->locale('id')
                ->translatedFormat('F Y');
        }
        $lastSync = SyncLog::where('name', 'report.penjualan_spr_segment')->orderByDesc('last_sync')->first();
        
        return view('reports.penjualan_spr_segment', [
            'title' => 'SCKKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'dashboard2' => $dashboard2,
            'namaPeriode' => $namaPeriode,
            'lastSync' => $lastSync,
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
        Artisan::call('sync:reportSprSegment', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);

        SyncLog::create(
            [
                'name' => 'report.penjualan_spr_segment',
                'last_sync' => now(),
                'desc' => 'Manual'
            ]
        );

        return back()->with('success', 'Data Penjualan IDS per Grup Berhasil Disinkronkan dari SAP');
    }
}
