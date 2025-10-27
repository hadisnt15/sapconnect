<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Dashboard;
use App\Models\Dashboard2;

class ViewOrdrProgress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'progress:ordr {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View Order Progress from Hana';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = (int) $this->argument('id');

        $this->info("Lihat Proses Pesanan dengan ID $id");

        DB::beginTransaction();
        try {
            // Ambil data dari HANA
            $sql = 'SELECT 
                        "NO_URUT",
                        "KETERANGAN",
                        "WEB_REF_NUM",
                        "WEB_ORDER_ID",
                        "WEB_DOCDATE",
                        "WEB_CARDCODE",
                        "WEB_CARDNAME",
                        "WEB_ITEMCODE",
                        "WEB_ITEMNAME",
                        "WEB_QTY",
                        CAST("WEB_ITEMROW" AS NVARCHAR(200)) AS "WEB_ITEMROW",
                        CAST("PROSES" AS NVARCHAR) AS "PROSES"
                 FROM "LVKKJ_PROSESPENJUALAN2"(' . $id . ')';
            $progress = DB::connection('hana')->select($sql);
            
            if (empty($progress)) {
                $this->warn("Pesanan Belum Diproses di SAP");
                return;
            }

            $columns = array_keys((array) $progress[0]);

            $this->table(
                $columns,
                collect($progress)->map(function ($row) {
                    return (array) $row;
                })
            );
        } catch (\Throwable $e) {
            $this->error("Gagal Lihat Proses Pesanan " . $e->getMessage());
        }
    }
}
