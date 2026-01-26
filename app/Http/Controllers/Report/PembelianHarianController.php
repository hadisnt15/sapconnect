<?php

namespace App\Http\Controllers\Report;

use App\Models\Report;
use App\Models\SyncLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Models\Report\ReportPembelianHarian;
use App\Models\Report\ReportPembelianHarianDetail;

class PembelianHarianController extends Controller
{
    public function index(Request $request) 
    {
        $report = Report::where('slug', 'pembelian-harian')->first();
        $date = $request->input('date', now()->format('Y-m-d'));

        $data = ReportPembelianHarianDetail::where('TANGGAL', $date)
            ->orderBy('TIPE', 'desc')
            ->orderBy('SEGMENT')
            ->get()
            ->groupBy('TIPE')
            ->map(function ($rowsByTipe) {
                return $rowsByTipe
                    ->groupBy('SEGMENT')
                    ->map(function ($rowsBySegment) {
                        return [
                            'ket_periode' => $rowsBySegment->first()->KETPERIODE,
                            'total_kl' => $rowsBySegment->first()->KILOLITER,
                            'ket_uom' => $rowsBySegment->first()->KETQTYUOM,
                            'items' => $rowsBySegment
                                ->sortBy([
                                    ['UOMCODE', 'asc'],
                                    ['QTY', 'desc'],
                                    ['FRGNNAME', 'asc'],
                                ])    
                                ->map(function ($row) {
                                    return (object) [
                                        'FRGNNAME' => $row->FRGNNAME,
                                        'QTY' => $row->QTY,
                                        'UOMCODE' => $row->UOMCODE,
                                    ];
                                })
                                ->values(),
                        ];
                    });
            });
        $date2 = Carbon::parse($date)->translatedFormat('d M Y');

        $lastSync = SyncLog::where('name', 'report.pembelian-harian')->orderByDesc('last_sync')->first();

        if ($data->isEmpty()) {
            return view('reports.pembelian_harian', [
                'title' => 'SCKKJ - Laporan ' . $report->name,
                'titleHeader' => $report->name,
                'data' => collect([]),
                'date' => $date,
                'lastSync' => $lastSync,
                'message' => 'Tidak ada data untuk periode ini.'
            ]);
        }

        return view('reports.pembelian_harian', [
            'title' => 'SCKKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'data' => $data,
            'date' => $date2,
            'lastSync' => $lastSync,
        ]);

    }

    public function refresh(Request $request)
    {
        Artisan::call('sync:reportBeliHarian');
        SyncLog::create(
            [
                'name' => 'report.pembelian-harian',
                'last_sync' => now(),
                'desc' => 'Manual'
            ]
        );

        return back()->with('success', 'Data Pembelian Berhasil Disinkronkan dari SAP');
    }
}
