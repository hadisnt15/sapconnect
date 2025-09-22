<?php

namespace App\Models;

use App\Models\OslpLocal;
use App\Models\OcrdLocal;
use App\Models\Rdr1Local;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class OrdrLocal extends Model
{
    protected $table = 'ordr_local';
    // protected $primaryKey = 'id';
    // public $incrementing = false;
    protected $keyType = 'string';//
    protected $fillable = [
        'OdrRefNum','OdrNum','OdrCrdCode','OdrSlpCode','OdrDocDate','is_synced','is_checked','is_deleted'
    ];
    protected $casts = [
        'OdrDocDate' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(OcrdLocal::class, 'OdrCrdCode', 'CardCode');
    }

    public function customerReg(): BelongsTo
    {
        return $this->belongsTo(OcrdReg::class, 'OdrCrdCode', 'RegCardCode');
    }
    
    public function salesman(): BelongsTo
    {
        return $this->belongsTo(OslpLocal::class, 'OdrSlpCode', 'SlpCode');
    }

    public function orderRow(): HasMany
    {
        return $this->hasMany(Rdr1Local::class, 'OdrId', 'id');
    }

    public function scopeFilter(Builder $query, array $filters)   
    {
        $query->when(
            $filters['search'] ?? false,
            fn ($query, $search) =>
            $query->where('OdrRefNum', 'like', '%' . $search . '%')
                ->orWhere('OdrSlpCode', 'like', '%' . $search . '%')
                ->orWhere('OdrCrdCode', 'like', '%' . $search . '%')
                // cari berdasarkan nama customer
                ->orWhereHas('customer', function ($q) use ($search) {
                    $q->where('CardName', 'like', '%' . $search . '%');
                })
                // cari berdasarkan nama salesman
                ->orWhereHas('salesman', function ($q) use ($search) {
                    $q->where('SlpName', 'like', '%' . $search . '%');
                })
        );
    }
}
