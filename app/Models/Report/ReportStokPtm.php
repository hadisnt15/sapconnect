<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportStokPtm extends Model
{
    protected $table = 'report_stok_ptm';
    protected $primaryKey = 'MAINKEY';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'MAINKEY', 'CEK', 'GUDANG', 'ORIGINCODE', 'FRGNNAME', 'SATUAN', 'STOK', 'ESTHABISSTOKBULAN', 
        'AVG3BULAN', 'OPENQTYAP', 'STOKPLUSOPENQTY', 'ESTHABISSTOKPLUSOPENBULAN'
    ];
}
