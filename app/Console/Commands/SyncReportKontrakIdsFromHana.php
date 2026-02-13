<?php

namespace App\Console\Commands;

use App\Models\Report\ReportKontrakIds;
use App\Models\SyncLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncReportKontrakIdsFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:reportKontrakIds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync report kontrak ids data from HANA to local DB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Syncing data ultah ...");

        $hanaData = DB::connection('hana')->select("SELECT 
                            CAST(\"MAINKEY\" AS NVARCHAR(255)) AS \"MAINKEY\",
                            CAST(\"GRUP\" AS NVARCHAR(255)) AS \"GRUP\",
                            CAST(\"TANGGAL\" AS NVARCHAR(255)) AS \"TANGGAL\",
                            CAST(\"KET1\" AS NVARCHAR(255)) AS \"KET1\",
                            CAST(\"KET2\" AS NVARCHAR(255)) AS \"KET2\"
                        FROM LVKKJ_REP_KONTRAKGRUPIDS ()");
        // dd($hanaData);
        foreach ($hanaData as $row) {
            DB::table('report_kontrak_ids')->updateOrInsert(
                [ 'MAINKEY' => $row->MAINKEY, ], // key unik
                [
                    'GRUP' => $row->GRUP,
                    'TANGGAL' => $row->TANGGAL,
                    'KET1' => $row->KET1,
                    'KET2' => $row->KET2,
                    'updated_at'    => now(),
                    // tambahkan field lain sesuai schema
                ]
            );
        }

        // Logging hasil
        $this->info("Total data Report Kontrak IDS (HANA): " . count($hanaData));
        $this->info("Total data Report Kontrak IDS (Laravel): " . ReportKontrakIds::count());
    }
}
