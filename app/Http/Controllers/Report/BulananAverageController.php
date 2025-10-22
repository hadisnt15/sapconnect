<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report\ReportBulananAverage;
use App\Models\Report;
use App\Models\SyncLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BulananAverageController extends Controller
{
    public function index(Request $request) 
    {
        $report = Report::where('slug', 'bulanan-dan-average')->first();
        $monthInput = $request->input('month', now()->format('Y-m'));
        $segmentFilter = $request->input('segment'); // 🔹 Tambah filter segment
        $search = $request->input('search');

        // Pisahkan tahun dan bulan
        [$tahun, $bulan] = explode('-', $monthInput);

        // Ambil user dan role
        $user = auth()->user();
        $role = $user->role ?? null;

        // 🔹 Base query
        $query = DB::table('report_bulanan_average');

        // 🔹 Filter berdasarkan role user
        if ($role === 'salesman' && isset($user->oslpReg)) {
            $kodeSales = $user->oslpReg->RegSlpCode ?? null;
            if ($kodeSales) {
                $query->where('KODESALES', $kodeSales);
            }
        } elseif ($role === 'supervisor' && $user->divisions->isNotEmpty()) {
            $divisiList = $user->divisions->pluck('div_name')->toArray();
            $query->whereIn('DIVISI', $divisiList);
        }

        // 🔹 Filter berdasarkan segment (jika dipilih dari dropdown)
        if (!empty($segmentFilter)) {
            $query->where('SEGMENT', $segmentFilter);
        }

        // 🔹 Filter berdasarkan pencarian (search)
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('NAMACUSTOMER', 'like', "%{$search}%")
                ->orWhere('KODECUSTOMER', 'like', "%{$search}%")
                ->orWhere('NAMASALES', 'like', "%{$search}%")
                ->orWhere('KOTA', 'like', "%{$search}%")
                ->orWhere('PROVINSI', 'like', "%{$search}%");
            });
        }

        // 🔹 Urutan data
        $query->orderBy('SEGMENT')
            ->orderBy('ROWNUM')
            ->orderBy('NAMACUSTOMER');

        // 🔹 Ambil data dari DB lokal
        $data = $query->get();

        // Ambil divisi user
        $userDivisions = $user->divisions->pluck('div_name')->toArray();

        // Ambil segment dan divisi dari tabel, tapi hanya yang sesuai divisi user
        $segments = DB::table('report_bulanan_average')
            ->select('SEGMENT', 'DIVISI')
            ->when(!empty($userDivisions), function ($query) use ($userDivisions) {
                $query->whereIn('DIVISI', $userDivisions);
            })
            ->distinct()
            ->orderBy('SEGMENT')
            ->get();

        // 🔹 Ambil semua bulan unik (header kolom)
        $bulanHeaders = $query->get()->sortBy('NO')->pluck('NAMATAHUNBULAN')->unique()->values();

        // 🔹 Group data per customer + segment agar nilai bulannya bisa dipivot
        $customers = $data->groupBy(['SEGMENT', 'KODECUSTOMER'])
            ->flatMap(function ($segmentGroup, $segmentName) use ($bulanHeaders) {
                return $segmentGroup->map(function ($custGroup) use ($segmentName, $bulanHeaders) {
                    $first = $custGroup->first();
                    $cust = [
                        'SEGMENT' => $segmentName,
                        'ROWNUM' => $first->ROWNUM,
                        'KODECUSTOMER' => $first->KODECUSTOMER,
                        'NAMACUSTOMER' => $first->NAMACUSTOMER,
                        'NAMASALES' => $first->NAMASALES,
                        'PROVINSI' => $first->PROVINSI,
                        'KOTA' => $first->KOTA,
                        'DIVISI' => $first->DIVISI,
                    ];

                    foreach ($bulanHeaders as $bulan) {
                        $cust[$bulan] = optional(
                            $custGroup->firstWhere('NAMATAHUNBULAN', $bulan)
                        )->VALUE ?? '-';
                    }

                    return $cust;
                });
            })
            ->sortBy([
                ['SEGMENT', 'asc'],
                ['ROWNUM', 'asc'],
                ['NAMACUSTOMER', 'asc'],
            ])
            ->values();

        // 🔹 Pagination (60 baris per halaman)
        $perPage = 60;
        $page = request('page', 1);
        $pagedCustomers = new \Illuminate\Pagination\LengthAwarePaginator(
            $customers->forPage($page, $perPage),
            $customers->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // 🔹 Ambil periode & sinkronisasi terakhir
        $periode = ReportBulananAverage::select('tahun', 'bulan')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->first();

        $namaPeriode = $periode
            ? Carbon::createFromDate($periode->tahun, $periode->bulan, 1, 'Asia/Jakarta')
                ->locale('id')
                ->translatedFormat('F Y')
            : '-';

        $lastSync = SyncLog::where('name', 'report.bulanan-dan-average')
            ->orderByDesc('last_sync')
            ->first();

        // 🔹 Jika tidak ada data
        if ($customers->isEmpty()) {
            return view('reports.bulanan_dan_average', [
                'title' => 'SCKKJ - Laporan ' . $report->name,
                'titleHeader' => $report->name,
                'customers' => collect([]),
                'bulanHeaders' => $bulanHeaders,
                'segments' => $segments,
                'segmentFilter' => $segmentFilter,
                'tahun' => $tahun,
                'bulan' => $bulan,
                'namaPeriode' => '-',
                'lastSync' => $lastSync,
                'message' => 'Tidak ada data untuk periode ini.'
            ]);
        }

        return view('reports.bulanan_dan_average', [
            'title' => 'SCKKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'customers' => $pagedCustomers,
            'bulanHeaders' => $bulanHeaders,
            'segments' => $segments,
            'segmentFilter' => $segmentFilter,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'namaPeriode' => $namaPeriode,
            'lastSync' => $lastSync,
        ]);
    }

    public function refresh(Request $request)
    {
        $month = $request->input('month'); // misal "2025-08"
        $carbon = Carbon::createFromFormat('Y-m', $month);
        $tahun = $carbon->format('Y'); // 2025
        $bulan = $carbon->format('m'); // 08
        $startDate = Carbon::parse($month . '-01')->startOfMonth()->format('d.m.Y');
        $endDate   = Carbon::parse($month . '-01')->endOfMonth()->format('d.m.Y');
        Artisan::call('sync:reportBulananAverage', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);

        SyncLog::create(
            [
                'name' => 'report.bulanan-dan-average',
                'last_sync' => now(),
                'desc' => 'Manual'
            ]
        );

        return back()->with('success', 'Data Report Bulanan dan Average Berhasil Disinkronkan dari SAP');
    }
}
