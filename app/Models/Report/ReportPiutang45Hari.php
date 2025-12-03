<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportPiutang45Hari extends Model
{
    protected $table = 'report_piutang_45hari';
    protected $fillable = ['KODECUST', 'NAMACUST', 'JENISCUST', 'GOLONGANCUST', 'KEY', 'CABANG', 'LEWATHARI', 'KET', 'KET2', 'PIUTANG'];
}
