<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportBulananAverage extends Model
{
    protected $table = 'report_bulanan_average';
    protected $primaryKey = 'MAINKEY';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['MAINKEY', 'KODECUSTOMER', 'NAMACUSTOMER', 'KODENAMACUSTOMER', 'SEGMENT', 'NO', 'TAHUN', 'BULAN', 'TAHUNBULAN', 'NAMATAHUNBULAN', 'VALUE', 'STATUSORDER', 'KOTA', 'PROVINSI', 'KODESALES', 'NAMASALES', 'ROWNUM', 'DIVISI'];
}
