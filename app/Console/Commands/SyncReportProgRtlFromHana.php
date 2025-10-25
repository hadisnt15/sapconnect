<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Report\ReportProgRtl;
use App\Models\SyncLog;

class SyncReportProgRtlFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:reportProgRtl 
                        {startDate? : Tanggal mulai dalam format d.m.Y} 
                        {endDate? : Tanggal akhir dalam format d.m.Y}
                        {tahun?} {bulan?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync report program retali data from HANA to local DB';

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

        DB::beginTransaction();
        try {
            // Ambil data dari HANA
            $hanaData = DB::connection('hana')->select(
                "SELECT 
                    CAST(\"MAINKEY\" AS NVARCHAR(255)) AS \"MAINKEY\",
                    CAST(\"PROGRAM\" AS NVARCHAR(255)) AS \"PROGRAM\",
                    CAST(\"STATUS\" AS NVARCHAR(255)) AS \"STATUS\",
                    CAST(\"TAHUN\" AS NVARCHAR(255)) AS \"TAHUN\",
                    CAST(\"BULAN\" AS NVARCHAR(255)) AS \"BULAN\",
                    CAST(\"WILAYAH\" AS NVARCHAR(255)) AS \"WILAYAH\",
                    CAST(\"MFORCE\" AS NVARCHAR(255)) AS \"MFORCE\",
                    CAST(\"DMS\" AS NVARCHAR(255)) AS \"DMS\",
                    CAST(\"KODECUSTOMER\" AS NVARCHAR(255)) AS \"KODECUSTOMER\",
                    CAST(\"NAMACUSTOMER\" AS NVARCHAR(255)) AS \"NAMACUSTOMER\",
                    CAST(\"UUID\" AS NVARCHAR(255)) AS \"UUID\",
                    CAST(\"SEGMENT\" AS NVARCHAR(255)) AS \"SEGMENT\",
                    CAST(\"LITER\" AS NVARCHAR(255)) AS \"LITER\",
                    CAST(\"TARGET\" AS NVARCHAR(255)) AS \"TARGET\",
                    CAST(\"SISA\" AS NVARCHAR(255)) AS \"SISA\",
                    CAST(\"KETERANGAN\" AS NVARCHAR(255)) AS \"KETERANGAN\",
                    CAST(\"PERSENTASE\" AS NVARCHAR(255)) AS \"PERSENTASE\"
                FROM LVKKJ_REP_PROGRAMRTL('{$startDate}', '{$endDate}')"
            );

            // Kosongkan tabel
            ReportProgRtl::truncate();

            // Insert data Dashboard
            foreach ($hanaData as $row) {
                ReportProgRtl::create([
                    'MAINKEY' => $row->MAINKEY,
                    'PROGRAM' => $row->PROGRAM,
                    'STATUS' => $row->STATUS,
                    'TAHUN' => $tahun,
                    'BULAN' => $bulan,
                    'WILAYAH' => $row->WILAYAH,
                    'MFORCE' => $row->MFORCE,
                    'DMS' => $row->DMS,
                    'KODECUSTOMER' => $row->KODECUSTOMER,
                    'NAMACUSTOMER' => $row->NAMACUSTOMER,
                    'UUID' => $row->UUID,
                    'SEGMENT' => $row->SEGMENT,
                    'LITER' => $row->LITER,
                    'TARGET' => $row->TARGET,
                    'SISA' => $row->SISA,
                    'KETERANGAN' => $row->KETERANGAN,
                    'PERSENTASE' => $row->PERSENTASE,
                ]);
            }

            DB::commit();

            // Logging hasil
            $this->info("Total data Report Prog Retail (HANA): " . count($hanaData));
            $this->info("Total data Report Prog Retail (Laravel): " . ReportProgRtl::count());

        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error("Sync gagal: " . $e->getMessage());
        }
    }
}
