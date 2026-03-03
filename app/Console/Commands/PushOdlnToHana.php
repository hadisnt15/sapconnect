<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PushOdlnToHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:odln';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync OSLP data from local DB to HANA';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Push ORDR data from LARAVEL to SAPHANA");

        // $user = Auth::user();

        // // ✅ Hanya supervisor yang boleh push
        // if (!in_array($user->role, ['supervisor', 'developer'])) {
        //     $this->error("Hanya supervisor atau developer yang dapat melakukan push data.");
        //     return;
        // }

        // 🔹 Ambil order yang sesuai dengan divisi dan cabang user
        $odln = DB::connection('mysql')->table('odln_local')
            ->where('is_synced', 0)
            ->where('is_checked', 1)
            ->get();

        if ($odln->isEmpty()) {
            $this->info("Tidak ada data ODLN.");
            return;
        }

        foreach ($odln as $o) {
            // Tandai sedang sync
            DB::connection('mysql')->table('odln_local')
                ->where('id', $o->id)
                ->update(['is_synced' => 2]);

            try {
                DB::beginTransaction(); // hanya untuk MySQL

                // ORDER HEAD
                $odlnData = [
                    'Code' => $o->id,
                    'Name' => $o->id,
                    'U_KKJ_NoSJ' => $o->no_sj,
                    'U_KKJ_Tanggal' => now('Asia/Makassar'),
                    'U_KKJ_Waktu' => now('Asia/Makassar')->format('Hi'),
                    'U_KKJ_Ket' => $o->ket
                ];

                DB::connection('hana')->table('@LVKKJ_SJDIPROSES')->insert($odlnData);

                // Tandai sukses sync
                DB::connection('mysql')->table('odln_local')
                    ->where('id', $o->id)
                    ->update(['is_synced' => 1]);

                DB::commit();
                $this->info("SO {$o->ref_sj} berhasil dipush ke HANA.");
            } catch (\Exception $e) {
                DB::rollback();

                DB::connection('mysql')->table('odln_local')
                    ->where('id', $o->id)
                    ->update(['is_synced' => 0]);

                Log::error("Gagal push ORDR {$o->ref_sj}: " . $e->getMessage());
                $this->error("Gagal push ORDR {$o->ref_sj}: " . $e->getMessage());
            }
        }

        $this->info("Selesai push data.");
    }
}
