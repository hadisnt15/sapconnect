<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportJHOutstanding extends Model
{
    protected $table = 'report_jh_outstanding';
    protected $primaryKey = 'MAINKEY';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['MAINKEY', 'TANGGAL', 'PROJECT', 'PRJNAME', 'TAHUN', 'BULAN', 'NAMABULAN', 'TOTAL'];
}
