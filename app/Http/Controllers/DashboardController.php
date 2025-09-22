<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard;
use App\Models\Dashboard2;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $this->authorize('dashboard.refresh');
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
        $dashboard2 = Dashboard2::orderBy('KEYPROFITCENTER')->get();
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
        
        return view('dashboard.dashboard', [
            'title' => 'SCKKJ - Dasbor',
            'titleHeader' => 'Dasbor',
            'grouped' => $grouped,
            'dashboard2' => $dashboard2,
            'namaPeriode' => $namaPeriode
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
        Artisan::call('sync:dashboard', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);
        return back()->with('success', 'Data Dasbor Berhasil Disinkronkan dari SAP');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
