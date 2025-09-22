<?php

namespace App\Http\Controllers;

use App\Models\OcrdLocal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OcrdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        // dd(Auth::user()->role);
        $custs = OcrdLocal::Filter(request(['search']))->orderBy('CreateDate')->orderBy('CardName')->paginate(80)->withQueryString();
        return view('ocrd.ocrd', [
            'title' => 'SCKKJ - Daftar Pelanggan',
            'titleHeader' => 'Daftar Pelanggan',
            'custs' => $custs,
            // 'newCusts' => $newCusts,
        ]);
    }

    public function refresh()
    {
        Artisan::call('sync:ocrd');
        return back()->with('success', 'Data Pelanggan Berhasil Di-refresh dari SAP');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ocrd.ocrd_registration', [
            'title' => 'SCKKJ - Buat Pelanggan',
            'titleHeader' => 'Buat Pelanggan',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'CardCode' => [
                'required',
                'unique:ocrd_local,CardCode'
            ],
            'CardName' => [
                'required',
            ],
            'State' => [
                'required',
            ],
            'City' => [
                'required',
            ],
            'Address' => [
                'required',
            ],
            'Contact' => [
                'required',
            ],
            'Phone' => [
                'required',
                'min:10'
            ],
            'Type1' => [
                'required'
            ],
            'created_by' => [
                'required'
            ],
            'NIK' => [
                'nullable','digits:16'
            ]
        ], [
            'CardCode.required' => 'Kode Pelanggan Wajib Diisi.',
            'CardName.required' => 'Nama Pelanggan Wajib Diisi.',
            'State.required' => 'Provinsi Wajib Diisi.',
            'City.required' => 'Kota/Kab Wajib Diisi.',
            'Address.required' => 'Alamat Wajib Diisi.',
            'Contact.required' => 'Kontak Wajib Diisi.',
            'Phone.required' => 'Telepon Wajib Diisi.',
            'CardCode.unique' => 'Kode Pelanggan Sudah Terdaftar.',
            'NIK.digits' => 'NIK Harus 16 Digit.'
        ]);
        // dd($validated);
        OcrdLocal::create($validated);
        return redirect('/pelanggan')->with('success',value: 'Pendaftaran Pelanggan Baru Berhasil!');
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
    public function edit(string $CardCode)
    {
        $cust = OcrdLocal::where('CardCode',$CardCode)->where('Type1','PELANGGAN BARU')->first();
        if (Gate::denies('customer.edit', $cust)) {
            abort(403,'UNAUTHORIZED :P');
        }
        // dd($cust);
        return view('ocrd.ocrd_edit', [
            'title' => 'SCKKJ - Perbarui Pelanggan',
            'titleHeader' => 'Perbarui Pelanggan',
            'cust' => $cust
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $CardCode)
    {
        $cust = OcrdLocal::where('CardCode',$CardCode)->where('Type1','PELANGGAN BARU')->first();
        $request->validate([
            'CardName' => [
                'required',
            ],
            'State' => [
                'required',
            ],
            'City' => [
                'required',
            ],
            'Address' => [
                'required',
            ],
            'Contact' => [
                'required',
            ],
            'Phone' => [
                'required',
                'min:10'
            ],
            'Type1' => [
                'required'
            ],
        ], [
            'CardName.required' => 'Nama Pelanggan Wajib Diisi.',
            'State.required' => 'Provinsi Wajib Diisi.',
            'City.required' => 'Kota/Kab Wajib Diisi.',
            'Address.required' => 'Alamat Wajib Diisi.',
            'Contact.required' => 'Kontak Wajib Diisi.',
            'Phone.required' => 'Telepon Wajib Diisi.',
        ]);
        $cust->update($request->all());
        return redirect('/pelanggan')->with('success',value: 'Pembaruan Data Pelanggan Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
