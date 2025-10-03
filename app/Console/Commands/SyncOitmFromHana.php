<?php

namespace App\Console\Commands;

use App\Models\OitmLocal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncOitmFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:oitm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync OITM data from HANA to local DB';

    /**
     * Execute the console command.
     */
    function cleanString($str) {
        // buang karakter non-UTF8
        return preg_replace('/[^\x09\x0A\x0D\x20-\x7F\xA0-\x{10FFFF}]/u', '', $str);
    }
    
    public function handle()
    {
        $this->info("Syncing OITM from HANA...");
        // Ambil data dari HANA
        $hanaData = DB::connection('hana')->select('SELECT 
            "ItemCode"      AS "ITEMCODE",
            "ItemName"      AS "ITEMNAME",
            "FrgnName"      AS "FRGNNAME",
            "ProfitCenter"  AS "PROFITCENTER",
            "Brand"         AS "BRAND",
            "Segment"       AS "SEGMENT",
            "Type"          AS "TYPE",
            "Series"        AS "SERIES",
            "Satuan"        AS "SATUAN",
            "TotalStock"    AS "TOTALSTOCK",
            "HET"           AS "HET",
            "StatusHKN"     AS "STATUSHKN",
            "StatusFG"      AS "STATUSFG",
            "KetHKN"        AS "KETHKN",
            "KetFG"        AS "KETFG",
            "KetStock"        AS "KETSTOCK",
            "Divisi"        AS "DIVISI"
        FROM LVKKJV_ITEMSIDP;');
        // dd($hanaData[0]);    
        // Hapus data lama
        OitmLocal::truncate();

        // Insert data baru
        foreach ($hanaData as $row) {
            OitmLocal::create([
                'ItemCode'      => $row->ITEMCODE,
                'ItemName'      => $row->ITEMNAME,
                'FrgnName'      => $row->FRGNNAME,
                'ProfitCenter'  => $row->PROFITCENTER,
                'Brand'         => $row->BRAND,
                'Segment'       => $row->SEGMENT,
                'Type'          => $row->TYPE,
                'Series'        => $row->SERIES,
                'Satuan'        => $row->SATUAN,
                'TotalStock'    => $row->TOTALSTOCK,
                'HET'           => $row->HET,
                'StatusHKN'     => $row->STATUSHKN,
                'StatusFG'      => $row->STATUSFG,
                'KetHKN'        => $row->KETHKN,
                'KetFG'         => $row->KETFG,
                'KetStock'      => $row->KETSTOCK = mb_convert_encoding($row->KETSTOCK, 'UTF-8', 'UTF-8'),
                'div_name'         => $row->DIVISI,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

        $this->info("Sync selesai. Total: " . count($hanaData));
    }
}
