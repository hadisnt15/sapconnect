<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Report;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Report::create([
            'name' => 'Pencapaian Penjualan Sparepart per Segment',
            'slug' => 'pencapaian-penjualan-sparepart-per-segment',
            'description' => 'Laporan pencapaian penjualan sparepart per segment barang dalam periode 1 bulan',
            'route' => 'report.pencapaian-penjualan-sparepart-per-segment',
        ]);
        Report::create([
            'name' => 'Pencapaian Penjualan Sparepart per Sales',
            'slug' => 'pencapaian-penjualan-sparepart-per-sales',
            'description' => 'Dasbor pencapaian penjualan sparepart per sales dalam periode 1 bulan',
            'route' => 'report.pencapaian-penjualan-sparepart-per-sales',
        ]);
        Report::create([
            'name' => 'Grafik Penjualan Harian Sales',
            'slug' => 'grafik-penjualan-harian-sales',
            'description' => 'Grafik Data Penjualan Harian per Sales dalam Satu Bulan',
            'route' => 'report.grafik-penjualan-harian-sales',
        ]);
    }
}
