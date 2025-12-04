<?php

namespace App\Http\Controllers;
use App\Models\OitmLocal;
use App\Models\SyncLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class OitmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $user = auth()->user();
        // ambil semua divisi milik user
        $userDiv = $user->divisions->pluck('div_name');
        $items = OitmLocal::Filter(request(['search']))
            ->where('TotalStock','>',0)
            ->whereIn('div_name',$userDiv)
            ->orderBy('div_name')
            ->orderBy('Brand')
            ->orderBy('Segment')
            ->orderBy('Type')
            ->orderBy('Series')
            ->orderBy('ItemCode')
            ->paginate(100)->withQueryString();
        
        $lastSync = SyncLog::where('name', 'oitm')->orderByDesc('last_sync')->first();

        return view('oitm.oitm', [
            'title' => 'SCKKJ - Daftar Barang',
            'titleHeader' => 'Daftar Barang',
            'items' => $items,
            'lastSync' => $lastSync
        ]);
    }

    public function refresh()
    {
        Artisan::call('sync:oitm');
        SyncLog::create(
            [
                'name' => 'oitm',
                'last_sync' => now(),
                'desc' => 'Manual'
            ]
        );
        return back()->with('success', 'Data Barang Berhasil Di-refresh dari SAP');
    }

    public function api()
    {
        $user = Auth::user();

        // Ambil daftar divisi user
        $userDivisions = DB::table('user_division')
            ->join('division', 'user_division.div_id', '=', 'division.id')
            ->where('user_division.user_id', $user->id)
            ->pluck('division.div_name');

        // Subquery T1 (item yang sedang dipesan, belum sync, belum delete)
        $subT1 = DB::table('oitm_local as a')
            ->select(
                'a.ItemCode',
                DB::raw("COUNT(*) OVER(PARTITION BY a.ItemCode) AS Cek")
            )
            ->join('rdr1_local as b', 'b.RdrItemCode', '=', 'a.ItemCode')
            ->join('ordr_local as c', 'c.id', '=', 'b.OdrId')
            ->where('c.is_deleted', 0)
            ->where('c.is_synced', 0);

        // Main query sesuai SQL Anda
        $query = OitmLocal::from('oitm_local as T0')
            ->select(
                'T0.ItemCode as id',
                'T0.ItemCode',
                'T0.FrgnName',
                'T0.HET',
                'T0.TotalStock',
                'T0.ProfitCenter',
                'T0.Satuan',
                'T0.KetHKN',
                'T0.KetFG',
                DB::raw("
                    CASE
                        WHEN T0.div_name = 'SPR' THEN 
                            CONCAT(T0.ItemCode, ' || ', T0.Segment, ' || ', T0.Type, ' || ', T0.Series, ' || ', LEFT(T0.FrgnName, 100), ' || ', T0.KetStock)
                        WHEN T0.div_name IN ('LUB RTL', 'LUB IDS') THEN
                            CONCAT(T0.ItemCode, ' || ', LEFT(T0.FrgnName, 100), ' || ', T0.KetStock)
                        ELSE
                            CONCAT(T0.ItemCode, ' || ', LEFT(T0.FrgnName, 100), ' || ', T0.KetStock)
                    END AS ItemLabel
                "),
                // Cek logic
                DB::raw("
                    CASE
                        WHEN T0.TotalStock != 0 THEN 1
                        ELSE (
                            CASE 
                                WHEN T1.Cek IS NOT NULL THEN 1
                                ELSE 0
                            END
                        )
                    END AS Cek
                ")
            )
            ->leftJoinSub($subT1, 'T1', function ($join) {
                $join->on('T1.ItemCode', '=', 'T0.ItemCode');
            })
            ->where(function ($q) {
                $q->where('T0.TotalStock', '!=', 0)
                ->orWhereNotNull('T1.Cek');
            });

        // Filter berdasarkan divisi user
        if ($userDivisions->isNotEmpty()) {
            $query->whereIn('T0.div_name', $userDivisions);
        }

        // Hanya ambil item yang valid sesuai kondisi (Cek = 1)
        $query->having('Cek', '=', 1);

        return $query->get();
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
