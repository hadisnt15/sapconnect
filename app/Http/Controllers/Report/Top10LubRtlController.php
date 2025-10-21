<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report\ReportTop10LubRtl;
use App\Models\Report;
use App\Models\SyncLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class Top10LubRtlController extends Controller
{
    public function index(Request $request) 
    {
        $report = Report::where('slug', 'top-10-lub-retail')->first();
        $monthInput = $request->input('month', now()->format('Y-m'));

        // Pisahkan tahun dan bulan
        [$tahun, $bulan] = explode('-', $monthInput);

        // Ambil data dari tabel lokal hasil sync
        $data = DB::table('report_top_10_lub_rtl')
            ->select('type', 'cardcode', 'cardname', 'liter')
            ->orderBy('type')
            ->orderByDesc('liter')
            ->get();

        $namaPeriode = Carbon::createFromDate($tahun, $bulan, 1, 'Asia/Jakarta')->locale('id')->translatedFormat('F Y');

        $lastSync = SyncLog::where('name', 'report.top-10-lub-retail')->orderByDesc('last_sync')->first();
        // dd($data);
        // Jika tidak ada data, tampilkan notifikasi
        if ($data->isEmpty()) {
            return view('reports.penjualan_lub_retail', [
                'title' => 'SCKKJ - Laporan ' . $report->name,
                'titleHeader' => $report->name,
                'data2' => collect([]),
                'tahun' => $tahun,
                'bulan' => $bulan,
                'namaPeriode' => $namaPeriode,
                'lastSync' => $lastSync,
                'message' => 'Tidak ada data untuk periode ini.'
            ]);
        }

        return view('reports.penjualan_lub_retail', [
            'title' => 'SCKKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'data2' => $data,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'namaPeriode' => $namaPeriode,
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
        Artisan::call('sync:reportTop10LubRetail', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);

        SyncLog::create(
            [
                'name' => 'report.top-10-lub-retail',
                'last_sync' => now(),
                'desc' => 'Manual'
            ]
        );

        return back()->with('success', 'Data Dasbor Berhasil Disinkronkan dari SAP');
    }
}
