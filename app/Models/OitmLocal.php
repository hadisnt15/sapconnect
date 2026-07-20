<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OitmLocal extends Model
{
    protected $table = 'oitm_local';
    protected $primaryKey = 'ItemCode';
    public $incrementing = false;
    protected $keyType = 'string';//
    protected $fillable = [
        'ItemCode','ItemName','FrgnName','ProfitCenter','Brand','Segment','Type','Series',
        'Satuan','TotalStock','HET','StatusHKN','StatusFG','KetHKN','KetHKN3','KetFG','KetStock','div_name',
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
                ->orWhere('Brand', 'like', '%' . $search . '%')
        );
    }

    public function orderRow(): HasMany
    {
        return $this->hasMany(Rdr1Local::class, 'ItemCode', 'OdrItemCode');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'div_name');
    }

    protected function hknPrice(): Attribute
    {
        return Attribute::make(
            get: function () {

                if (blank($this->KetHKN3)) {
                    return [];
                }

                return collect(explode(';', $this->KetHKN3))
                    ->map(function ($row) {

                        $row = trim($row);

                        if ($row === '') {
                            return null;
                        }

                        $parts = array_map('trim', explode('|', $row));

                        if (count($parts) !== 3) {
                            return null;
                        }

                        return [
                            'min_qty' => (int) $parts[0],
                            'max_qty' => (int) $parts[1],
                            'price'   => (int) $parts[2],
                            'label'   => sprintf(
                                'HKN %d%s (Rp %s)',
                                (int) $parts[0],
                                (int) $parts[1] >= 999999
                                    ? '+'
                                    : '-' . (int) $parts[1],
                                number_format((int) $parts[2], 0, ',', '.')
                            ),
                        ];
                    })
                    ->filter()
                    ->values()
                    ->all();
            }
        );
    }

    public function getHknPriceByQty(int $qty): ?float
    {
        $range = collect($this->hknPrice)->first(fn ($item) => $qty >= $item['min_qty'] && $qty <= $item['max_qty']);
        return $range['price'] ?? null;
    }
}
