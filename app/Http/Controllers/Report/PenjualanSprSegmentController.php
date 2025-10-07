<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Dashboard2;
use App\Models\SyncLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class PenjualanSprSegmentController extends Controller
{
    public function index()
    {
        $report = Report::where('slug', 'pencapaian-penjualan-sparepart-per-segment')->first();
        $dashboard2 = Dashboard2::orderBy('KEYPROFITCENTER')->get();
        $periode = Dashboard2::select('tahun', 'bulan')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->first();
        $namaPeriode = null;
        if ($periode) {
            $namaPeriode = Carbon::createFromDate($periode->tahun, $periode->bulan, 1, 'Asia/Jakarta')
                ->locale('id')
                ->translatedFormat('F Y');
        }
        $lastSync = SyncLog::where('name', 'dashboard')->orderByDesc('last_sync')->first();
        
        return view('reports.penjualan_spr_segment', [
            'title' => 'SCKKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'dashboard2' => $dashboard2,
            'namaPeriode' => $namaPeriode,
            'lastSync' => $lastSync,
        ]);
    }
}
