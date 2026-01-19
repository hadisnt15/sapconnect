<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $this->authorize('dashboard.refresh');
        $user = Auth::user();
        // ambil semua divisi milik user
        $userRep = $user->reports->pluck('slug');

        $report = Report::whereIn('slug', $userRep)
            ->addSelect('*', DB::raw('DATEDIFF(NOW(), created_at) AS selisih_hari'))
            ->orderBy('name', 'asc')
            ->Filter(request(['search']))
            ->paginate(100)
            ->withQueryString();

        
        return view('reports.report', [
            'title' => 'SCKKJ - Daftar Laporan',
            'titleHeader' => 'Daftar Laporan',
            'report' => $report,
        ]);
    }

    public function api()
    {
        return Report::all();
    }

    public function editUserReport($userId)
    {
        $user = User::with('reports')->findOrFail($userId);
        $reports = Report::all();
        return view('user.user_report', [
            'title' => 'SCKKJ - Laporan Pengguna',
            'titleHeader' => 'Laporan Pengguna',
            'user' => $user,
            'reports' => $reports,
        ]);
    }

    public function updateUserReport(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $user->reports()->sync($request->reports ?? []);

        return redirect('/pengguna')->with('success',value: 'Pembaruan Data Laporan Pengguna Berhasil!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reports.report_create', [
            'title' => 'SCKKJ - Buat Laporan',
            'titleHeader' => 'Buat Laporan',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:reports,name',
            'description' => 'required|string|',
        ]);
        $slug = Str::slug($validated['name']);
        $route = 'report.' . $slug;

        Report::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'slug' => $slug,
            'route' => $route,
        ]);
        return redirect('/laporan')->with('success',value: 'Pendaftaran Laporan Baru Berhasil!');
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
        $report = Report::findOrFail($id);

        return view('reports.report_edit', [
            'title' => 'SCKKJ - Perbarui Laporan',
            'titleHeader' => 'Perbarui Laporan',
            'report' => $report,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $report = Report::findOrFail($id);
        $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'category' => [
                'required',
                'in:Penjualan Semua,Penjualan IDS,Penjualan RTL,Penjualan IDP,Pembelian,Persediaan,Piutang,Lain-lain',
            ],
            'description' => [
                'required',
                'string'
            ],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
        ]);
        $report->update($request->all());
        return redirect('/laporan')->with('success',value: 'Pembaruan Data Laporan Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
