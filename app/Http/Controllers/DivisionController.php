<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\User;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function editUserDivision($userId)
    {
        $user = User::with('divisions')->findOrFail($userId);
        $divisions = Division::all();
        return view('user.user_division', [
            'title' => 'SCKKJ - Divisi Pengguna',
            'titleHeader' => 'Divisi Pengguna',
            'user' => $user,
            'divisions' => $divisions,
        ]);
    }

    public function updateUserDivision(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $user->divisions()->sync($request->divisions ?? []);

        return redirect('/pengguna')->with('success',value: 'Pembaruan Data Divisi Pengguna Berhasil!');
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
    public function show(Division $division)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Division $division)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Division $division)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        //
    }

    public function api()
    {
        return Division::all();
    }
}
