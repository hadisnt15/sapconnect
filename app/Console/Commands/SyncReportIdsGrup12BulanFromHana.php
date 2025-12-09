<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Report\ReportIdsGrup12Bulan;

class SyncReportIdsGrup12BulanFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:reportIdsGrup12Bln';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync report ids grup 12 bulan data from HANA to local DB';

    /**
     * Execute the console command.
     */
    public function handle()
    {


        $this->info("Syncing data dari...");

        $hanaData = DB::connection('hana')->select("SELECT 
                            CAST(\"MAINKEY\" AS NVARCHAR(255)) AS \"MAINKEY\",
                            CAST(\"GROUPCUST\" AS NVARCHAR(255)) AS \"GROUPCUST\",
                            CAST(\"TYPECUST\" AS NVARCHAR(255)) AS \"TYPECUST\",
                            CAST(\"TAHUN\" AS NVARCHAR(255)) AS \"TAHUN\",
                            CAST(\"BULAN\" AS NVARCHAR(255)) AS \"BULAN\",
                            CAST(\"TAHUNUPDATE\" AS NVARCHAR(255)) AS \"TAHUNUPDATE\",
                            CAST(\"BULANUPDATE\" AS NVARCHAR(255)) AS \"BULANUPDATE\",
                            CAST(\"KILOLITER\" AS NVARCHAR(255)) AS \"KILOLITER\"
                        FROM LVKKJ_REP_IDSGRUP12BLN ()");
        
        foreach ($hanaData as $row) {
            DB::table('report_ids_grup_12bulan')->updateOrInsert(
                [ 'MAINKEY' => $row->MAINKEY, ], // key unik
                [
                    'GROUPCUST' => $row->GROUPCUST,
                    'TYPECUST' => $row->TYPECUST,
                    'TAHUN' => $row->TAHUN,
                    'BULAN' => $row->BULAN,
                    'KILOLITER' => $row->KILOLITER,
                    'TAHUNUPDATE' => $row->TAHUNUPDATE,
                    'BULANUPDATE' => $row->BULANUPDATE,
                    'updated_at'    => now(),
                    // tambahkan field lain sesuai schema
                ]
            );
        }

        // Logging hasil
        $this->info("Total data Report Bulanan Average (HANA): " . count($hanaData));
        $this->info("Total data Report Bulanan Average (Laravel): " . ReportIdsGrup12Bulan::count());
    }
}
