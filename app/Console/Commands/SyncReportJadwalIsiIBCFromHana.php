<?php

namespace App\Console\Commands;

use App\Models\Report\ReportJadwalIsiIBC;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SyncReportJadwalIsiIBCFromHana extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:reportJadwalIBC';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync report jadwal isi IBC data from HANA to local DB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $startDate = $this->argument('startDate') ?? Carbon::now()->startOfMonth()->format('d.m.Y');
        // $endDate = $this->argument('endDate') ?? Carbon::now()->endOfMonth()->format('d.m.Y');
        // $tahun = $this->argument('tahun') ?? Carbon::now()->year;
        // $bulan = $this->argument('bulan') ?? Carbon::now()->month;

        $this->info("Syncing data ...");

        $hanaData2 = DB::connection('hana')->select("SELECT 
                            CAST(\"MAINKEY\" AS NVARCHAR(255)) AS \"MAINKEY\",
                            CAST(\"FILLINGDATE\" AS DATE) AS \"FILLINGDATE\",
                            CAST(\"ORIGINCODE\" AS NVARCHAR(255)) AS \"ORIGINCODE\",
                            CAST(\"FRGNNAME\" AS NVARCHAR(255)) AS \"FRGNNAME\",
                            CAST(\"QTY\" AS NVARCHAR(255)) AS \"QTY\",
                            CAST(\"UOM\" AS NVARCHAR(255)) AS \"UOM\"
                        FROM LVKKJ_REP_JADWALPENGISIAN ()");
        ReportJadwalIsiIBC::truncate();
        foreach ($hanaData2 as $row) {
            ReportJadwalIsiIBC::create(
                [
                    'MAINKEY' => $row->MAINKEY, 
                    'FILLINGDATE' => $row->FILLINGDATE,
                    'ORIGINCODE' => $row->ORIGINCODE,
                    'FRGNNAME' => $row->FRGNNAME,
                    'QTY' => $row->QTY,
                    'UOM' => $row->UOM,
                    'updated_at'    => now(),
                ]
            );
        }

        // Logging hasil
        $this->info("Total data Report Jadwal Isi IBC (HANA): " . count($hanaData2));
        $this->info("Total data Report Jadwal Isi IBC (Laravel): " . ReportJadwalIsiIBC::count());
    }
}
