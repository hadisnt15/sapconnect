<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Report\ReportIdsGrupAVGKL;

class SyncReportIdsGrupAVGKLFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:reportIdsGrupAVGKL';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync report ids grup top 5 avg kl data from HANA to local DB';

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
                            CAST(\"ORIGINCODE\" AS NVARCHAR(255)) AS \"ORIGINCODE\",
                            CAST(\"FRGNNAME\" AS NVARCHAR(255)) AS \"FRGNNAME\",
                            CAST(\"AVGKL\" AS NVARCHAR(255)) AS \"AVGKL\",
                            CAST(\"RANK\" AS NVARCHAR(255)) AS \"RANK\"
                        FROM LVKKJ_REP_IDSGRUPAVGKL ()");
        
        foreach ($hanaData as $row) {
            DB::table('report_ids_grup_avgkl')->updateOrInsert(
                [ 'MAINKEY' => $row->MAINKEY, ], // key unik
                [
                    'GROUPCUST' => $row->GROUPCUST,
                    'TYPECUST' => $row->TYPECUST,
                    'TAHUN' => $row->TAHUN,
                    'BULAN' => $row->BULAN,
                    'ORIGINCODE' => $row->ORIGINCODE,
                    'FRGNNAME' => $row->FRGNNAME,
                    'AVGKL' => $row->AVGKL,
                    'RANK' => $row->RANK,
                    'updated_at'    => now(),
                    // tambahkan field lain sesuai schema
                ]
            );
        }

        // Logging hasil
        $this->info("Total data Report Bulanan Average (HANA): " . count($hanaData));
        $this->info("Total data Report Bulanan Average (Laravel): " . ReportIdsGrupAVGKL::count());
    }
}
