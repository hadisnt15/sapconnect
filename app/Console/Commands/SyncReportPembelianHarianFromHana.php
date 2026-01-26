<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Report\ReportPembelianHarian;
use App\Models\SyncLog;

class SyncReportPembelianHarianFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:reportBeliHarian';

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
                            CAST(\"TIPE2\" AS NVARCHAR(255)) AS \"TIPE2\",
                            CAST(\"KETPERIODE\" AS NVARCHAR(255)) AS \"KETPERIODE\",
                            CAST(\"SEGMENT\" AS NVARCHAR(255)) AS \"SEGMENT\",
                            CAST(\"LITER\" AS NVARCHAR(255)) AS \"LITER\",
                            CAST(\"KILOLITER\" AS NVARCHAR(255)) AS \"KILOLITER\",
                            CAST(\"KETQTYUOM\" AS NVARCHAR(255)) AS \"KETQTYUOM\"
                        FROM LVKKJV_REP_PEMBELIANHARIAN");
        foreach ($hanaData as $row) {
            DB::table('report_pembelian_harian')->updateOrInsert(
                [ 'MAINKEY' => $row->MAINKEY, ], // key unik
                [
                    'TANGGAL' => $row->TANGGAL,
                    'TIPE' => $row->TIPE2,
                    'KETPERIODE' => $row->KETPERIODE,
                    'SEGMENT' => $row->SEGMENT,
                    'LITER' => $row->LITER,
                    'KILOLITER' => $row->KILOLITER,
                    'KETQTYUOM' => $row->KETQTYUOM,
                    'updated_at'    => now(),
                    // tambahkan field lain sesuai schema
                ]
            );
        }

        // Logging hasil
        $this->info("Total data Report Bulanan Average (HANA): " . count($hanaData));
        $this->info("Total data Report Bulanan Average (Laravel): " . ReportPembelianHarian::count());
    }
}
