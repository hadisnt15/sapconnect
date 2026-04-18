<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OdlnReLocal extends Model
{
    protected $table = 'odln_re_local';
    // protected $primaryKey = 'id';
    // public $incrementing = false;
    protected $keyType = 'string';//
    protected $fillable = [
        'no_sj','ket','is_synced','is_checked','kirim_ke'
    ];

    public function scopeFilter(Builder $query, array $filters)   
    {
        $query->when(
            $filters['search'] ?? false,
            function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('no_sj', 'like', '%' . $search . '%')
                    ->orWhereHas('mainOdln', function ($q2) use ($search) {
                        $q2->where('kode_customer', 'like', '%' . $search . '%')
                            ->orWhere('nama_customer', 'like', '%' . $search . '%')
                            ->orWhere('ref_sj', 'like', '%' . $search . '%')
                            ->orWhere('no_sj', 'like', '%' . $search . '%');
                    });
                });
            }
        );
    }

    public function mainOdln()
    {
        return $this->belongsTo(OdlnLocal::class, 'no_sj', 'no_sj');
    }
}
