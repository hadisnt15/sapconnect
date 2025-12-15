<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportRtlSales extends Model
{
    protected $table = 'report_rtl_sales';
    protected $primaryKey = 'MAINKEY';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'MAINKEY','SLPCODE','SLPNAME','TAHUN','BULAN','SEGMENT','TARGET','LITER','PERSEN'
    ];
}
