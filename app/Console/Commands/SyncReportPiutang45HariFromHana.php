<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Report\ReportPiutang45Hari;
use App\Models\SyncLog;

class SyncReportPiutang45HariFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:reportPiut45Hari';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync report piutang 45 hari data from HANA to local DB';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $this->info("Syncing data ...");

        $hanaData = DB::connection('hana')->select("SELECT 
                            CAST(\"KODECUST\" AS NVARCHAR(255)) AS \"KODECUST\",
                            CAST(\"NAMACUST\" AS NVARCHAR(255)) AS \"NAMACUST\",
                            CAST(\"JENISCUST\" AS NVARCHAR(255)) AS \"JENISCUST\",
                            CAST(\"GOLONGANCUST\" AS NVARCHAR(255)) AS \"GOLONGANCUST\",
                            CAST(\"KEY\" AS NVARCHAR(255)) AS \"KEY\",
                            CAST(\"CABANG\" AS NVARCHAR(255)) AS \"CABANG\",
                            CAST(\"LEWATHARI\" AS NVARCHAR(255)) AS \"LEWATHARI\",
                            CAST(\"KET\" AS NVARCHAR(255)) AS \"KET\",
                            CAST(\"KET2\" AS NVARCHAR(255)) AS \"KET2\",
                            CAST(\"KET3\" AS NVARCHAR(255)) AS \"KET3\",
                            CAST(\"PIUTANG\" AS NVARCHAR(255)) AS \"PIUTANG\",
                            CAST(\"KETPIUTANG\" AS NVARCHAR(255)) AS \"KETPIUTANG\"
                        FROM LVKKJ_REP_PIUTANG ()");
        
        foreach ($hanaData as $row) {
            DB::table('report_piutang_45hari')->updateOrInsert(
                [ 'KODECUST' => $row->KODECUST, ], // key unik
                [
                    'NAMACUST' => $row->NAMACUST,
                    'JENISCUST' => $row->JENISCUST,
                    'GOLONGANCUST' => $row->GOLONGANCUST,
                    'KEY' => $row->KEY,
                    'CABANG' => $row->CABANG,
                    'LEWATHARI' => $row->LEWATHARI,
                    'KET' => $row->KET,
                    'KET2' => $row->KET2,
                    'KET3' => $row->KET3,
                    'PIUTANG' => $row->PIUTANG,
                    'KETPIUTANG' => $row->KETPIUTANG,
                    'updated_at'    => now(),
                    // tambahkan field lain sesuai schema
                ]
            );
        }

        // Logging hasil
        $this->info("Total data Report Bulanan Average (HANA): " . count($hanaData));
        $this->info("Total data Report Bulanan Average (Laravel): " . ReportPiutang45Hari::count());
    }
}
