<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Report\ReportJHOutstanding;
use App\Models\SyncLog;

class SyncReportJHOutstandingFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:reportJHOuts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync report pembelian harian data from HANA to local DB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $startDate = $this->argument('startDate') ?? Carbon::now()->startOfMonth()->format('d.m.Y');
        // $endDate = $this->argument('endDate') ?? Carbon::now()->endOfMonth()->format('d.m.Y');
        // $tahun = $this->argument('tahun') ?? Carbon::now()->year;
        // $bulan = $this->argument('bulan') ?? Carbon::now()->month;

        $this->info("Syncing data ...");

        $hanaData = DB::connection('hana')->select("SELECT 
                            CAST(\"MAINKEY\" AS NVARCHAR(255)) AS \"MAINKEY\",
                            CAST(\"TANGGAL\" AS DATE) AS \"TANGGAL\",
                            CAST(\"PROJECT\" AS NVARCHAR(255)) AS \"PROJECT\",
                            CAST(\"PRJNAME\" AS NVARCHAR(255)) AS \"PRJNAME\",
                            CAST(\"TAHUN\" AS NVARCHAR(255)) AS \"TAHUN\",
                            CAST(\"BULAN\" AS NVARCHAR(255)) AS \"BULAN\",
                            CAST(\"NAMABULAN\" AS NVARCHAR(255)) AS \"NAMABULAN\",
                            CAST(\"TOTAL\" AS NVARCHAR(255)) AS \"TOTAL\"
                        FROM LVKKJ_REP_JHOUTSTANDING ()");
        
        ReportJHOutstanding::truncate();

        // Insert data Dashboard
        foreach ($hanaData as $row) {
            ReportJHOutstanding::create([
                'MAINKEY' => $row->MAINKEY,
                'TANGGAL' => $row->TANGGAL,
                'PROJECT' => $row->PROJECT,
                'PRJNAME' => $row->PRJNAME,
                'TAHUN' => $row->TAHUN,
                'BULAN' => $row->BULAN,
                'NAMABULAN' => $row->NAMABULAN,
                'TOTAL' => $row->TOTAL,
                'updated_at'    => now(),
            ]);
        }
        DB::commit();
        // Logging hasil
        $this->info("Total data Report JH Outstanding (HANA): " . count($hanaData));
        $this->info("Total data Report JH Outstanding (Laravel): " . ReportJHOutstanding::count());
    }
}
