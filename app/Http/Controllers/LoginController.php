<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserDevice;
use Jenssegers\Agent\Agent;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login', [
            'title' => 'SCKKJ - Masuk',
            'titleHeader' => 'Masuk',
        ]);
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // jika gagal masuk
        if (! Auth::attempt($credentials)) {
            return back()->with('success','Gagal Masuk!');
        }
        $user = Auth::user();
        if ($user->is_active == 0) {
            Auth::logout();
            return back()->with('success','Pengguna Tidak Aktif!');
        }

        //jika berhasil masuk
        $request->session()->regenerate();

        //ambil info agent
        $agent = new Agent();
        $agent->setUserAgent($request->header('User-Agent'));

        $ip = $request->ip();
        $ua = $request->header('User-Agent', '');

        //device_id sederhana
        $deviceId = hash('sha256', $ip . '|' . $ua);
        $userId = Auth::id();
        $sessionId = session()->getId();

        $registeredDevice = UserDevice::where('user_id', $userId)->first();
        // $same = $existingDevices->firstWhere('device_id', $deviceId);
        if (! $registeredDevice) {
            // login pertama → daftarkan device
            UserDevice::create([
                'user_id'   => $userId,
                'device_id' => $deviceId,
                'session_id'=> $sessionId,
                'ip'        => $ip,
                'device'    => $agent->device() ?: $agent->platform(),
                'platform'  => $agent->platform(),
                'browser'   => $agent->browser(),
                'last_active' => now(),
            ]);
        } else {
            if (Auth::check() && Auth::user()->role === 'salesman') {
                if ($registeredDevice->device_id != $deviceId) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return back()->with('error', 'Perangkat Ini Tidak Terdaftar untuk Akun Anda!');
                }
            }

            $registeredDevice->update([
                'session_id' => $sessionId,
                'ip' => $ip,
                'last_active' => now()
            ]);
        }


        UserDevice::where('user_id', $userId)->where('device_id', $deviceId)->update([
            'session_id' => $sessionId,
            'ip' => $ip,
            'device' => $agent->device() ?: $agent->platform(),
            'platform' => $agent->platform(),
            'browser' => $agent->browser(),
            'last_active' => now(),
        ]);
            
        $request->session()->put('user_id', $userId);
        return redirect()->intended('/');

        // return back()->with('success','Gagal Masuk!');
    }
    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
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
