<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportSprSegment extends Model
{
    protected $table = 'report_spr_segment';
    protected $primaryKey = 'MAINKEY';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'MAINKEY','PROFITCENTER','KEYPROFITCENTER','VALUE','TAHUN','BULAN'
    ];

}
