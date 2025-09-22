<?php

namespace App\Console\Commands;

use App\Models\OcrdLocal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncOcrdFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:ocrd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync OCRD data from HANA to local DB';

    /**
     * Execute the console command.
     */
    function cleanString($str) {
        // buang karakter non-UTF8
        return preg_replace('/[^\x09\x0A\x0D\x20-\x7F\xA0-\x{10FFFF}]/u', '', $str);
    }
    
    public function handle()
    {
        $this->info("Syncing OCRD from SAPHANA to LARAVEL...");
        // Ambil data dari HANA
        $hanaData = DB::connection('hana')->select('SELECT "CARDCODE","CARDNAME","ADDRESS","STATE","CITY","CONTACT",TO_NVARCHAR("PHONE") AS PHONE,"GROUP","TYPE1","TYPE2","CREATEDATE","LASTODRDATE","TERMIN","LIMIT","ACTBAL","DLVBAL","ODRBAL" FROM LVKKJ_CUSTOMER();');

        foreach ($hanaData as $row) {
            DB::table('ocrd_local')->updateOrInsert(
                [ 'CardCode' => $row->CARDCODE, ], // key unik
                [
                    'CardCode' => $row->CARDCODE,
                    'CardName' => $row->CARDNAME,
                    'Address' => $row->ADDRESS,
                    'City' => $row->CITY,
                    'State' => $row->STATE,
                    'Contact' => $row->CONTACT,
                    'Phone' => $row->PHONE,
                    'Group' => $row->GROUP,
                    'Type1' => $row->TYPE1,
                    'Type2' => $row->TYPE2,
                    'CreateDate' => $row->CREATEDATE,
                    'LastOdrDate' => $row->LASTODRDATE,
                    'Termin' => $row->TERMIN,
                    'Limit' => $row->LIMIT,
                    'ActBal' => $row->ACTBAL,
                    'DlvBal' => $row->DLVBAL,
                    'OdrBal' => $row->ODRBAL,
                    'updated_at'    => now(),
                    // tambahkan field lain sesuai schema
                ]
            );
        }
        $this->info("Total data dari HANA: " . count($hanaData));
        $this->info("Total data di LARA: " . count($hanaData));
    }
}
