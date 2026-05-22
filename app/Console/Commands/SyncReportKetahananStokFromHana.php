<?php

namespace App\Console\Commands;

use App\Models\Report\ReportKetahananStok;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SyncReportKetahananStokFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:reportKetahananStok';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync report Ketahanan Stok data from HANA to local DB';

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

        $hanaData2 = DB::connection('hana')->select("SELECT 
                            CAST(\"MAINKEY\" AS NVARCHAR(255)) AS \"MAINKEY\",
                            CAST(\"TANGGAL\" AS DATE) AS \"TANGGAL\",
                            CAST(\"ORIGINCODE\" AS NVARCHAR(255)) AS \"ORIGINCODE\",
                            CAST(\"FRGNNAME\" AS NVARCHAR(255)) AS \"FRGNNAME\",
                            CAST(\"UOM\" AS NVARCHAR(255)) AS \"UOM\",
                            CAST(\"STOCKONHAND\" AS NVARCHAR(255)) AS \"STOCKONHAND\",
                            CAST(\"STOCKOUTSTANDING\" AS NVARCHAR(255)) AS \"STOCKOUTSTANDING\",
                            CAST(\"STOCKCONTAINER\" AS NVARCHAR(255)) AS \"STOCKCONTAINER\",
                            CAST(\"STOCKRENCANAISI\" AS NVARCHAR(255)) AS \"STOCKRENCANAISI\",
                            CAST(\"STOCKRENCANAJADWAL\" AS NVARCHAR(255)) AS \"STOCKRENCANAJADWAL\",
                            CAST(\"TOTALSTOCK\" AS NVARCHAR(255)) AS \"TOTALSTOCK\",
                            CAST(\"STOCKPINJAMMADHANI\" AS NVARCHAR(255)) AS \"STOCKPINJAMMADHANI\",
                            CAST(\"STOCKPINJAMPPA\" AS NVARCHAR(255)) AS \"STOCKPINJAMPPA\",
                            CAST(\"TOTALSTOCKPINJAM\" AS NVARCHAR(255)) AS \"TOTALSTOCKPINJAM\",
                            CAST(\"SISASTOCK\" AS NVARCHAR(255)) AS \"SISASTOCK\"
                        FROM LVKKJ_REP_KETAHANANSTOCK ()");
        ReportKetahananStok::truncate();
        foreach ($hanaData2 as $row) {
            ReportKetahananStok::create(
                [
                    'MAINKEY' => $row->MAINKEY,
                    'TANGGAL' => $row->TANGGAL,
                    'ORIGINCODE' => $row->ORIGINCODE,
                    'FRGNNAME' => $row->FRGNNAME,
                    'UOM' => $row->UOM,
                    'STOCKONHAND' => $row->STOCKONHAND,
                    'STOCKOUTSTANDING' => $row->STOCKOUTSTANDING,
                    'STOCKCONTAINER' => $row->STOCKCONTAINER,
                    'STOCKRENCANAISI' => $row->STOCKRENCANAISI,
                    'STOCKRENCANAJADWAL' => $row->STOCKRENCANAJADWAL,
                    'TOTALSTOCK' => $row->TOTALSTOCK,
                    'STOCKPINJAMMADHANI' => $row->STOCKPINJAMMADHANI,
                    'STOCKPINJAMPPA' => $row->STOCKPINJAMPPA,
                    'TOTALSTOCKPINJAM' => $row->TOTALSTOCKPINJAM,
                    'SISASTOCK' => $row->SISASTOCK,
                    'updated_at'    => now(),
                ]
            );
        }

        // Logging hasil
        $this->info("Total data Report Ketahanan Stok (HANA): " . count($hanaData2));
        $this->info("Total data Report Ketahanan Stok (Laravel): " . ReportKetahananStok::count());
    }
}
