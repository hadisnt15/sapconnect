<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OslpReg;
use App\Models\OslpLocal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;


class OslpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $slps = OslpLocal::Filter(request(['search']))->orderBy('SlpName')->paginate(20)->withQueryString();
        $slps = OslpReg::Filter(request(['search']))->paginate(10)->withQueryString();
        return view('oslp.oslp', [
            'title' => 'SCKKJ - Daftar Penjual',
            'titleHeader' => 'Daftar Penjual',
            'slps' => $slps,
        ]);
    }

    public function refresh()
    {
        Artisan::call('sync:oslp');
        return back()->with('success', 'Data Penjual Berhasil Di-refresh dari SAP');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('oslp.oslp_registration', [
            'title' => 'SCKKJ - Pendaftaran Penjual',
            'titleHeader' => 'Pendaftaran Penjual',
        ]); 
    }

    public function api()
    {
        return OslpLocal::whereNotIn('SlpCode', function($query) {
            $query->select('RegSlpCode')->from('oslp_reg');
        })->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'RegSlpCode' => [
                'required',
            ],
            'RegUserId' => [
                'required',
            ],
            'Alias' => [
                'required',
                'regex:/^[A-Z]{2}$/',
                'unique:oslp_reg,ALIAS'
            ]
        ], [
            'RegSlpCode.required' => 'Salesman wajib dipilih.',
            'RegUserId.required' => 'User wajib dipilih.',
            'Alias.required' => 'Alias wajib diisi.',
            'Alias.regex' => 'Nama hanya boleh berisi 2 huruf kapital.',
            'Alias.unique' => 'Alias sudah terdaftar.',
        ]);
        OslpReg::create($validated);
        return redirect('/penjual')->with('success',value: 'Pendaftaran penjual berhasil!');
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
