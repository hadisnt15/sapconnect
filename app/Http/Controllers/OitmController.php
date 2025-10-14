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
            ->whereIn('div_name',$userDiv)
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
        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil daftar nama divisi user
        $userDivisions = DB::table('user_division')
            ->join('division', 'user_division.div_id', '=', 'division.id')
            ->where('user_division.user_id', $user->id)
            ->pluck('division.div_name');

        // Query item sesuai divisi user
        $query = OitmLocal::select(
            'ItemCode as id',
            'ItemCode',
            'FrgnName',
            'HET',
            'ProfitCenter',
            'Satuan',
            'KetHKN',
            'KetFG',
            DB::raw("
                CASE
                    WHEN div_name = 'SPR' THEN 
                        CONCAT(ItemCode, ' || ', Segment, ' || ', Type, ' || ', Series, ' || ', LEFT(FrgnName, 100), ' || ', KetStock)
                    WHEN div_name IN ('LUB RTL', 'LUB IDS') THEN
                        CONCAT(', LEFT(FrgnName, 100), ' || ', KetStock)
                    ELSE
                        CONCAT(ItemCode, ' || ', LEFT(FrgnName, 100), ' || ', KetStock)
                END AS ItemLabel
            ")
        );

        // Jika user punya divisi, filter berdasarkan div_name
        if ($userDivisions->isNotEmpty()) {
            $query->whereIn('div_name', $userDivisions);
        }

        // Eksekusi query dan kembalikan hasil
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
