<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report\ReportLubRetail;
use App\Models\SyncLog;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LubRetailController extends Controller
{
    public function index(Request $request) 
    {
        $report = Report::where('slug', 'penjualan-lub-retail')->first();
        $monthInput = $request->input('month', now()->format('Y-m'));

        // Pisahkan tahun dan bulan
        [$tahun, $bulan] = explode('-', $monthInput);

        // Ambil user dan role
        $user = auth()->user();
        $role = $user->role ?? null;

        // Ambil data dari tabel lokal hasil sync
        $data = DB::table('report_lub_retail')
            ->select('TYPE', 'TYPE2', 'LITER')
            ->where('TAHUN', $tahun)
            ->where('BULAN', $bulan)
            ->orderBy('TYPE')
            ->orderBy('TYPE2')
            ->get();

        $periode = ReportLubRetail::select('tahun', 'bulan')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->first();
        $namaPeriode = null;
        if ($periode) {
            $namaPeriode = Carbon::createFromDate($periode->tahun, $periode->bulan, 1, 'Asia/Jakarta')
                ->locale('id')
                ->translatedFormat('F Y');
        }

        $lastSync = SyncLog::where('name', 'report.penjualan-lub-retail')->orderByDesc('last_sync')->first();

        // Jika tidak ada data, tampilkan notifikasi
        if ($data->isEmpty()) {
            return view('reports.penjualan_lub_retail', [
                'title' => 'SCKKJ - Laporan ' . $report->name,
                'titleHeader' => $report->name,
                'data' => collect([]),
                'tahun' => $tahun,
                'bulan' => $bulan,
                'namaPeriode' => '-',
                'message' => 'Tidak ada data untuk periode ini.'
            ]);
        }

        return view('reports.penjualan_lub_retail', [
            'title' => 'SCKKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'data' => $data,
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
        Artisan::call('sync:reportLubRetail', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);

        SyncLog::create(
            [
                'name' => 'report.penjualan-lub-retail',
                'last_sync' => now(),
                'desc' => 'Manual'
            ]
        );

        return back()->with('success', 'Data Dasbor Berhasil Disinkronkan dari SAP');
    }
}
