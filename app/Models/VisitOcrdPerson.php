<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitOcrdPerson extends Model
{
    protected $table = 'visit_ocrd_persons';
    protected $fillable = [
        'visit_id','ocrd_person_id'
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    public function person()
    {
        return $this->belongsTo(OcrdPerson::class, 'ocrd_person_id');
    }
}
