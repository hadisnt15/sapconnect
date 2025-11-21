<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Report\ReportStokPtm;
use App\Models\SyncLog;

class SyncReportStokPtmFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:reportStokPtm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync report stok ptm data from HANA to local DB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Syncing data...");

        $hanaData = DB::connection('hana')->select("SELECT 
                            CAST(\"MAINKEY\" AS NVARCHAR(255)) AS \"MAINKEY\",
                            CAST(\"CEK\" AS NVARCHAR(255)) AS \"CEK\",
                            CAST(\"GUDANG\" AS NVARCHAR(255)) AS \"GUDANG\",
                            CAST(\"ORIGINCODE\" AS NVARCHAR(255)) AS \"ORIGINCODE\",
                            CAST(\"FRGNNAME\" AS NVARCHAR(255)) AS \"FRGNNAME\",
                            CAST(\"SATUAN\" AS NVARCHAR(255)) AS \"SATUAN\",
                            CAST(\"STOK\" AS NVARCHAR(255)) AS \"STOK\",
                            CAST(\"ESTHABISSTOKBULAN\" AS NVARCHAR(255)) AS \"ESTHABISSTOKBULAN\",
                            CAST(\"AVG3BULAN\" AS NVARCHAR(255)) AS \"AVG3BULAN\",
                            CAST(\"OPENQTYAP\" AS NVARCHAR(255)) AS \"OPENQTYAP\",
                            CAST(\"STOKPLUSOPENQTY\" AS NVARCHAR(255)) AS \"STOKPLUSOPENQTY\",
                            CAST(\"ESTHABISSTOKPLUSOPENBULAN\" AS NVARCHAR(255)) AS \"ESTHABISSTOKPLUSOPENBULAN\"
                        FROM LVKKJ_REP_STOKPTM ()");
        
        foreach ($hanaData as $row) {
            DB::table('report_stok_ptm')->updateOrInsert(
                [ 'MAINKEY' => $row->MAINKEY, ], // key unik
                [
                    'CEK' => $row->CEK,
                    'GUDANG' => $row->GUDANG,
                    'ORIGINCODE' => $row->ORIGINCODE,
                    'FRGNNAME' => $row->FRGNNAME,
                    'SATUAN' => $row->SATUAN,
                    'STOK' => $row->STOK,
                    'ESTHABISSTOKBULAN' => $row->ESTHABISSTOKBULAN,
                    'AVG3BULAN' => $row->AVG3BULAN,
                    'OPENQTYAP' => $row->OPENQTYAP,
                    'STOKPLUSOPENQTY' => $row->STOKPLUSOPENQTY,
                    'ESTHABISSTOKPLUSOPENBULAN' => $row->ESTHABISSTOKPLUSOPENBULAN,
                    'updated_at'    => now(),
                    // tambahkan field lain sesuai schema
                ]
            );
        }

        // Logging hasil
        $this->info("Total data Report Bulanan Average (HANA): " . count($hanaData));
        $this->info("Total data Report Bulanan Average (Laravel): " . ReportStokPtm::count());
    }
}
