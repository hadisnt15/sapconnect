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

        $ultah = $data->map(function ($bdy) {

            $clean = preg_replace('/[^0-9]/', '', $bdy->ULTAH);

            if (strlen($clean) < 8) {
                return null;
            }

            $birth = substr($clean, 0, 8);
            $birthDate = \Carbon\Carbon::createFromFormat('Ymd', $birth);

            // Buat tanggal ulang tahun tahun ini
            $eventDate = $birthDate->copy()->setYear(now()->year);

            // Hitung umur tahun ini → kalau ulang tahunnya belum lewat, tetap umur yang sama
            $age = now()->year - $birthDate->year;

            return [
                'title'        => $bdy->PEMILIK . ' 🎂 (' . $age . ' th)',
                'start'        => $eventDate->format('Y-m-d'),
                'allDay'       => true,

                // untuk popup
                'cust_name'    => $bdy->NAMACUST,
                'cust_code'    => $bdy->KODECUST,
                'pemilik'      => $bdy->PEMILIK,
                'tanggal_asli' => $birthDate->format('d-m-Y'),
                'usia'         => $age,
            ];
        })->filter()->values();


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
