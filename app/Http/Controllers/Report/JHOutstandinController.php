<?php

namespace App\Http\Controllers\Report;

use App\Models\Report;
use App\Models\SyncLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Models\Report\ReportJHOutstanding;
use App\Models\Report\ReportPeminjamanBarang;

class JHOutstandinController extends Controller
{
    public function index()
    {
        $report = Report::where('slug', 'peminjaman-barang')->first();

        $data = ReportJHOutstanding::orderBy('PRJNAME')
            ->orderBy('MAINKEY','desc')
            ->get()
            ->groupBy('PRJNAME');
        
        $lastSync = SyncLog::where('name', 'report.jh-outstanding')->orderByDesc('last_sync')->first();

        if ($data->isEmpty()) {
            return view('reports.jh_outstanding', [
                'title' => 'SCKKJ - Laporan ' . $report->name,
                'titleHeader' => $report->name,
                'data' => collect([]),
                'lastSync' => $lastSync,
                'message' => 'Tidak ada data untuk periode ini.'
            ]);
        }

        return view('reports.jh_outstanding', [
            'title' => 'SCKKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'data' => $data,
            'lastSync' => $lastSync,
        ]);
    }

    public function refresh(Request $request)
    {
        Artisan::call('sync:reportJHOuts');

        SyncLog::create(
            [
                'name' => 'report.jh-outstanding',
                'last_sync' => now(),
                'desc' => 'Manual'
            ]
        );

        return back()->with('success', 'Data JH Outstanding Berhasil Disinkronkan dari SAP');
    }
}
