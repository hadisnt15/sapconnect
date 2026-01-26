<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportPembelianHarianDetail extends Model
{
    protected $table = 'report_pembelian_harian_detail';
    protected $primaryKey = 'MAINKEY';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['MAINKEY', 'TANGGAL', 'TIPE', 'KETPERIODE', 'SEGMENT', 'FRGNNAME', 'UOMCODE', 'QTY', 'LITER', 'KILOLITER', 'KETQTYUOM'];
}
