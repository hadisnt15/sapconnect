<?php

namespace App\Console\Commands;

use App\Models\OslpLocal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncOslpFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:oslp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync OSLP data from HANA to local DB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Syncing OCRD from SAPHANA to LARAVEL...");
        // Ambil data dari HANA
        $hanaData = DB::connection('hana')->select('SELECT "SLPCODE","SLPNAME","PHONE","FIRSTODRDATE","LASTODRDATE" FROM LVKKJ_SALESMAN();');
        // dd($hanaData2);    
        // Hapus data lama
        // OslpLocal::truncate();

        // Insert data baru
        foreach ($hanaData as $row) {
            DB::table('oslp_local')->updateOrInsert(
                [ 'SlpCode' => $row->SLPCODE, ], // key unik
                [
                    'SlpName' => $row->SLPNAME,
                    'Phone' => $row->PHONE,
                    'FirstOdrDate' => $row->FIRSTODRDATE,
                    'LastOdrDate' => $row->LASTODRDATE,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]
            );
        // foreach ($hanaData as $row) {
        //     try {
        //         OslpLocal::create([
        //             'SlpCode' => $row->SLPCODE,
        //             'SlpName' => $row->SLPNAME,
        //             'Phone' => $row->PHONE,
        //             'FirstOdrDate' => $row->FIRSTODRDATE,
        //             'LastOdrDate' => $row->LASTODRDATE,
        //             'created_at'    => now(),
        //             'updated_at'    => now(),
        //         ]);
        //     } catch (\Exception $e) {
        //         \Log::error("Gagal insert SlpCode {$row->SLPCODE}: " . $e->getMessage());
        //     }
        }
        $this->info("Total data dari HANA: " . count($hanaData));
        $this->info("Total data di LARA: " . count($hanaData));
    }
}
