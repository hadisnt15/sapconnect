<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Report;

class GrafikPenjualanSalesController extends Controller
{
    public function index(Request $request)
    {
        $report = Report::where('slug', 'grafik-penjualan-harian-sales')->first();
        $monthInput = $request->input('month', now()->format('Y-m'));

        // Pisahkan tahun dan bulan
        [$tahun, $bulan] = explode('-', $monthInput);

        // Ambil user dan role
        $user = auth()->user();
        $role = $user->role ?? null;

        // Ambil semua divisi user (bisa lebih dari satu)
        $userDivisions = DB::table('user_division')
            ->where('user_id', $user->id)
            ->pluck('div_id')
            ->toArray();

        // 🔹 Ambil kode salesman milik user login (jika ada)
        $userSalesCode = DB::table('oslp_reg')
            ->where('RegUserId', $user->id)
            ->value('RegSlpCode');

        // Query utama
        $query = DB::table('ordr_local as o')
            ->join('oslp_local as s', 'o.OdrSlpCode', '=', 's.SlpCode')
            ->leftJoin('oslp_reg as r', 's.SlpCode', '=', 'r.RegSlpCode')
            ->leftJoin('users as u', 'r.RegUserId', '=', 'u.id')
            ->leftJoin('user_division as ud', 'u.id', '=', 'ud.user_id')
            ->leftJoin('division as d', 'ud.div_id', '=', 'd.id')
            ->selectRaw('
                DATE(o.OdrDocDate) as tanggal,
                s.SlpName as salesman,
                COALESCE(d.div_name, "Tanpa Divisi") as divisi,
                COUNT(*) as total_so
            ')
            ->whereYear('o.OdrDocDate', $tahun)
            ->whereMonth('o.OdrDocDate', $bulan)
            ->where('o.is_deleted', '=', 0);

        // Filter berdasarkan role
        if ($role === 'salesman' && $userSalesCode) {
            // Salesman hanya bisa melihat data miliknya
            $query->where('o.OdrSlpCode', $userSalesCode);
        } elseif ($role === 'supervisor' && !empty($userDivisions)) {
            // Supervisor hanya melihat divisi yang ia miliki
            $query->whereIn('d.id', $userDivisions);
        }

        $data = $query
            ->groupBy('tanggal', 'salesman', 'divisi')
            ->orderBy('tanggal', 'asc')
            ->get();
        dd($query);
        // Ambil list unique sales dan tanggal
        $salesList = $data->pluck('salesman')->unique()->values();
        $tanggalList = $data->pluck('tanggal')->unique()->values();

        // Susun data untuk chart
        $chartData = [];
        foreach ($salesList as $sales) {
            $chartData[] = [
                'name' => $sales,
                'data' => $tanggalList->map(fn($tgl) =>
                    (int) ($data->firstWhere(fn($row) => $row->tanggal == $tgl && $row->salesman == $sales)->total_so ?? 0)
                ),
            ];
        }

        return view('reports.grafik_harian_sales', [
            'title' => 'SCKKJ - Laporan ' . $report->name,
            'titleHeader' => $report->name,
            'tanggalList' => $tanggalList,
            'chartData' => $chartData,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);
    }
}
