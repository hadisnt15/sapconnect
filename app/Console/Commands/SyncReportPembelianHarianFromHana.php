<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Report\ReportPembelianHarian;
use App\Models\Report\ReportPembelianHarianDetail;
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

        // $hanaData = DB::connection('hana')->select("SELECT 
        //                     CAST(\"MAINKEY\" AS NVARCHAR(255)) AS \"MAINKEY\",
        //                     CAST(\"TANGGAL\" AS DATE) AS \"TANGGAL\",
        //                     CAST(\"TIPE2\" AS NVARCHAR(255)) AS \"TIPE2\",
        //                     CAST(\"KETPERIODE\" AS NVARCHAR(255)) AS \"KETPERIODE\",
        //                     CAST(\"SEGMENT\" AS NVARCHAR(255)) AS \"SEGMENT\",
        //                     CAST(\"LITER\" AS NVARCHAR(255)) AS \"LITER\",
        //                     CAST(\"KILOLITER\" AS NVARCHAR(255)) AS \"KILOLITER\",
        //                     CAST(\"KETQTYUOM\" AS NVARCHAR(255)) AS \"KETQTYUOM\",
        //                     CAST(\"KETQTYITEM\" AS NVARCHAR(5000)) AS \"KETQTYITEM\"
        //                 FROM LVKKJ_REP_PEMBELIANHARIAN ()");
        $hanaData2 = DB::connection('hana')->select("SELECT 
                            CAST(\"MAINKEY\" AS NVARCHAR(255)) AS \"MAINKEY\",
                            CAST(\"TANGGAL\" AS DATE) AS \"TANGGAL\",
                            CAST(\"TIPE2\" AS NVARCHAR(255)) AS \"TIPE2\",
                            CAST(\"KETPERIODE\" AS NVARCHAR(255)) AS \"KETPERIODE\",
                            CAST(\"SEGMENT\" AS NVARCHAR(255)) AS \"SEGMENT\",
                            CAST(\"FRGNNAME\" AS NVARCHAR(255)) AS \"FRGNNAME\",
                            CAST(\"UOMCODE\" AS NVARCHAR(255)) AS \"UOMCODE\",
                            CAST(\"QTY\" AS NVARCHAR(255)) AS \"QTY\",
                            CAST(\"LITER\" AS NVARCHAR(255)) AS \"LITER\",
                            CAST(\"KILOLITER\" AS NVARCHAR(255)) AS \"KILOLITER\",
                            CAST(\"KETQTYUOM\" AS NVARCHAR(255)) AS \"KETQTYUOM\"
                        FROM LVKKJ_REP_PEMBELIANHARIANDETAIL ()");
        // dd($hanaData);
        // foreach ($hanaData as $row) {
        //     DB::table('report_pembelian_harian')->updateOrInsert(
        //         [ 'MAINKEY' => $row->MAINKEY, ], // key unik
        //         [
        //             'TANGGAL' => $row->TANGGAL,
        //             'TIPE' => $row->TIPE2,
        //             'KETPERIODE' => $row->KETPERIODE,
        //             'SEGMENT' => $row->SEGMENT,
        //             'LITER' => $row->LITER,
        //             'KILOLITER' => $row->KILOLITER,
        //             'KETQTYUOM' => $row->KETQTYUOM,
        //             'KETQTYITEM' => $row->KETQTYITEM,
        //             'updated_at'    => now(),
        //             // tambahkan field lain sesuai schema
        //         ]
        //     );
        // }
        foreach ($hanaData2 as $row) {
            DB::table('report_pembelian_harian_detail')->updateOrInsert(
                [ 'MAINKEY' => $row->MAINKEY, ], // key unik
                [
                    'TANGGAL' => $row->TANGGAL,
                    'TIPE' => $row->TIPE2,
                    'KETPERIODE' => $row->KETPERIODE,
                    'SEGMENT' => $row->SEGMENT,
                    'FRGNNAME' => $row->FRGNNAME,
                    'UOMCODE' => $row->UOMCODE,
                    'QTY' => $row->QTY,
                    'LITER' => $row->LITER,
                    'KILOLITER' => $row->KILOLITER,
                    'KETQTYUOM' => $row->KETQTYUOM,
                    'updated_at'    => now(),
                    // tambahkan field lain sesuai schema
                ]
            );
        }

        // Logging hasil
        $this->info("Total data Report Pembelian Harian Detail (HANA): " . count($hanaData2));
        $this->info("Total data Report Pembelian Harian Detail (Laravel): " . ReportPembelianHarianDetail::count());
    }
}
