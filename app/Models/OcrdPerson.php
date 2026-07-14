<?php

namespace App\Models;

use App\Models\OcrdCard;
use Illuminate\Database\Eloquent\Model;

class OcrdPerson extends Model
{
    protected $table = 'ocrd_person';
    protected $fillable = [
        'ocrd_card_id','name','position','phone','date_of_birth','hobby','religion','gender','is_active'
    ];

    public function ocrd_card()
    {
        return $this->belongsTo(OcrdCard::class);
    }

    public function visits()
    {
        return $this->belongsToMany(Visit::class, 'visit_ocrd_persons', 'ocrd_person_id', 'visit_id');
    }
}
