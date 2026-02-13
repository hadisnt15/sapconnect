<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Report\ReportKontrakIds;
use App\Models\SyncLog;
use Illuminate\Http\Request;

class KontrakIdsController extends Controller
{
    public function index(Request $request) 
    {
        $report = Report::where('slug', 'kalender-kontrak-grup-ids')->first();

        // Ambil data dari tabel lokal hasil sync
        $data = ReportKontrakIds::select('GRUP', 'TANGGAL', 'KET1', 'KET2')->get();

        $kontrak = $data->map(function ($ktk) {

            $clean = preg_replace('/[^0-9]/', '', $ktk->TANGGAL);

            if (strlen($clean) < 8) {
                return null;
            }

            $kontrakDate = substr($clean, 0, 8);
            $kontrakDateFormatted = \Carbon\Carbon::createFromFormat('Ymd', $kontrakDate);

            // Buat tanggal ulang tahun tahun ini
            $kontrakDateCalender = $kontrakDateFormatted->copy();

            return [
                'title'        => $ktk->GRUP,
                'start'        => $kontrakDateCalender->format('Y-m-d'),
                'allDay'       => true,

                // untuk popup
                'ket1'    => $ktk->KET1,
                'ket2'    => $ktk->KET2,
            ];
        })->filter()->values();



        // dd($data);
        $lastSync = SyncLog::where('name', 'report.kalender-kontrak-grup-ids')->orderByDesc('last_sync')->first();
        // dd($data);

        return view('reports.kontrak_ids', [
            'title' => 'SCKKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'data' => $data,
            'kontrak' => $kontrak,
            'lastSync' => $lastSync,
        ]);
    }
}
