<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Dashboard;
use App\Models\Dashboard2;

class SyncDashboardFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:dashboard 
                        {startDate? : Tanggal mulai dalam format d.m.Y} 
                        {endDate? : Tanggal akhir dalam format d.m.Y}
                        {tahun?} {bulan?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Dashboard data from HANA to local DB';

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
                "SELECT * FROM LVKKJ_DASHBOARD('{$startDate}', '{$endDate}')"
            );
            $hanaData2 = DB::connection('hana')->select(
                "SELECT * FROM LVKKJ_DASHBOARD2('{$startDate}', '{$endDate}')"
            );

            // Kosongkan tabel
            Dashboard::truncate();
            Dashboard2::truncate();

            // Insert data Dashboard
            foreach ($hanaData as $row) {
                Dashboard::create([
                    'MAINKEY' => $row->MAINKEY,
                    'DOCENTRY' => $row->DOCENTRY,
                    'KODESALES' => $row->KODESALES,
                    'NAMASALES' => $row->NAMASALES,
                    'KEY' => $row->KEY,
                    'KEY2' => $row->KEY2,
                    'KEY3' => $row->KEY3,
                    'KEY4' => $row->KEY4,
                    'TYPE' => $row->TYPE,
                    'TARGET' => $row->TARGET,
                    'CAPAI' => $row->CAPAI,
                    'PERSENTASE' => $row->PERSENTASE,
                    'TARGETSPR' => $row->TARGETSPR,
                    'CAPAISPR' => $row->CAPAISPR,
                    'SUMTARGETSPR' => $row->SUMTARGETSPR,
                    'SUMCAPAISPR' => $row->SUMCAPAISPR,
                    'SUMPERSENTASE' => $row->SUMPERSENTASE,
                    'TAHUN' => $tahun,
                    'BULAN' => $bulan,
                ]);
            }

            // Insert data Dashboard2
            foreach ($hanaData2 as $row) {
                Dashboard2::create([
                    'PROFITCENTER' => $row->PROFITCENTER,
                    'KEYPROFITCENTER' => $row->KEYPROFITCENTER,
                    'VALUE' => $row->VALUE,
                    'TAHUN' => $tahun,
                    'BULAN' => $bulan,
                ]);
            }

            DB::commit();

            // Logging hasil
            $this->info("Total data Dashboard (HANA): " . count($hanaData));
            $this->info("Total data Dashboard (Laravel): " . Dashboard::count());
            $this->info("Total data Dashboard2 (HANA): " . count($hanaData2));
            $this->info("Total data Dashboard2 (Laravel): " . Dashboard2::count());

        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error("Sync gagal: " . $e->getMessage());
        }
    }
}
