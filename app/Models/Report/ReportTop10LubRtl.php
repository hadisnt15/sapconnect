<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportTop10LubRtl extends Model
{
    protected $table = 'report_top_10_lub_rtl';
    protected $fillable = ['type', 'cardcode', 'cardname', 'liter'];
}
