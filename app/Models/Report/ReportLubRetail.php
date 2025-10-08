<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportLubRetail extends Model
{
    protected $table = 'report_lub_retail';
    protected $fillable = ['TYPE', 'TYPE2', 'LITER', 'TAHUN', 'BULAN'];
}
