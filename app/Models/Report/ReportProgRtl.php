<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportProgRtl extends Model
{
    protected $table = 'report_prog_rtl';
    protected $fillable = ['MAINKEY', 'PROGRAM', 'STATUS', 'TAHUN', 'BULAN', 'WILAYAH', 'MFORCE', 'DMS', 'KODECUSTOMER', 'NAMACUSTOMER', 'UUID', 'SEGMENT', 'LITER', 'TARGET', 'SISA', 'KETERANGAN', 'PERSENTASE'];
}
