<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report\ReportStokPtm;
use App\Models\SyncLog;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class StokPtmController extends Controller
{
    public function index(Request $request)
    {
        $report = Report::where('slug', 'stok-pertamina')->first();

        $search = trim($request->input('search', ''));

        $query = DB::table('report_stok_ptm')->select(
            'GUDANG', 'ORIGINCODE', 'FRGNNAME', 'SATUAN', 'STOK', 'ESTHABISSTOKBULAN', 
            'AVG3BULAN', 'OPENQTYAP', 'STOKPLUSOPENQTY', 'ESTHABISSTOKPLUSOPENBULAN'
        );

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('GUDANG', 'like', "%{$search}%")
                ->orWhere('ORIGINCODE', 'like', "%{$search}%")
                ->orWhere('FRGNNAME', 'like', "%{$search}%")
                ->orWhere('SATUAN', 'like', "%{$search}%");
            });
        }

        $data = $query
            ->orderBy('GUDANG')
            ->orderBy('FRGNNAME')
            ->get()
            ->groupBy(['GUDANG'])
            ->map(function ($groupStocks) {
                return [
                    'rows' => $groupStocks,
                    'TSTOK' => $groupStocks->sum('STOK'),
                    'TOPENQTYAP' => $groupStocks->sum('OPENQTYAP'),
                    'TSTOKPLUSOPENQTY' => $groupStocks->sum('STOKPLUSOPENQTY'),
                    'JBARANG' => $groupStocks->count('*'),
                ];
            });

        $lastSync = SyncLog::where('name', 'report.stok-pertamina')
            ->orderByDesc('last_sync')
            ->first();

        return view('reports.stok_ptm', [
            'title' => 'SCKKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'data' => $data,
            'lastSync' => $lastSync,
        ]);
    }

    public function refresh()
    {
        Artisan::call('sync:reportStokPtm');
        SyncLog::create(
            [
                'name' => 'report.stok-pertamina',
                'last_sync' => now(),
                'desc' => 'Manual'
            ]
        );
        return back()->with('success', 'Data Stok Pertamina Berhasil Di-refresh dari SAP');
    }
    
}
