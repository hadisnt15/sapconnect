<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\OcrdLocal;
use App\Models\OitmLocal;
use App\Models\OrdrLocal;
use App\Models\Rdr1Local;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;

class OrdrController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'salesman') {
            if ($user->oslpReg) {
                $slpCode = $user->oslpReg->RegSlpCode;
                $orders = OrdrLocal::with(['customer','salesman'])->where('is_deleted',0)->where('OdrSlpCode', $slpCode)->filter(request(['search']))->orderBy('OdrDocDate','desc')->orderBy('OdrNum')->paginate(20)->withQueryString();
            } else {
                // kalau belum ada relasi, return collection kosong
                $slpCode = optional($user->oslpReg)->RegSlpCode;
                $orders = OrdrLocal::with(['customer','salesman'])->where('is_deleted',0)->where('OdrSlpCode', $slpCode)->filter(request(['search']))->orderBy('OdrDocDate','desc')->orderBy('OdrNum')->paginate(20)->withQueryString();
            }
        } else {
            $orders = OrdrLocal::with('customer','salesman')->where('is_deleted',0)->filter(request(['search']))->orderBy('OdrDocDate','desc')->orderBy('OdrNum')->paginate(20)->withQueryString();  
        }
        
        // $slpCode = $user->oslpReg->RegSlpCode;
        // $orders = OrdrLocal::get();
        return view('ordr.ordr', [
            'title' => 'SCKKJ - Daftar Pesanan',
            'titleHeader' => 'Daftar Pesanan',
            'orders' => $orders,
            'user' => $user
        ]);
    }

    public function detail($id)
    {
        $order = OrdrLocal::with(['orderRow.orderItem'])->findOrFail($id);
        $rows = $order->orderRow->sortBy('id')->map(function ($r) {
            return [
                'RdrItemCode'     => $r->RdrItemCode,
                'ItemName'        => $r->orderItem?->ItemName, // ambil langsung
                'RdrItemQuantity' => $r->RdrItemQuantity,
                'RdrItemPrice'    => $r->RdrItemPrice,
                'RdrItemDisc'     => $r->RdrItemDisc,
            ];
        });

        return response()->json($rows);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($CardCode)
    {
        $cust = OcrdLocal::findOrFail($CardCode);
        $tahun = Carbon::now()->year;
        $bulan = Carbon::now()->month;
        $tanggal = Carbon::now()->toDateString();
        $tahunBulan = date('Y-m', strtotime($tanggal));
        $nomorInt = OrdrLocal::where('OdrSlpCode', 118)->count() + 1;
        $nomorStr = str_pad($nomorInt, 3, '0', STR_PAD_LEFT);
        $CardCode = $cust->CardCode;
        $romawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $bulanRomawi = $romawi[$bulan];
        $user = Auth::user();
        if ($user->role === 'salesman') {
            $alias = $user->oslpReg->Alias;
            $slpCode = $user->oslpReg->RegSlpCode;
        } else {
            $alias = 'DMY';
            $slpCode = 1;
        }
        $lastOrder = OrdrLocal::where('OdrSlpCode', $slpCode)
        ->whereRaw("DATE_FORMAT(OdrDocDate, '%Y-%m') = ?", [$tahunBulan])
        ->orderByDesc('OdrNum')
        ->first();
        if ($lastOrder) {
            $lastNum = (int) $lastOrder->OdrNum;
            $newNum = str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNum = '001';
        }
        $dataOrder['OdrCrdCode'] = $CardCode;
        $dataOrder['OdrSlpCode'] = $slpCode;
        $dataOrder['OdrDocDate'] = $tanggal;
        $dataOrder['OdrNum'] = $newNum;
        $dataOrder['OdrRefNum'] = $alias.'/'.$tahun.'/'.$bulanRomawi.'/'.$newNum;
        // dd($data);
        return view('ordr.ordr_create', [
            'title' => 'SCKKJ - Buat Pesanan',
            'titleHeader' => 'Buat Pesanan',
            'cust' => $cust,
            'dataOrder' => $dataOrder
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $head = OrdrLocal::create([
                'OdrRefNum' => $request->input('OdrRefNum'),
                'OdrNum' => $request->input('OdrNum'),
                'OdrCrdCode' => $request->input('OdrCrdCode'),
                'OdrSlpCode' => $request->input('OdrSlpCode'),
                'OdrDocDate' => $request->input('OdrDocDate'),
            ]);
            // dd($head->id);
            foreach($request->items as $item) {
                Rdr1Local::create([
                    'OdrId' => $head->id,
                    'RdrItemCode' => $item['RdrItemCode'],
                    'RdrItemQuantity' => $item['RdrItemQuantity'],
                    'RdrItemSatuan' => $item['RdrItemSatuan'],
                    'RdrItemPrice' => $item['RdrItemPrice'],
                    'RdrItemProfitCenter' => $item['RdrItemProfitCenter'],
                    'RdrItemKetHKN' => $item['RdrItemKetHKN'],
                    'RdrItemKetFG' => $item['RdrItemKetFG'],
                    'RdrItemDisc' => $item['RdrItemDisc']
                ]);
            }
        });
        return redirect()->route('order')->with('success', 'Pesanan Berhasil Dibuat');
    }

    public function push()
    {
        Artisan::call('push:ordr');
        return back()->with('success', 'Data Pesanan Berhasil Di-push ke SAP');
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
        $order = OrdrLocal::findOrFail($id);
        // dd($order->is_synced);
        if ($order->is_synced === 1) {
            return redirect()->route('order')->with('error', 'Pesanan Sudah Dikirim ke SAP, Tidak Boleh Diedit!');
        }
        if ($order->is_deleted === 1) {
            return redirect()->route('order')->with('error', 'Pesanan Tidak Ada!');
        }
        if (Gate::denies('order.edit', $order)) {
            abort(403, 'Unauthorized');
        }
        // ambil head + relasi rows + relasi item
        $head = OrdrLocal::with(['orderRow.orderItem'])->findOrFail($id);
        $OdrDocDate = Carbon::parse($head->OdrDocDate)->format('d/m/Y');
        // data customer
        $cust = $head->customer;

        // map detail rows ke array buat AlpineJS
        $rows = $head->orderRow->sortBy('id')->values()->map(function($r){
            return [
                'RdrItemCode'       => $r->RdrItemCode,
                'ItemName'          => $r->orderItem?->ItemName,
                'RdrItemQuantity'   => $r->RdrItemQuantity,
                'RdrItemSatuan'     => $r->RdrItemSatuan,
                'RdrItemPrice'      => $r->RdrItemPrice,
                'RdrItemProfitCenter'=> $r->RdrItemProfitCenter,
                'RdrItemKetHKN'     => $r->RdrItemKetHKN,
                'RdrItemKetFG'      => $r->RdrItemKetFG,
                'RdrItemDisc'       => $r->RdrItemDisc,
            ];
        })->toArray();

        // ambil semua item buat pilihan select
        $items = OitmLocal::select([
            'ItemCode',
            DB::raw("CONCAT(ItemCode, ' - ', ItemName) as ItemLabel"),
            'ItemName',
            'HET',
            'ProfitCenter',
            'Satuan',
            'KetHKN',
            'KetFG'
        ])->get();

        return view('ordr.ordr_edit', [
            'title' => 'SCKKJ - Perbarui Pesanan',
            'titleHeader' => 'Perbarui Pesanan',
            'head' => $head,
            'rows' => $rows,
            'items' => $items,
            'cust' => $cust,
            'OdrDocDate' => $OdrDocDate
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $head = OrdrLocal::findOrFail($id);

            // hapus semua detail lama
            $head->orderRow()->delete();

            // insert ulang detail baru
            $items = $request->input('items', []);
            foreach ($items as $item) {
                $head->orderRow()->create([
                    'RdrItemCode'        => $item['RdrItemCode'],
                    'RdrItemQuantity'    => $item['RdrItemQuantity'],
                    'RdrItemPrice'       => $item['RdrItemPrice'],
                    'RdrItemSatuan'      => $item['RdrItemSatuan'],
                    'RdrItemProfitCenter'=> $item['RdrItemProfitCenter'],
                    'RdrItemKetHKN'      => $item['RdrItemKetHKN'],
                    'RdrItemKetFG'       => $item['RdrItemKetFG'],
                    'RdrItemDisc'        => $item['RdrItemDisc'],
                ]);
            }

            DB::commit();
            return redirect()->route('order')->with('success', 'Pesanan berhasil diperbarui');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal perbarui pesanan: '.$e->getMessage());
        }
    }   

    public function updateChecked(Request $request)
    {
        $ids = $request->input('is_checked', []);

        // Reset semua dulu (opsional, kalau mau clear dulu)
        OrdrLocal::query()->update(['is_checked' => 0]);

        // Update yang dicentang jadi 1
        if (!empty($ids)) {
            OrdrLocal::whereIn('id', $ids)->update(['is_checked' => 1]);
        }

        return redirect()->route('order')->with('success', 'Pengecekan pesanan berhasil diupdate.');
    }

    public function delete($id)
    {
        $order = OrdrLocal::findOrFail($id);
        // dd($order->is_synced);
        if ($order->is_synced === 1) {
            return redirect()->route('order')->with('error', 'Pesanan Sudah Dikirim ke SAP, Tidak Boleh Dihapus!');
        }
        if ($order->is_deleted === 1) {
            return redirect()->route('order')->with('error', 'Pesanan Tidak Ada!');
        }
        if (Gate::denies('order.edit', $order)) {
            abort(403, 'Unauthorized');
        }
        // ambil head + relasi rows + relasi item
        $head = OrdrLocal::with(['orderRow.orderItem'])->findOrFail($id);
        $OdrDocDate = Carbon::parse($head->OdrDocDate)->format('d/m/Y');
        // data customer
        $cust = $head->customer;

        // map detail rows ke array buat AlpineJS
        $rows = $head->orderRow->sortBy('id')->values()->map(function($r){
            return [
                'RdrItemCode'       => $r->RdrItemCode,
                'ItemName'          => $r->orderItem?->ItemName,
                'RdrItemQuantity'   => $r->RdrItemQuantity,
                'RdrItemSatuan'     => $r->RdrItemSatuan,
                'RdrItemPrice'      => $r->RdrItemPrice,
                'RdrItemProfitCenter'=> $r->RdrItemProfitCenter,
                'RdrItemKetHKN'     => $r->RdrItemKetHKN,
                'RdrItemKetFG'      => $r->RdrItemKetFG,
                'RdrItemDisc'       => $r->RdrItemDisc,
            ];
        })->toArray();

        // ambil semua item buat pilihan select
        $items = OitmLocal::select([
            'ItemCode',
            DB::raw("CONCAT(ItemCode, ' - ', ItemName) as ItemLabel"),
            'ItemName',
            'HET',
            'ProfitCenter',
            'Satuan',
            'KetHKN',
            'KetFG'
        ])->get();

        return view('ordr.ordr_delete', [
            'title' => 'SCKKJ - Hapus Pesanan',
            'titleHeader' => 'Hapus Pesanan',
            'head' => $head,
            'rows' => $rows,
            'items' => $items,
            'cust' => $cust,
            'OdrDocDate' => $OdrDocDate
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = OrdrLocal::findOrFail($id);
        $order->update([
            'is_deleted' => 1,
        ]);

        return redirect()->route('order')->with('success', 'Pesanan berhasil dihapus.');
    }
}
