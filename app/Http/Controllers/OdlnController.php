<?php

namespace App\Http\Controllers;

use App\Models\OdlnLocal;
use App\Models\OdlnReLocal;
use App\Models\SyncLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class OdlnController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = OdlnLocal::Filter(request(['search']));

        // 🔹 Filter pencarian (jika ada scopeFilter)
        $query->filter($request->only(['search']));

        // 🔹 Filter status checkbox
        if ($request->has('checked')) {
            switch ($request->checked) {
                case '1': $query->where('is_checked', 1); break;
                case '0': $query->where('is_checked', 0); break;
                case '2': $query->where('is_synced', 1); break;
                case '3': $query->where('is_synced', 0); break;
            }
        }

        // 🔹 Filter tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('tgl_sj', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('tgl_sj', '<=', $request->date_to);
        }

        // ✅ Pagination
        $deliveries = $query->orderByDesc('no_sj')->paginate(100)->withQueryString();
        // dd($query);
        $lastSync = SyncLog::where('name', 'odln')->latest('last_sync')->first();;

        return view('odln.odln', [
            'title'       => 'SCKKJ - Daftar Surat Jalan',
            'titleHeader' => 'Daftar Surat Jalan',
            'deliveries'      => $deliveries,
            'user'        => $user,
            'lastSync'    => $lastSync,
        ]);
    }

    public function updateChecked(Request $request)
    {
        $ids = $request->input('is_checked', []);
        $notes = $request->input('notes', []);
        
        // Role selain salesman (misal developer, admin)
        // Reset semua
        OdlnLocal::query()->update(['is_checked' => 0]);

        // Update yang dicentang
        if (!empty($ids)) {
            OdlnLocal::whereIn('id', $ids)->update(['is_checked' => 1]);
        }

        foreach ($notes as $id => $note) {
            OdlnLocal::where('id', $id)->update([
                'ket' => $note,
                'waktu_proses' => now(),
                // 'is_checked'    => 1
            ]);
        }
        
        return redirect()->route('delivery')->with('success', 'Pengecekan pesanan berhasil diperbarui.');
    }

    public function allowReturn($id)
    {
        $delivery = OdlnLocal::findOrFail($id);

        if (!in_array(auth()->user()->role, ['developer', 'manager','warehouse'])) {
            abort(403, 'Tidak punya akses');
        }

        $kirim_ke = OdlnReLocal::where('no_sj', $delivery->no_sj)->count();

        OdlnReLocal::create([
            'no_sj' => $delivery->no_sj,
            'is_checked' => 0,
            'is_synced' => 0,
            'ket' => null,
            'kirim_ke' => $kirim_ke + 1
        ])->save();

        return back()->with('success', 'Izin Pengiriman Ulang SJ Dibuka');
    }

    public function push()
    {
        Artisan::call('push:odln');
        // \App\Jobs\PushOrdrJob::dispatch();
        return back()->with('success', 'Data Surat Jalan Berhasil Di-push ke SAP');
    }

    public function refresh()
    {
        Artisan::call('sync:odln');
        SyncLog::create([
            'name' => 'odln',
            'desc' => 'Manual',
            'last_sync' => now()
        ]);
        return back()->with('success', 'Data Surat Jalan Berhasil Di-refresh dari SAP');
    }
}
