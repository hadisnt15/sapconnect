<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DPPDetail extends Model
{
    protected $table = 'dpp_detail';
    public $incrementing = false;
    protected $fillable = [
        'dpp_id','no_invoice','kode_customer','nama_customer', 'golongan_customer', 'jenis_customer', 'alamat_customer','profit_center','tgl_invoice','tgl_jt_invoice','piutang','note'
    ];

    public function header()
    {
        return $this->belongsTo(DPPHeader::class, 'dpp_id');
    }
}
