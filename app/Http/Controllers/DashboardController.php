<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdrLocal;
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
        // ambil semua divisi milik user
        $userDiv = $user->divisions->pluck('div_name');
        $userCab = $user->branches->pluck('branch_name');
        $date = now()->ToDateString();
        $month = now()->month;
        // dd($userDiv, $userCab);

        // $report = Report::whereIn('slug', $userRep)->orderBy('name', 'asc')->get();

        if ($user->role === 'salesman') {
            if ($user->oslpReg) {
                $slpCode = $user->oslpReg->RegSlpCode;
                $dailyOrder = OrdrLocal::where('is_deleted', 0)->where('OdrSlpCode', $slpCode)->whereDate('OdrDocDate', $date)->count();
                $dailyOrderSynced = OrdrLocal::where('is_deleted', 0)->where('is_synced', 1)->where('OdrSlpCode', $slpCode)->whereDate('OdrDocDate', $date)->count();
                $dailyOrderNotSyncedUncheck = OrdrLocal::where('is_deleted', 0)->where('is_checked', 0)->where('is_synced', 0)->where('OdrSlpCode', $slpCode)->whereDate('OdrDocDate', $date)->count();
                $monthlyOrder = OrdrLocal::where('is_deleted', 0)->where('OdrSlpCode', $slpCode)->whereMonth('OdrDocDate', $month)->count();
                $monthlyOrderSynced = OrdrLocal::where('is_deleted', 0)->where('is_synced', 1)->where('OdrSlpCode', $slpCode)->whereMonth('OdrDocDate', $month)->count();
                $monthlyOrderNotSyncedUncheck = OrdrLocal::where('is_deleted', 0)->where('is_checked', 0)->where('is_synced', 0)->where('OdrSlpCode', $slpCode)->whereMonth('OdrDocDate', $month)->count();
            } else {
                // kalau belum ada relasi, return collection kosong
                $dailyOrder = collect();
                $dailyOrderSynced = collect();
                $dailyOrderNotSyncedUncheck = collect();
                $monthlyOrder = collect();
                $monthlyOrderSynced = collect();
                $monthlyOrderNotSyncedUncheck = collect();
            }
        } else {
            $dailyOrder = OrdrLocal::where('is_deleted', 0)->whereIn('branch', $userCab)->whereDate('OdrDocDate', $date)
                        ->whereHas('orderRow', function($query) use($userDiv){
                            $query->whereIn('RdrItemProfitCenter', $userDiv);
                        })->count();
            $dailyOrderSynced = OrdrLocal::where('is_deleted', 0)->where('is_synced', 1)->whereIn('branch', $userCab)->whereDate('OdrDocDate', $date)
                        ->whereHas('orderRow', function($query) use($userDiv){
                            $query->whereIn('RdrItemProfitCenter', $userDiv);
                        })->count();
            $dailyOrderNotSyncedUncheck = OrdrLocal::where('is_deleted', 0)->where('is_checked', 0)->where('is_synced', 1)->whereIn('branch', $userCab)
                        ->whereDate('OdrDocDate', $date)->whereHas('orderRow', function($query) use($userDiv){
                            $query->whereIn('RdrItemProfitCenter', $userDiv);
                        })->count();
            $monthlyOrder = OrdrLocal::where('is_deleted', 0)->whereIn('branch', $userCab)->whereMonth('OdrDocDate', $month)
                        ->whereHas('orderRow', function($query) use($userDiv){
                            $query->whereIn('RdrItemProfitCenter', $userDiv);
                        })->count();
            $monthlyOrderSynced = OrdrLocal::where('is_deleted', 0)->where('is_synced', 1)->whereIn('branch', $userCab)->whereMonth('OdrDocDate', $month)
                        ->whereHas('orderRow', function($query) use($userDiv){
                            $query->whereIn('RdrItemProfitCenter', $userDiv);
                        })->count();
            $monthlyOrderNotSyncedUncheck = OrdrLocal::where('is_deleted', 0)->where('is_checked', 0)->where('is_synced', 1)->whereIn('branch', $userCab)
                        ->whereMonth('OdrDocDate', $month)->whereHas('orderRow', function($query) use($userDiv){
                            $query->whereIn('RdrItemProfitCenter', $userDiv);
                        })->count();
        }
        // dd($dailyOrder, $monthlyOrder);
        
        return view('dashboard.dashboard', [
            'title' => 'SCKKJ - Dasbor',
            'titleHeader' => 'Dasbor',
            'dailyOrder' => $dailyOrder,
            'dailyOrderSynced' => $dailyOrderSynced,
            'dailyOrderNotSyncedUncheck' => $dailyOrderNotSyncedUncheck,
            'monthlyOrder' => $monthlyOrder,
            'monthlyOrderSynced' => $monthlyOrderSynced,
            'monthlyOrderNotSyncedUncheck' => $monthlyOrderNotSyncedUncheck,
            'user' => $user
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

        SyncLog::create(
            [
                'name' => 'dashboard',
                'last_sync' => now(),
                'desc' => 'Manual'
            ]
        );

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
