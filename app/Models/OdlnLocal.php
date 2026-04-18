<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OdlnLocal extends Model
{
    protected $table = 'odln_local';
    // protected $primaryKey = 'id';
    // public $incrementing = false;
    protected $keyType = 'string';//
    protected $fillable = [
        'no_sj','ref_sj','tgl_sj','tgl_input','waktu_input','kode_customer','nama_customer','ket','is_synced','is_checked','note_so','is_return_allowed'
    ];

    public function scopeFilter(Builder $query, array $filters)   
    {
        $query->when(
            $filters['search'] ?? false,
            fn ($query, $search) =>
            $query->where('kode_customer', 'like', '%' . $search . '%')
                ->orWhere('nama_customer', 'like', '%' . $search . '%')
                ->orWhere('ref_sj', 'like', '%' . $search . '%')
                ->orWhere('no_sj', 'like', '%' . $search . '%')
        );
    }

    public function reOdln()
    {
        return $this->hasMany(OdlnReLocal::class, 'no_sj');
    }
}
