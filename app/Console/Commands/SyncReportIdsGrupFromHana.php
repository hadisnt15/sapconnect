<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Report\ReportIdsGrup;
use App\Models\SyncLog;

class SyncReportIdsGrupFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:reportIdsGrup 
                        {startDate? : Tanggal mulai dalam format d.m.Y} 
                        {endDate? : Tanggal akhir dalam format d.m.Y}
                        {tahun?} {bulan?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync report ids grup data from HANA to local DB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startDate = $this->argument('startDate') ?? Carbon::now()->startOfMonth()->format('d.m.Y');
        $endDate = $this->argument('endDate') ?? Carbon::now()->endOfMonth()->format('d.m.Y');
        $tahun = $this->argument('tahun') ?? Carbon::now()->year;
        $bulan = $this->argument('bulan') ?? Carbon::now()->month;

        $this->info("Syncing data dari $startDate sampai $endDate...");

        $hanaData = DB::connection('hana')->select("SELECT 
                            CAST(\"MAINKEY\" AS NVARCHAR(255)) AS \"MAINKEY\",
                            CAST(\"GROUPCUST\" AS NVARCHAR(255)) AS \"GROUPCUST\",
                            CAST(\"TYPECUST\" AS NVARCHAR(255)) AS \"TYPECUST\",
                            CAST(\"CARDCODE\" AS NVARCHAR(255)) AS \"CARDCODE\",
                            CAST(\"CARDNAME\" AS NVARCHAR(255)) AS \"CARDNAME\",
                            CAST(\"TAHUN\" AS NVARCHAR(255)) AS \"TAHUN\",
                            CAST(\"BULAN\" AS NVARCHAR(255)) AS \"BULAN\",
                            CAST(\"KILOLITER\" AS NVARCHAR(255)) AS \"KILOLITER\",
                            CAST(\"PIUTANGJT\" AS NVARCHAR(255)) AS \"PIUTANGJT\"
                        FROM LVKKJ_REP_IDSGRUP ('{$startDate}', '{$endDate}')");
        
        foreach ($hanaData as $row) {
            DB::table('report_ids_grup')->updateOrInsert(
                [ 'MAINKEY' => $row->MAINKEY, ], // key unik
                [
                    'GROUPCUST' => $row->GROUPCUST,
                    'TYPECUST' => $row->TYPECUST,
                    'CARDCODE' => $row->CARDCODE,
                    'CARDNAME' => $row->CARDNAME,
                    'TAHUN' => $row->TAHUN,
                    'BULAN' => $row->BULAN,
                    'KILOLITER' => $row->KILOLITER,
                    'PIUTANGJT' => $row->PIUTANGJT,
                    'updated_at'    => now(),
                    // tambahkan field lain sesuai schema
                ]
            );
        }

        // Logging hasil
        $this->info("Total data Report Bulanan Average (HANA): " . count($hanaData));
        $this->info("Total data Report Bulanan Average (Laravel): " . ReportIdsGrup::count());
    }
}
