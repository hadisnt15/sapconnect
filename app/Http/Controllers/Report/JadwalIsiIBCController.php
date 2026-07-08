<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Report\ReportJadwalIsiIBC;
use App\Models\SyncLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class JadwalIsiIBCController extends Controller
{
    public function index(Request $request)
    {
        $report = Report::where('slug', 'jadwal-isi-ibc')->first();

        $data = ReportJadwalIsiIBC::orderByDesc('FILLINGDATE')->orderBy('FRGNNAME')->get()->groupBy('FILLINGDATE');
        $dataRekap = ReportJadwalIsiIBC::orderBy('PROJECT')->get()->groupBy('PROJECT');

        $lastSync = SyncLog::where('name', 'report.jadwal-isi-ibc')->orderByDesc('last_sync')->first();

        if ($data->isEmpty()) {
            return view('reports.jadwal_isi_ibc', [
                'title' => 'SAPConnect KKJ - Laporan ' . $report->name,
                'titleHeader' => $report->name,
                'data' => collect([]),
                // 'date' => $date,
                'lastSync' => $lastSync,
                'message' => 'Tidak ada data untuk periode ini.'
            ]);
        }

        return view('reports.jadwal_isi_ibc', [
            'title' => 'SAPConnect KKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'data' => $data,
            'dataRekap' => $dataRekap,
            'lastSync' => $lastSync,
        ]);
    }

    public function refresh(Request $request)
    {
        Artisan::call('sync:reportJadwalIBC');

        SyncLog::create(
            [
                'name' => 'report.jadwal-isi-ibc',
                'last_sync' => now(),
                'desc' => 'Manual'
            ]
        );

        return back()->with('success', 'Data Jadwal Pengisian IBC Berhasil Disinkronkan dari SAP');
    }
}
