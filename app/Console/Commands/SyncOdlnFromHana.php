<?php

namespace App\Console\Commands;

use App\Models\OdlnLocal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncOrdrFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:odln';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync ODLN data from HANA to local DB';

    /**
     * Execute the console command.
     */
    function cleanString($str) {
        // buang karakter non-UTF8
        return preg_replace('/[^\x09\x0A\x0D\x20-\x7F\xA0-\x{10FFFF}]/u', '', $str);
    }
    
    public function handle()
    {
        $this->info("Syncing ODLN from SAPHANA to LARAVEL...");
        // Ambil data dari HANA
        $hanaData = DB::connection('hana')->select("SELECT 
                            CAST(\"REF_SJ\" AS NVARCHAR(255)) AS \"REF_SJ\",
                            CAST(\"NO_DOKUMEN\" AS NVARCHAR(255)) AS \"NO_DOKUMEN\",
                            CAST(\"TGL_DOKUMEN\" AS DATE) AS \"TGL_DOKUMEN\",
                            CAST(\"TGL_DIBUAT\" AS DATE) AS \"TGL_DIBUAT\",
                            CAST(\"WAKTU_DIBUAT\" AS NVARCHAR(255)) AS \"WAKTU_DIBUAT\",
                            CAST(\"KODE_CUSTOMER\" AS NVARCHAR(255)) AS \"KODE_CUSTOMER\",
                            CAST(\"NAMA_CUSTOMER\" AS NVARCHAR(255)) AS \"NAMA_CUSTOMER\",
                            CAST(\"FREEGOOD\" AS NVARCHAR(255)) AS \"FREEGOOD\",
                            CAST(\"NOTE_SO\" AS NVARCHAR(255)) AS \"NOTE_SO\"
                        FROM LVKKJ_SJDIPROSES ()");
        //select('SELECT "REF_SJ", "NO_DOKUMEN", "TGL_DOKUMEN", "TGL_DIBUAT", "WAKTU_DIBUAT", "KODE_CUSTOMER", "NAMA_CUSTOMER", "FREEGOOD", "NOTE_SO" FROM LVKKJ_SJDIPROSES();');
        // dd($hanaData);
        foreach ($hanaData as $row) {
            DB::table('odln_local')->updateOrInsert(
                [ 'no_sj' => $row->NO_DOKUMEN, ], // key unik
                [
                    'ref_sj' => $row->REF_SJ,
                    'tgl_sj' => $row->TGL_DOKUMEN,
                    'tgl_input' => $row->TGL_DIBUAT,
                    'waktu_input' => $row->WAKTU_DIBUAT,
                    'kode_customer' => $row->KODE_CUSTOMER,
                    'nama_customer' => $row->NAMA_CUSTOMER,
                    'freegood' => $row->FREEGOOD,
                    'ket' => '',
                    'note_so' => $row->NOTE_SO
                ]
            );
        }
        $this->info("Total data dari HANA: " . count($hanaData));
        $this->info("Total data di LARA: " . count($hanaData));
    }
}
