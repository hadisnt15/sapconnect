<?php

namespace App\Http\Controllers\Report;

use App\Models\Report;
use App\Models\SyncLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Models\Report\ReportPeminjamanBarang;

class PeminjamanBarangController extends Controller
{
    public function index(Request $request) 
    {
        $report = Report::where('slug', 'peminjaman-barang')->first();
        $date = $request->input('date', now()->format('Y-m-d'));

        $data = ReportPeminjamanBarang::where('TANGGAL', $date)
            ->orderBy('ALUR', 'desc')
            ->orderBy('FRGNNAME')
            ->get()
            ->groupBy('ALUR');
        $date2 = Carbon::parse($date)->translatedFormat('d M Y');

        $lastSync = SyncLog::where('name', 'report.peminjaman-barang')->orderByDesc('last_sync')->first();

        if ($data->isEmpty()) {
            return view('reports.peminjaman_barang', [
                'title' => 'SCKKJ - Laporan ' . $report->name,
                'titleHeader' => $report->name,
                'data' => collect([]),
                'date' => $date,
                'lastSync' => $lastSync,
                'message' => 'Tidak ada data untuk periode ini.'
            ]);
        }

        return view('reports.peminjaman_barang', [
            'title' => 'SCKKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'data' => $data,
            'date' => $date2,
            'lastSync' => $lastSync,
        ]);

    }

    public function refresh(Request $request)
    {
        Artisan::call('sync:reportPinjamBarang');
        SyncLog::create(
            [
                'name' => 'report.peminjaman-barang',
                'last_sync' => now(),
                'desc' => 'Manual'
            ]
        );

        return back()->with('success', 'Data Peminjaman Barang Berhasil Disinkronkan dari SAP');
    }
}
