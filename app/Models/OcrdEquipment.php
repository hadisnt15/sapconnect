<?php

namespace App\Models;

use App\Models\OcrdCard;
use Illuminate\Database\Eloquent\Model;

class OcrdEquipment extends Model
{
    protected $table = 'ocrd_equipment';
    protected $fillable = [
        'card_code_id','name','merk','type','capacity','sump_tank','is_active'
    ];

    public function ocrd_card()
    {
        return $this->belongsTo(OcrdCard::class);
    }
}
