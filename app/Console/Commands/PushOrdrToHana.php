<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        if ($user->role === 'salesman') {
            $slpCode = $user->oslpReg->RegSlpCode;
            $ordrHead = DB::connection('mysql')->table('ordr_local')->where('is_synced',0)->where('is_checked',1)->where('is_deleted', 0)->where('OdrSlpCode',$slpCode)->get();
        } else {
            $ordrHead = DB::connection('mysql')->table('ordr_local')->where('is_synced',0)->where('is_checked',1)->where('is_deleted', 0)->get();
        }
         foreach ($ordrHead as $ohead) {
            // Tandai sedang sync
            DB::connection('mysql')->table('ordr_local')
                ->where('id', $ohead->id)
                ->update(['is_synced' => 2]);

            try {
                DB::beginTransaction(); // hanya untuk MySQL

                // CUSTOMER
                $customer = DB::connection('mysql')->table('ocrd_local')
                    ->where('CardCode', $ohead->OdrCrdCode)
                    ->first();

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
                ];

                if ($customer && $customer->Type1 === 'PELANGGAN BARU') {
                    $orderHeadData['U_KKJ_CardName'] = $customer->CardName;
                    $orderHeadData['U_KKJ_Address'] = $customer->Address;
                    $orderHeadData['U_KKJ_City'] = $customer->City;
                    $orderHeadData['U_KKJ_State'] = $customer->State;
                    $orderHeadData['U_KKJ_Contact'] = $customer->Contact;
                    $orderHeadData['U_KKJ_Phone'] = $customer->Phone;
                    $orderHeadData['U_KKJ_NIK'] = $customer->NIK;
                }

                // Insert ke SAP HANA
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

                // Tandai gagal
                DB::connection('mysql')->table('ordr_local')
                    ->where('id', $ohead->id)
                    ->update(['is_synced' => 0]);

                Log::error("Gagal push ORDR {$ohead->OdrRefNum}: " . $e->getMessage());
                $this->error("Gagal push ORDR {$ohead->OdrRefNum}: " . $e->getMessage());
            }
        }
        $this->info("Berhasil push data");

    }
}
