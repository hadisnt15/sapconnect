<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportSprSales extends Model
{
    protected $table = 'report_spr_sales';
    protected $primaryKey = 'MAINKEY';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'MAINKEY','DOCENTRY','KODESALES','NAMASALES','KEY','KEY2','KEY3','KEY4','TYPE','TARGET',
        'CAPAI','PERSENTASE','TARGETSPR','CAPAISPR','SUMTARGETSPR','SUMCAPAISPR','SUMPERSENTASE','TAHUN','BULAN'
    ];

    
}
