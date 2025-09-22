<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class OslpReg extends Model
{
    protected $table = 'oslp_reg';
    // protected $primaryKey = 'SlpCode';
    // public $incrementing = false;
    protected $keyType = 'string';//
    protected $fillable = [
        'RegUserId','RegSlpCode','Alias'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'RegUserId', 'id');
    }

    public function oslpLocal()
    {
        return $this->belongsTo(OslpLocal::class, 'RegSlpCode', 'SlpCode');
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when(
            $filters['search'] ?? false,
            fn ($query, $search) =>
            $query->where('Alias', 'like', '%' . $search . '%')
                // cari berdasarkan nama customer
                ->orWhereHas('oslpLocal', function ($q) use ($search) {
                    $q->where('SlpName', 'like', '%' . $search . '%');
                })
        );
    }
}
