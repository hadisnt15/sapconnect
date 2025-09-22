<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.user_registration', [
            'title' => 'SCKKJ - Daftarkan Pengguna',
            'titleHeader' => 'Daftarkan Pengguna',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    public function api()
    {
        
        return User::whereNotIn('id', function($query) {
            $query->select('RegUserId')->from('oslp_reg');
        })->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'username' => [
                'required',
                'string',
                'alpha_num',
                'min:4',
                'max:20',
                'unique:users,username'
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^(\+62|62|0)[0-9]{9,13}$/',
                'unique:users,phone'
            ],
            'email' => [
                // 'required', 
                // 'email', 
                // 'unique:users,email'
            ],
            // 'password' => [
            //     'required',
            //     'string',
            //     'min:8',
            //     'max:50',
            //     'regex:/[a-z]/',      // harus ada huruf kecil
            //     'regex:/[A-Z]/',      // harus ada huruf besar
            //     'regex:/[0-9]/',      // harus ada angka
            //     'regex:/[@$!%*#?&]/', // harus ada simbol
            // ],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
            'username.unique' => 'Username sudah terdaftar.',
            'phone.regex' => 'Nomor HP harus format Indonesia (contoh: 08xxxx / +628xxx).',
            //'password.regex' => 'Password minimal harus ada huruf besar, kecil, angka, dan simbol.',
        ]);

        // Simpan user baru
        $validated['password'] = bcrypt($request->phone);
        // $validated['role'] = 'salesman';
        // $validated['email'] = 'user@email.com';
        // dd($validated);

        User::create($validated);
        return redirect('/pengguna')->with('success',value: 'Pendaftaran Pengguna Berhasil!');
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
