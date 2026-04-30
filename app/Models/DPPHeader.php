<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DPPHeader extends Model
{
    protected $table = 'dpp_header';
    // public $incrementing = false;
    protected $fillable = [
        'dpp_ref','dpp_date','receivable_id','collector_id', 'note'
    ];

    public function details()
    {
        return $this->hasMany(DPPDetail::class, 'dpp_id');
    }

    public function receivable()
    {
        return $this->belongsTo(User::class, 'receivable_id', 'id');
    }
    
    public function collector()
    {
        return $this->belongsTo(User::class, 'collector_id', 'id');
    }
}
