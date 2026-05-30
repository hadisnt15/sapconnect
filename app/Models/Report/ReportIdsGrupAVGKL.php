<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportIdsGrupAVGKL extends Model
{
    protected $table = 'report_ids_grup_avgkl';
    protected $primaryKey = 'MAINKEY';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['MAINKEY', 'TYPECUST', 'GROUPCUST', 'TAHUN', 'BULAN', 'ORIGINCODE', 'FRGNNAME', 'AVGKL', 'RANK'];
}
