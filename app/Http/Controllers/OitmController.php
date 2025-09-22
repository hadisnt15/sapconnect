<?php

namespace App\Http\Controllers;
use App\Models\OitmLocal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;

class OitmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $items = OitmLocal::Filter(request(['search']))
            ->orderBy('Segment')
            ->orderBy('Type')
            ->orderBy('Series')
            ->orderBy('ItemCode')
            ->paginate(80)->withQueryString();

        return view('oitm.oitm', [
            'title' => 'SCKKJ - Daftar Barang',
            'titleHeader' => 'Daftar Barang',
            'items' => $items,
        ]);
    }

    public function refresh()
    {
        Artisan::call('sync:oitm');
        return back()->with('success', 'Data Barang Berhasil Di-refresh dari SAP');
    }

    public function api()
    {
        return OitmLocal::select('ItemCode as id', 'ItemCode', 'ItemName', 'HET', 'ProfitCenter', 'Satuan', 'KetHKN', 'KetFG',
            DB::raw("CONCAT(ItemCode, ' || ', Segment, ' || ', Type, ' || ', Series, ' || ', LEFT(ItemName,100)) as ItemLabel"))->get();
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
