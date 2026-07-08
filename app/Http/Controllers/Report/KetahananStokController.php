<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Report\ReportKetahananStok;
use App\Models\SyncLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class KetahananStokController extends Controller
{
    public function index(Request $request)
    {
        $report = Report::where('slug', 'ketahanan-stok')->first();
        $date = $request->input('date', now()->format('Y-m-d'));

        $data = ReportKetahananStok::orderBy('FRGNNAME')->get();
        // $sumStockOnhand = $data->sum('STOCKONHAND')

        $lastSync = SyncLog::where('name', 'report.ketahanan-stok')->orderByDesc('last_sync')->first();

        if ($data->isEmpty()) {
            return view('reports.ketahanan_stok', [
                'title' => 'SAPConnect KKJ - Laporan ' . $report->name,
                'titleHeader' => $report->name,
                'data' => collect([]),
                // 'date' => $date,
                'lastSync' => $lastSync,
                'message' => 'Tidak ada data untuk periode ini.'
            ]);
        }

        return view('reports.ketahanan_stok', [
            'title' => 'SAPConnect KKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'data' => $data,
            'lastSync' => $lastSync,
        ]);
    }

    public function refresh(Request $request)
    {
        Artisan::call('sync:reportKetahananStok');

        SyncLog::create(
            [
                'name' => 'report.ketahanan-stok',
                'last_sync' => now(),
                'desc' => 'Manual'
            ]
        );

        return back()->with('success', 'Data Jadwal Pengisian IBC Berhasil Disinkronkan dari SAP');
    }
}

