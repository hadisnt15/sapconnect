<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportKetahananStok extends Model
{
    protected $table = 'report_ketahanan_stok';
    protected $primaryKey = 'MAINKEY';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['MAINKEY', 'TANGGAL', 'ORIGINCODE', 'FRGNNAME', 'UOM', 'STOCKONHAND', 'STOCKOUTSTANDING', 'STOCKCONTAINER', 'STOCKRENCANAISI', 'STOCKRENCANAJADWAL', 'TOTALSTOCK', 'STOCKPINJAMMADHANI', 'STOCKPINJAMPPA', 'TOTALSTOCKPINJAM', 'SISASTOCK'];
}
