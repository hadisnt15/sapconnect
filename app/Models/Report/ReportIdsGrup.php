<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportIdsGrup extends Model
{
    protected $table = 'report_ids_grup';
    protected $primaryKey = 'MAINKEY';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['MAINKEY', 'TYPECUST', 'GROUPCUST', 'TAHUN', 'BULAN', 'KILOLITER', 'RUPIAH', 'PIUTANG', 'PIUTANGJT', 'CARDCODE', 'CARDNAME'];

}
