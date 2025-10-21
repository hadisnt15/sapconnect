<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Report\ReportLubRetail;
use App\Models\Report\ReportTop10LubRtl;
use App\Models\SyncLog;

class SyncReportLubRetailFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:reportLubRetail 
                        {startDate? : Tanggal mulai dalam format d.m.Y} 
                        {endDate? : Tanggal akhir dalam format d.m.Y}
                        {tahun?} {bulan?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync report lub retail data from HANA to local DB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startDate = $this->argument('startDate') ?? Carbon::now()->startOfMonth()->format('d.m.Y');
        $endDate = $this->argument('endDate') ?? Carbon::now()->endOfMonth()->format('d.m.Y');
        $tahun = $this->argument('tahun') ?? Carbon::now()->year;
        $bulan = $this->argument('bulan') ?? Carbon::now()->month;

        $this->info("Syncing data dari $startDate sampai $endDate...");

        DB::beginTransaction();
        try {
            // Ambil data dari HANA
            $hanaData = DB::connection('hana')->select(
                "SELECT * FROM LVKKJ_REP_LUBRTL('{$startDate}', '{$endDate}')"
            );
            $hanaData2 = DB::connection('hana')->select(
                "SELECT * FROM LVKKJ_REP_TOP10LUBRTL ('{$startDate}', '{$endDate}')"
            );

            // Kosongkan tabel
            ReportLubRetail::truncate();
            ReportTop10LubRtl::truncate();

            // Insert data Dashboard
            foreach ($hanaData as $row) {
                ReportLubRetail::create([
                    'TYPE' => $row->TYPE,
                    'TYPE2' => $row->TYPE2,
                    'TYPE3' => $row->TYPE3,
                    'LITER' => $row->LITER,
                    'TAHUN' => $tahun,
                    'BULAN' => $bulan,
                ]);
            }

            // Insert data Dashboard
            foreach ($hanaData2 as $row) {
                ReportTop10LubRtl::create([
                    'type' => $row->TYPE,
                    'cardcode' => $row->CARDCODE,
                    'cardname' => $row->CARDNAME,
                    'liter' => $row->LITER,
                ]);
            }

            DB::commit();

            // Logging hasil
            $this->info("Total data Report Lub Retail (HANA): " . count($hanaData));
            $this->info("Total data Report Lub Retail (Laravel): " . ReportLubRetail::count());

        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error("Sync gagal: " . $e->getMessage());
        }
    }
}
