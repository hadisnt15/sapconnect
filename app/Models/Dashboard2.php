<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dashboard2 extends Model
{
    protected $table = 'dashboard2';
    // protected $primaryKey = 'MAINKEY';
    // public $incrementing = false;
    // protected $keyType = 'string';//
    protected $fillable = [
        'PROFITCENTER','KEYPROFITCENTER','VALUE','TAHUN','BULAN'
    ];
}
