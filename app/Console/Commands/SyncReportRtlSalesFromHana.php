<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Report\ReportRtlSales;
use App\Models\SyncLog;

class SyncReportRtlSalesFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:reportRtlSales 
                        {startDate? : Tanggal mulai dalam format d.m.Y} 
                        {endDate? : Tanggal akhir dalam format d.m.Y}
                        {tahun?} {bulan?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync report pencapaian spr sales data from HANA to local DB';

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
                CAST(\"SLPCODE\" AS NVARCHAR(255)) AS \"SLPCODE\",
                CAST(\"SLPNAME\" AS NVARCHAR(255)) AS \"SLPNAME\",
                CAST(\"TAHUN\" AS INTEGER) AS \"TAHUN\",
                CAST(\"BULAN\" AS INTEGER) AS \"BULAN\",
                CAST(\"SEGMENT\" AS NVARCHAR(255)) AS \"SEGMENT\",
                CAST(\"TARGET\" AS NVARCHAR(255)) AS \"TARGET\",
                CAST(\"LITER\" AS NVARCHAR(255)) AS \"LITER\",
                CAST(\"PERSEN\" AS NVARCHAR(255)) AS \"PERSEN\"
            FROM LVKKJ_REP_RTLSALES ('{$startDate}', '{$endDate}')");

        foreach ($hanaData as $row) {
            DB::table('report_rtl_sales')->updateOrInsert(
                [ 'MAINKEY' => $row->MAINKEY, ], // key unik
                [
                    'SLPCODE' => $row->SLPCODE,
                    'SLPNAME' => $row->SLPNAME,
                    'TAHUN' => $row->TAHUN,
                    'BULAN' => $row->BULAN,
                    'SEGMENT' => $row->SEGMENT,
                    'TARGET' => $row->TARGET,
                    'LITER' => $row->LITER,
                    'PERSEN' => $row->PERSEN,
                    'updated_at'    => now(),
                    // tambahkan field lain sesuai schema
                ]
            );
        }
        // Logging hasil
        $this->info("Total data Report RTL Sales (HANA): " . count($hanaData));
        $this->info("Total data Report RTL Sales (Laravel): " . ReportRtlSales::count());
    }
}
