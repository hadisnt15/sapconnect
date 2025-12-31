<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportPeminjamanBarang extends Model
{
    protected $table = 'report_peminjaman_barang';
    protected $primaryKey = 'MAINKEY';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['MAINKEY', 'TANGGAL', 'ALUR', 'ORIGINCODE', 'FRGNNAME', 'QTY', 'UOM'];
}
