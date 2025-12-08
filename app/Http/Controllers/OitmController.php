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
        // Ambil user
        $user = Auth::user();

        // Divisi user
        $userDivisions = DB::table('user_division')
            ->join('division', 'user_division.div_id', '=', 'division.id')
            ->where('user_division.user_id', $user->id)
            ->pluck('division.div_name');

        // ==========================
        // SUBQUERY 1 — BRAND PERTAMINA
        // ==========================
        $pertaminaSub = DB::table('oitm_local as T0')
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

                // ITEM LABEL
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

                // CEK
                DB::raw("
                    CASE 
                        WHEN T1.ItemCode IS NOT NULL THEN 1
                        ELSE (CASE WHEN T0.TotalStock > 0 THEN 1 ELSE 0 END)
                    END AS Cek
                ")
            )
            ->leftJoin(DB::raw("
                (
                    SELECT T0.ItemCode
                    FROM oitm_local T0
                    JOIN rdr1_local T1 ON T1.RdrItemCode = T0.ItemCode
                    JOIN ordr_local T2 ON T2.id = T1.OdrId
                    WHERE T2.is_deleted = 0 
                    AND T2.is_synced = 0 
                    AND T0.Brand = 'PERTAMINA'
                ) AS T1
            "), 'T1.ItemCode', '=', 'T0.ItemCode')
            ->where('T0.Brand', '=', 'PERTAMINA');

        // Filter divisi user
        if ($userDivisions->isNotEmpty()) {
            $pertaminaSub->whereIn('T0.div_name', $userDivisions);
        }

        // ==========================
        // SUBQUERY 2 — BRAND NON-PERTAMINA
        // ==========================
        $nonPertaminaSub = DB::table('oitm_local as T0')
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

                // Item Label
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

                // Cek = 1
                DB::raw("1 AS Cek")
            )
            ->where('T0.Brand', '!=', 'PERTAMINA');

        // Filter divisi user
        if ($userDivisions->isNotEmpty()) {
            $nonPertaminaSub->whereIn('T0.div_name', $userDivisions);
        }

        // ==========================
        // UNION ALL
        // ==========================
        $union = $pertaminaSub->unionAll($nonPertaminaSub);

        $final = DB::query()
            ->fromSub($union, 'X')
            ->where('Cek', 1)
            ->orderBy('ItemLabel')
            ->get();

        return $final;
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
