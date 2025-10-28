<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\Session;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $user = User::with(['divisions','branches'])->where('role', '!=', 'developer')->Filter(request(['search']))->paginate(100)->withQueryString();
        return view('user.user', [
            'title' => 'SCKKJ - Daftar Pengguna',
            'titleHeader' => 'Daftar Pengguna',
            'user' => $user
        ]);
    }

    public function activeUsers()
    {
        $session = Session::whereNotNull('user_id')->get();
        $users = $session->map(function ($session) {
            return [
                'user_id' => $session->user_id,
                'ip' => $session->ip_address,
                'last_activity' => \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                'user' => User::find($session->user_id)
            ];
        });

        return view('user.user_active', [
            'title' => 'SCKKJ - Pengguna Aktif',
            'titleHeader' => 'Pengguna Aktif',
            'user' => $users
        ]);
    }

    public function userDevice()
    {
        $devices = UserDevice::with('user')->get();

        return view('user.user_device', [
            'title' => 'SCKKJ - Perangkat Pengguna',
            'titleHeader' => 'Perangkat Pengguna',
            'devices' => $devices
        ]);
    }

    public function destroyUserDevice($id)
    {
        $device = UserDevice::findOrFail($id);
        $device->delete();

        return back()->with('success', 'Perangkat Pengguna Berhasil Dihapus.');
    }

    public function kickUser($id)
    {
        // dd("Masuk kickUser dengan ID: ".$id);
        $device = UserDevice::where('user_id', $id)->first();

        if ($device) {
            // kosongkan session_id → otomatis logout saat request berikutnya
            $device->update(['session_id' => null]);
        }

        return back()->with('success', 'Pengguna berhasil ditendang!');
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
        $user = User::findOrFail($id);
        // dd($user);
        return view('user.user_edit', [
            'title' => 'SCKKJ - Perbarui Pengguna',
            'titleHeader' => 'Perbarui Pengguna',
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
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
                // 'unique:users,username'
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^(\+62|62|0)[0-9]{9,13}$/',
                // 'unique:users,phone'
            ],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
            // 'username.unique' => 'Username sudah terdaftar.',
            'phone.regex' => 'Nomor HP harus format Indonesia (contoh: 08xxxx / +628xxx).',
        ]);
        $user->update($request->all());
        return redirect('/pengguna')->with('success',value: 'Pembaruan Data Pengguna Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function api()
    {
        return User::all();
    }
}
