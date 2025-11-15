<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Report\ReportUltah;
use App\Models\SyncLog;

class SyncReportUltahFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:reportUltah';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync report ultah data from HANA to local DB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Syncing data ultah ...");

        $hanaData = DB::connection('hana')->select("SELECT 
                            CAST(\"MAINKEY\" AS NVARCHAR(255)) AS \"MAINKEY\",
                            CAST(\"KODECUST\" AS NVARCHAR(255)) AS \"KODECUST\",
                            CAST(\"NAMACUST\" AS NVARCHAR(255)) AS \"NAMACUST\",
                            CAST(\"PEMILIK\" AS NVARCHAR(255)) AS \"PEMILIK\",
                            CAST(\"ULTAH\" AS NVARCHAR(255)) AS \"ULTAH\",
                            CAST(\"KOTA\" AS NVARCHAR(255)) AS \"KOTA\",
                            CAST(\"KODESALES\" AS NVARCHAR(255)) AS \"KODESALES\",
                            CAST(\"NAMASALES\" AS NVARCHAR(255)) AS \"NAMASALES\"
                        FROM LVKKJ_REP_ULTAH ()");
        // dd($hanaData);
        foreach ($hanaData as $row) {
            DB::table('report_ultah')->updateOrInsert(
                [ 'MAINKEY' => $row->MAINKEY, ], // key unik
                [
                    'KODECUST' => $row->KODECUST,
                    'NAMACUST' => $row->NAMACUST,
                    'PEMILIK' => $row->PEMILIK,
                    'ULTAH' => $row->ULTAH,
                    'KOTA' => $row->KOTA,
                    'KODESALES' => $row->KODESALES,
                    'NAMASALES' => $row->NAMASALES,
                    'updated_at'    => now(),
                    // tambahkan field lain sesuai schema
                ]
            );
        }

        // Logging hasil
        $this->info("Total data Report Bulanan Average (HANA): " . count($hanaData));
        $this->info("Total data Report Bulanan Average (Laravel): " . ReportUltah::count());
    }
}
