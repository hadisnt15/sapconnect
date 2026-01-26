<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportPembelianHarian extends Model
{
    protected $table = 'report_pembelian_harian';
    protected $primaryKey = 'MAINKEY';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['MAINKEY', 'TANGGAL', 'TIPE', 'KETPERIODE', 'SEGMENT', 'LITER', 'KILOLITER', 'KETQTYUOM', 'KETQTYITEM'];

}
