<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OcrdLocal extends Model
{
    protected $table = 'ocrd_local';
    protected $primaryKey = 'CardCode';
    public $incrementing = false;
    protected $keyType = 'string';//
    protected $fillable = [
        'CardCode','CardName','Address','City','State','Contact','Phone','Group','Type1','Type2',
        'CreateDate','LastOdrDate','Termin','Limit','ActBal','DlvBal','OdrBal','created_by','NIK','piutang_jt'
    ];

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when(
            $filters['search'] ?? false, fn ($query, $search) =>
                $query->where('CardCode', 'like', '%' . $search . '%')
                    ->orWhere('CardName', 'like', '%' . $search . '%')
                    ->orWhere('City', 'like', '%' . $search . '%')
                    ->orWhere('State', 'like', '%' . $search . '%')
                    ->orWhere('Group', 'like', '%' . $search . '%')
                    ->orWhere('Type1', 'like', '%' . $search . '%')
                    ->orWhere('Type2', 'like', '%' . $search . '%')
                    ->orWhere('Termin', 'like', '%' . $search . '%')
        );
    }
    
    public function order(): HasMany
    {
        return $this->hasmany(OrdrLocal::class, 'OdrCardCode', 'CardCode');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
