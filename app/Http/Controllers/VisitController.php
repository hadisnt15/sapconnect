<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('visit.visit', [
            'title' => 'SCKKJ - Kunjungan',
            'titleHeader' => 'Kunjungan',
            // 'grouped' => $grouped
        ]);
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
        // Validasi input gambar
        $request->validate([
            'image_data' => 'required|string',
        ]);

        // Mendapatkan data gambar base64 dari input form
        $imageData = $request->input('image_data');
        $image = str_replace('data:image/png;base64,', '', $imageData);
        $image = str_replace(' ', '+', $image);
        $imageName = 'visit_' . time() . '.png';

        // Menyimpan gambar ke storage
        Storage::disk('public')->put('sales-visits/' . $imageName, base64_decode($image));

        return back()->with('success', 'Gambar berhasil disimpan!')->with('path', $imageName);
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
         // Ambil data base64 yang dikirim dari JavaScript
        $imageData = $request->input('image');

        // Cek apakah ada data gambar
        if ($imageData) {
            // Hapus prefix data URL base64
            $image = str_replace('data:image/png;base64,', '', $imageData);
            $image = str_replace(' ', '+', $image);
            
            // Nama gambar (gunakan timestamp untuk menghindari duplikasi nama)
            $imageName = time() . '.png';

            // Tentukan path untuk menyimpan gambar
            $path = storage_path('app/public/visit_images/' . $imageName);

            // Simpan gambar ke file
            file_put_contents($path, base64_decode($image));

            // Kembalikan path atau simpan ke database jika perlu
            return back()->with('success', 'Bukti kunjungan berhasil diupload!')->with('path', $path);
        }

        // Jika gambar tidak ada, beri pesan error
        return back()->with('error', 'Tidak ada gambar yang diupload.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
