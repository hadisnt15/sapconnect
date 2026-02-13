<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportKontrakIds extends Model
{
    protected $table = 'report_kontrak_ids';
    protected $primaryKey = 'MAINKEY';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['MAINKEY', 'GRUP', 'TANGGAL', 'KET1', 'KET2'];
}
