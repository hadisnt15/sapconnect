<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PushOrdrToHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:ordr';

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

        $user = Auth::user();

        // ✅ Hanya supervisor yang boleh push
        if ($user->role !== 'supervisor') {
            $this->error("Hanya supervisor yang dapat melakukan push data.");
            return;
        }

        // 🔹 Ambil daftar divisi
        $userDivisions = DB::table('user_division')
            ->join('division', 'user_division.div_id', '=', 'division.id')
            ->where('user_division.user_id', $user->id)
            ->pluck('division.div_name')
            ->toArray();

        // 🔹 Ambil daftar cabang
        $userBranches = DB::table('user_branch')
            ->join('branch', 'user_branch.branch_id', '=', 'branch.id')
            ->where('user_branch.user_id', $user->id)
            ->pluck('branch.branch_name')
            ->toArray();

        // 🔹 Ambil order yang sesuai dengan divisi dan cabang user
        $ordrHead = DB::connection('mysql')->table('ordr_local')
            ->where('is_synced', 0)
            ->where('is_checked', 1)
            ->where('is_deleted', 0)
            ->whereIn('branch', $userBranches)
            ->whereExists(function ($query) use ($userDivisions) {
                $query->select(DB::raw(1))
                    ->from('rdr1_local')
                    ->whereRaw('rdr1_local.OdrId = ordr_local.id')
                    ->whereIn('rdr1_local.RdrItemProfitCenter', $userDivisions);
            })
            ->get();

        if ($ordrHead->isEmpty()) {
            $this->info("Tidak ada data ORDR yang cocok dengan cabang/divisi Anda.");
            return;
        }

        foreach ($ordrHead as $ohead) {
            // Tandai sedang sync
            DB::connection('mysql')->table('ordr_local')
                ->where('id', $ohead->id)
                ->update(['is_synced' => 2]);

            try {
                DB::beginTransaction(); // hanya untuk MySQL

                // ORDER HEAD
                $orderHeadData = [
                    'Code' => $ohead->id,
                    'Name' => $ohead->OdrRefNum,
                    'U_KKJ_OdrId' => $ohead->id,
                    'U_KKJ_OdrRefNum' => $ohead->OdrRefNum,
                    'U_KKJ_OdrNum' => $ohead->OdrNum,
                    'U_KKJ_OdrOcrCode' => $ohead->OdrCrdCode,
                    'U_KKJ_OdrSlpCode' => $ohead->OdrSlpCode,
                    'U_KKJ_OdrDocDate' => $ohead->OdrDocDate,
                    'U_KKJ_Address' => $ohead->note,
                    'U_KKJ_City' => $ohead->branch,
                ];

                DB::connection('hana')->table('@LVKKJ_ORDR')->insert($orderHeadData);

                // ORDER ROW
                $ordrRow = DB::connection('mysql')->table('rdr1_local')
                    ->where('OdrId', $ohead->id)
                    ->get();

                foreach ($ordrRow as $orow) {
                    DB::connection('hana')->table('@LVKKJ_ORDR1')->insert([
                        'Code' => $orow->id,
                        'Name' => $orow->RdrItemCode,
                        'U_KKJ_OdrId' => $orow->OdrId,
                        'U_KKJ_RdrItemCode' => $orow->RdrItemCode,
                        'U_KKJ_RdrItemQuantity' => $orow->RdrItemQuantity,
                        'U_KKJ_RdrItemSatuan' => $orow->RdrItemSatuan,
                        'U_KKJ_RdrItemPrice' => $orow->RdrItemPrice,
                        'U_KKJ_RdrItemProfitCenter' => $orow->RdrItemProfitCenter,
                        'U_KKJ_RdrItemKetHKN' => $orow->RdrItemKetHKN,
                        'U_KKJ_RdrItemKetFG' => $orow->RdrItemKetFG,
                        'U_KKJ_RdrItemDisc' => $orow->RdrItemDisc,
                    ]);
                }

                // Tandai sukses sync
                DB::connection('mysql')->table('ordr_local')
                    ->where('id', $ohead->id)
                    ->update(['is_synced' => 1]);

                DB::commit();
                $this->info("SO {$ohead->OdrRefNum} berhasil dipush ke HANA.");
            } catch (\Exception $e) {
                DB::rollback();

                DB::connection('mysql')->table('ordr_local')
                    ->where('id', $ohead->id)
                    ->update(['is_synced' => 0]);

                Log::error("Gagal push ORDR {$ohead->OdrRefNum}: " . $e->getMessage());
                $this->error("Gagal push ORDR {$ohead->OdrRefNum}: " . $e->getMessage());
            }
        }

        $this->info("Selesai push data.");
    }
}
