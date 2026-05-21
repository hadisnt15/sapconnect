<?php

namespace App\Models\report;

use Illuminate\Database\Eloquent\Model;

class ReportJadwalIsiIBC extends Model
{
    protected $table = 'report_jadwal_pengisian_ibc';
    protected $primaryKey = 'MAINKEY';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['MAINKEY', 'FILLINGDATE', 'ORIGINCODE', 'FRGNNAME', 'UOM', 'QTY'];
}
