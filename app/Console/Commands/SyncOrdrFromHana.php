<?php

namespace App\Console\Commands;

use App\Models\OrdrLocal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncOrdrFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:ordr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync ORDR data from HANA to local DB';

    /**
     * Execute the console command.
     */
    function cleanString($str) {
        // buang karakter non-UTF8
        return preg_replace('/[^\x09\x0A\x0D\x20-\x7F\xA0-\x{10FFFF}]/u', '', $str);
    }
    
    public function handle()
    {
        $this->info("Syncing ORDR from SAPHANA to LARAVEL...");
        // Ambil data dari HANA
        $hanaData = DB::connection('hana')->select('SELECT "WEB_REF_NUM", "SAP_REF_NUM", "SAP_DOC_STATUS" FROM LVKKJ_STATUSPESANAN();');

        foreach ($hanaData as $row) {
            DB::table('ordr_status')->updateOrInsert(
                [ 'ref_num' => $row->WEB_REF_NUM, ], // key unik
                [
                    'pesanan_status' => $row->SAP_DOC_STATUS
                ]
            );
        }
        $this->info("Total data dari HANA: " . count($hanaData));
        $this->info("Total data di LARA: " . count($hanaData));
    }
}
