<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Report\ReportPeminjamanBarang;
use App\Models\SyncLog;

class SyncReportPeminjamanBarangFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:reportPinjamBarang';

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
                            CAST(\"ALUR\" AS NVARCHAR(255)) AS \"ALUR\",
                            CAST(\"ORIGINCODE\" AS NVARCHAR(255)) AS \"ORIGINCODE\",
                            CAST(\"FRGNNAME\" AS NVARCHAR(255)) AS \"FRGNNAME\",
                            CAST(\"QTY\" AS NVARCHAR(255)) AS \"QTY\",
                            CAST(\"UOM\" AS NVARCHAR(255)) AS \"UOM\"
                        FROM LVKKJ_REP_PEMINJAMANBARANG ()");
        
        ReportPeminjamanBarang::truncate();

        // Insert data Dashboard
        foreach ($hanaData as $row) {
            ReportPeminjamanBarang::create([
                'MAINKEY' => $row->MAINKEY,
                'TANGGAL' => $row->TANGGAL,
                'ALUR' => $row->ALUR,
                'ORIGINCODE' => $row->ORIGINCODE,
                'FRGNNAME' => $row->FRGNNAME,
                'QTY' => $row->QTY,
                'UOM' => $row->UOM,
                'updated_at'    => now(),
            ]);
        }
        DB::commit();
        // Logging hasil
        $this->info("Total data Report Bulanan Average (HANA): " . count($hanaData));
        $this->info("Total data Report Bulanan Average (Laravel): " . ReportPeminjamanBarang::count());
    }
}
