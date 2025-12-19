<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report\ReportUltah;
use App\Models\Report;
use App\Models\SyncLog;

class UltahController extends Controller
{
    public function index(Request $request) 
    {
        $report = Report::where('slug', 'kalender-ulang-tahun')->first();

        // Ambil data dari tabel lokal hasil sync
        $data = ReportUltah::select('KODECUST', 'NAMACUST', 'PEMILIK', 'ULTAH')->get();

        $ultah = $data->flatMap(function ($bdy) {

            $clean = preg_replace('/[^0-9]/', '', $bdy->ULTAH);

            if (strlen($clean) < 8) {
                return [];
            }

            $birthDate = \Carbon\Carbon::createFromFormat('Ymd', substr($clean, 0, 8));

            return collect(range(now()->year, now()->year + 5))->map(function ($year) use ($bdy, $birthDate) {

                $eventDate = $birthDate->copy()->setYear($year);

                $age = $year - $birthDate->year;

                return [
                    'title'        => $bdy->PEMILIK . ' 🎂 (' . $age . ' th)',
                    'start'        => $eventDate->format('Y-m-d'),
                    'allDay'       => true,

                    'cust_name'    => $bdy->NAMACUST,
                    'cust_code'    => $bdy->KODECUST,
                    'pemilik'      => $bdy->PEMILIK,
                    'tanggal_asli' => $birthDate->format('d-m-Y'),
                    'usia'         => $age,
                ];
            });
        });



        // dd($data);
        $lastSync = SyncLog::where('name', 'report.kalender-ulang-tahun')->orderByDesc('last_sync')->first();
        // dd($data);

        return view('reports.kalender_ulang_tahun', [
            'title' => 'SCKKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'data' => $data,
            'ultah' => $ultah,
            'lastSync' => $lastSync,
        ]);
    }



}
