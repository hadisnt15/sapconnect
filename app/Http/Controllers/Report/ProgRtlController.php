<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report\ReportProgRtl;
use App\Models\Report;
use App\Models\SyncLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProgRtlController extends Controller
{
    public function index(Request $request)
    {
        $report = Report::where('slug', 'program-retail')->first();
        $monthInput = $request->input('month', now()->format('Y-m'));
        $search = $request->input('search');
        $filter = $request->input('filter');

        // Pisahkan tahun dan bulan
        [$tahun, $bulan] = explode('-', $monthInput);

        // Ambil user dan role
        $user = auth()->user();

        $progRtl = ReportProgRtl::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('DMS', 'like', "%{$search}%")
                ->orWhere('KODECUSTOMER', 'like', "%{$search}%")
                ->orWhere('NAMACUSTOMER', 'like', "%{$search}%")
                ->orWhere('SEGMENT', 'like', "%{$search}%")
                ->orWhere('PROGRAM', 'like', "%{$search}%");
            });
        })
        ->when($filter, function ($query,  $filter) {
            $query->where('KETERANGAN', $filter);
        })
        ->orderBy('DMS')
        ->get();

        // Group data per customer UUID
        $grouped = $progRtl->groupBy('UUID')->map(function ($custData) {
            $first = $custData->first();
            return [
                'header' => "{$first->DMS} - {$first->KODECUSTOMER}",
                'header2' => "{$first->NAMACUSTOMER}",
                'programs' => $custData->groupBy('PROGRAM')->map(function ($progData) {
                    $firstProg = $progData->first();
                    return [
                        'status' => $firstProg->STATUS,
                        'details' => $progData->sortBy('SEGMENT')->map(function ($item) {
                            return [
                                'segment' => $item->SEGMENT,
                                'target' => $item->TARGET,
                                'liter' => $item->LITER,
                                'persentase' => $item->PERSENTASE,
                                'sisa' => $item->SISA,
                                'keterangan' => $item->KETERANGAN,
                            ];
                        }),
                    ];
                }),
            ];
        });
        // 🔹 Urutkan agar customer dengan program "TERDAFTAR" muncul duluan
        $sorted = $grouped->sortByDesc(function ($cust) {
            // Jika customer punya minimal 1 program TERDAFTAR, beri nilai 1
            return collect($cust['programs'])->contains(fn($prog) => strtoupper($prog['status']) === 'TERDAFTAR') ? 1 : 0;
        });

        // 🔹 Pagination manual
        $perPage = 60;
        $page = request()->get('page', 1);
        $pagedData = $sorted->slice(($page - 1) * $perPage, $perPage);

        $paginatedGrouped = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedData,
            $sorted->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $summary = ReportProgRtl::select('PROGRAM', 'SEGMENT', 'KETERANGAN', DB::raw('COUNT(*) AS JUMLAH'))
                        ->groupBy('PROGRAM', 'SEGMENT', 'KETERANGAN')
                        ->orderBy('PROGRAM')
                        ->orderBy('SEGMENT')
                        ->orderByRaw("FIELD(KETERANGAN, 'TERCAPAI', 'BELUM TERCAPAI', 'TARGET TIDAK ADA', 'BELUM TERDAFTAR')")
                        ->get();
        
        $groupedSum = $summary->groupBy('PROGRAM')->map(function ($program) {
            $firstProgram = $program->first();
            $order = ['TERCAPAI', 'BELUM TERCAPAI', 'TARGET TIDAK ADA', 'BELUM TERDAFTAR'];
            return [
                'headerProg' => "{$firstProgram->PROGRAM}",
                'segment' => $program->groupBy('SEGMENT')->map(function ($segment) use ($order) {
                    $details = $segment->sortBy(function ($row) use ($order) {
                    return array_search(strtoupper($row->KETERANGAN), $order);
                    })->map(function ($ket) {
                        return [
                            'segment' => $ket->SEGMENT,
                            'keterangan' => $ket->KETERANGAN,
                            'jumlah' => $ket->JUMLAH,
                        ];
                    });
                    // total jumlah semua keterangan di segment tsb
                    $totalSegment = $details->sum('jumlah');

                    return [
                        'details' => $details,
                        'total' => $totalSegment,
                    ];
                }),
            ];
        });

        $programSegment = ReportProgRtl::select('PROGRAM','SEGMENT')->distinct()->orderBy('PROGRAM')->orderBy('SEGMENT')->get();
        $countSegment = $programSegment->groupBy('PROGRAM')->map(function ($segments, $program) {
            return [
                'program' => $program,
                'jumlah_segment' => $segments->count(),
                'segments' => $segments->pluck('SEGMENT'), // untuk isi grid
            ];
        });

        $periode = ReportProgRtl::select('tahun', 'bulan')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->first();
        $namaPeriode = null;
        if ($periode) {
            $namaPeriode = Carbon::createFromDate($periode->tahun, $periode->bulan, 1, 'Asia/Jakarta')
                ->locale('id')
                ->translatedFormat('F Y');
        }

        $lastSync = SyncLog::where('name', 'report.program-retail')->orderByDesc('last_sync')->first();

        return view('reports.prog_rtl', [
            'title' => 'SCKKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'grouped' => $paginatedGrouped,
            'search' => $search,
            'filter' => $filter,
            'namaPeriode' => $namaPeriode,
            'lastSync' => $lastSync,
            'groupedSum' => $groupedSum,
            'countSegment' => $countSegment,
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
        Artisan::call('sync:reportProgRtl', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);

        SyncLog::create(
            [
                'name' => 'report.program-retail',
                'last_sync' => now(),
                'desc' => 'Manual'
            ]
        );

        return back()->with('success', 'Data Dasbor Berhasil Disinkronkan dari SAP');
    }
}
