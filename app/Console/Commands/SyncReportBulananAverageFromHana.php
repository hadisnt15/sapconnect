<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Report\ReportBulananAverage;
use App\Models\SyncLog;

class SyncReportBulananAverageFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:reportBulananAverage 
                        {startDate? : Tanggal mulai dalam format d.m.Y} 
                        {endDate? : Tanggal akhir dalam format d.m.Y}
                        {tahun?} {bulan?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync report bulanan average data from HANA to local DB';

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
                    CAST(\"ROWNUM\" AS INTEGER) AS \"ROWNUM\",
                    CAST(\"KODECUSTOMER\" AS NVARCHAR(50)) AS \"KODECUSTOMER\",
                    CAST(\"NAMACUSTOMER\" AS NVARCHAR(255)) AS \"NAMACUSTOMER\",
                    CAST(\"KODENAMACUSTOMER\" AS NVARCHAR(255)) AS \"KODENAMACUSTOMER\",
                    CAST(\"SEGMENT\" AS NVARCHAR(50)) AS \"SEGMENT\",
                    CAST(\"NO\" AS NVARCHAR(50)) AS \"NO\",
                    CAST(\"TAHUN\" AS NVARCHAR(50)) AS \"TAHUN\",
                    CAST(\"BULAN\" AS NVARCHAR(50)) AS \"BULAN\",
                    CAST(\"TAHUNBULAN\" AS NVARCHAR(50)) AS \"TAHUNBULAN\",
                    CAST(\"NAMATAHUNBULAN\" AS NVARCHAR(50)) AS \"NAMATAHUNBULAN\",
                    CAST(\"VALUE\" AS NVARCHAR(50)) AS \"VALUE\",
                    CAST(\"STATUSORDER\" AS NVARCHAR(50)) AS \"STATUSORDER\",
                    CAST(\"KOTA\" AS NVARCHAR(255)) AS \"KOTA\",
                    CAST(\"PROVINSI\" AS NVARCHAR(255)) AS \"PROVINSI\",
                    CAST(\"KODESALES\" AS NVARCHAR(50)) AS \"KODESALES\",
                    CAST(\"NAMASALES\" AS NVARCHAR(255)) AS \"NAMASALES\",
                    CAST(\"DIVISI\" AS NVARCHAR(255)) AS \"DIVISI\"
                FROM LVKKJ_REP_BULANANAVERAGE ('{$startDate}', '{$endDate}')"
            );

            // Kosongkan tabel
            ReportBulananAverage::truncate();

            // Insert data Dashboard
            foreach ($hanaData as $row) {
                ReportBulananAverage::create([
                    'MAINKEY' => $row->MAINKEY,
                    'ROWNUM' => $row->ROWNUM,
                    'KODECUSTOMER' => $row->KODECUSTOMER,
                    'NAMACUSTOMER' => $row->NAMACUSTOMER,
                    'KODENAMACUSTOMER' => $row->KODENAMACUSTOMER,
                    'SEGMENT' => $row->SEGMENT,
                    'NO' => $row->NO,
                    'TAHUN' => $row->TAHUN,
                    'BULAN' => $row->BULAN,
                    'TAHUNBULAN' => $row->TAHUNBULAN,
                    'NAMATAHUNBULAN' => $row->NAMATAHUNBULAN,
                    'VALUE' => $row->VALUE,
                    'STATUSORDER' => $row->STATUSORDER,
                    'KOTA' => $row->KOTA,
                    'PROVINSI' => $row->PROVINSI,
                    'KODESALES' => $row->KODESALES,
                    'NAMASALES' => $row->NAMASALES,
                    'DIVISI' => $row->DIVISI,
                ]);
            }

            DB::commit();

            // Logging hasil
            $this->info("Total data Report Bulanan Average (HANA): " . count($hanaData));
            $this->info("Total data Report Bulanan Average (Laravel): " . ReportBulananAverage::count());

        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error("Sync gagal: " . $e->getMessage());
        }
    }
}
