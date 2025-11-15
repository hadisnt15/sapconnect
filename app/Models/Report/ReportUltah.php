<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportUltah extends Model
{
    protected $table = 'report_ultah';
    protected $primaryKey = 'MAINKEY';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['MAINKEY', 'KODECUST', 'NAMACUST', 'PEMILIK', 'ULTAH', 'KOTA', 'KODESALES', 'NAMASALES'];
}