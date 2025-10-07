<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Dashboard;
use App\Models\SyncLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class PenjualanSprSalesController extends Controller
{
    public function index()
    {
        $report = Report::where('slug', 'pencapaian-penjualan-sparepart-per-sales')->first();
        $user = Auth::user();

        if ($user->role === 'salesman') {
            if ($user->oslpReg) {
                $slpCode = $user->oslpReg->RegSlpCode;
                $dashboard = Dashboard::where('KODESALES', $slpCode)
                    ->orderBy('NAMASALES')
                    ->orderBy('DOCENTRY')
                    ->orderBy('KEY3')
                    ->orderBy('TYPE')
                    ->get();
            } else {
                // kalau belum ada relasi, return collection kosong
                $dashboard = collect();
            }
        } else {
            $dashboard = Dashboard::orderBy('NAMASALES')->orderBy('DOCENTRY')->orderBy('KEY3')->orderBy('TYPE')->get();
        }
        $grouped = $dashboard->groupBy('NAMASALES')->map(function ($salesData) {
            return $salesData->groupBy('KEY3')->map(function ($segmentData) {
                return [
                    'rows' => $segmentData,
                    'sum_target' => $segmentData->sum('TARGET'),
                    'sum_capai' => $segmentData->sum('CAPAI'),
                    'sum_persentase' => $segmentData->avg('PERSENTASE'),
                ];
            });
        });
        $periode = Dashboard::select('tahun', 'bulan')
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
        
        return view('reports.penjualan_spr_sales', [
            'title' => 'SCKKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'grouped' => $grouped,
            'namaPeriode' => $namaPeriode,
            'lastSync' => $lastSync,
            'report' => $report
        ]);
    }
}
