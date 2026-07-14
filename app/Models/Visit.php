<?php

namespace App\Models;

use App\Models\OcrdCard;
use App\Models\OcrdPerson;
use App\Models\OslpLocal;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = 'visits';
    protected $fillable = [
        'slp_code','ocrd_card_id','visit_date','note'
    ];
    protected $casts = [
        'visit_date' => 'datetime',
    ];

    public function ocrd_card()
    {
        return $this->belongsTo(OcrdCard::class, 'ocrd_card_id');
    }

    public function salesman()
    {
        return $this->belongsTo(OslpLocal::class, 'slp_code', 'SlpCode');
    }

    public function persons()
    {
        return $this->belongsToMany(OcrdPerson::class, 'visit_ocrd_persons', 'visit_id', 'ocrd_person_id');
    }

    public function scopeFilter(Builder $query, array $filters)   
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('salesman', function ($q2) use ($search) {
                    $q2->where('SlpName', 'like', "%{$search}%");
                })
                ->orWhereHas('ocrd_card', function ($q2) use ($search) {
                    $q2->where('card_name', 'like', "%{$search}%")
                    ->orWhere('card_code', 'like', "%{$search}%");
                });
            });
        });
    }
}
