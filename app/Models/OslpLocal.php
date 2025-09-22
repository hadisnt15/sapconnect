<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OslpLocal extends Model
{
    protected $table = 'oslp_local';
    protected $primaryKey = 'SlpCode';
    public $incrementing = false;
    protected $keyType = 'string';//
    protected $fillable = [
        'SlpCode','SlpName','Phone','FirstOdrDate','LastOdrDate'
    ];

    public function scopeFilter(Builder $query, array $filters)   
    {
        $query->when(
            $filters['search'] ?? false,
            fn ($query, $search) =>
            $query->where('SlpCode', 'like', '%' . $search . '%')
                ->orWhere('SlpName', 'like', '%' . $search . '%')
        );
    }

    public function order(): HasMany
    {
        return $this->hasMany(OrdrLocal::class, 'OdrSlpCode', 'SlpCode');
    }

    public function oslpReg()
    {
        return $this->hasOne(OslpReg::class, 'RegSlpCode', 'SlpCode');
    }
}
