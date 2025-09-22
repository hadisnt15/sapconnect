<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OitmLocal extends Model
{
    protected $table = 'oitm_local';
    protected $primaryKey = 'ItemCode';
    public $incrementing = false;
    protected $keyType = 'string';//
    protected $fillable = [
        'ItemCode','ItemName','FrgnName','ProfitCenter','Brand','Segment','Type','Series',
        'Satuan','TotalStock','HET','StatusHKN','StatusFG','KetHKN','KetFG','KetStock'
    ];

    public function scopeFilter(Builder $query, array $filters)   
    {
        $query->when(
            $filters['search'] ?? false,
            fn ($query, $search) =>
            $query->where('ItemCode', 'like', '%' . $search . '%')
                ->orWhere('ItemName', 'like', '%' . $search . '%')
                ->orWhere('FrgnName', 'like', '%' . $search . '%')
                ->orWhere('Segment', 'like', '%' . $search . '%')
                ->orWhere('Type', 'like', '%' . $search . '%')
                ->orWhere('Series', 'like', '%' . $search . '%')
        );
    }

    public function orderRow(): HasMany
    {
        return $this->hasMany(Rdr1Local::class, 'ItemCode', 'OdrItemCode');
    }
}
