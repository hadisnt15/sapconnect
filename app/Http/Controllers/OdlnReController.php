<?php

namespace App\Http\Controllers;

use App\Models\OdlnLocal;
use App\Models\OdlnReLocal;
use App\Models\SyncLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class OdlnReController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = OdlnReLocal::Filter(request(['search']));

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
        $reDeliveries = $query->with('mainOdln')->orderByDesc('no_sj')->paginate(100)->withQueryString();
        // dd($query);
        $lastSync = SyncLog::where('name', 'odln')->latest('last_sync')->first();;

        return view('odln.odln_re', [
            'title'       => 'SCKKJ - Daftar Pengiriman Ulang Surat Jalan',
            'titleHeader' => 'Daftar Pengiriman Ulang Surat Jalan',
            'reDeliveries'=> $reDeliveries,
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
        OdlnReLocal::query()->update(['is_checked' => 0]);

        // Update yang dicentang
        if (!empty($ids)) {
            OdlnReLocal::whereIn('id', $ids)->update(['is_checked' => 1]);
        }

        foreach ($notes as $id => $note) {
            OdlnReLocal::where('id', $id)->update([
                'ket' => $note,
                // 'is_checked'    => 1
            ]);
        }
        
        return redirect()->route('re.delivery')->with('success', 'Pengecekan pesanan berhasil diperbarui.');
    }

    public function push()
    {
        Artisan::call('push:odlnRe');
        // \App\Jobs\PushOrdrJob::dispatch();
        return back()->with('success', 'Data Pengiriman Ulang Surat Jalan Berhasil Di-push ke SAP');
    }
}
