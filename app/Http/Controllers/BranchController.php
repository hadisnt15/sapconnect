<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\User;

class BranchController extends Controller
{
    public function editUserBranch($userId)
    {
        $user = User::with('branches')->findOrFail($userId);
        $branches = Branch::all();
        return view('user.user_branch', [
            'title' => 'SCKKJ - Cabang Pengguna',
            'titleHeader' => 'Cabang Pengguna',
            'user' => $user,
            'branches' => $branches,
        ]);
    }

    public function updateUserBranch(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $user->branches()->sync($request->branches ?? []);

        return redirect('/pengguna')->with('success',value: 'Pembaruan Data Cabang Pengguna Berhasil!');
    }

}
