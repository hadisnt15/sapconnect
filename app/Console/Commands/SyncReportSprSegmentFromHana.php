<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Report\ReportSprSegment;
use App\Models\SyncLog;

class SyncReportSprSegmentFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:reportSprSegment 
                        {startDate? : Tanggal mulai dalam format d.m.Y} 
                        {endDate? : Tanggal akhir dalam format d.m.Y}
                        {tahun?} {bulan?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync report pencapaian spr segment data from HANA to local DB';

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

        $hanaData = DB::connection('hana')->select("SELECT * FROM LVKKJ_REP_SPRSEGMENT ('{$startDate}', '{$endDate}')");

        foreach ($hanaData as $row) {
            DB::table('report_spr_segment')->updateOrInsert(
                [ 'MAINKEY' => $row->MAINKEY, ], // key unik
                [
                    'PROFITCENTER' => $row->PROFITCENTER,
                    'KEYPROFITCENTER' => $row->KEYPROFITCENTER,
                    'VALUE' => $row->VALUE,
                    'TAHUN' => $row->TAHUN,
                    'BULAN' => $row->BULAN,
                    'updated_at'    => now(),
                    // tambahkan field lain sesuai schema
                ]
            );
        }
        // Logging hasil
        $this->info("Total data Report Bulanan Average (HANA): " . count($hanaData));
        $this->info("Total data Report Bulanan Average (Laravel): " . ReportSprSegment::count());
    }
}
