<?php

namespace App\Models;

use App\Models\OcrdEquipment;
use App\Models\OcrdLocal;
use App\Models\OcrdPerson;
use App\Models\OslpLocal;
use Illuminate\Database\Eloquent\Model;

class OcrdCard extends Model
{
    protected $table = 'ocrd_card';
    protected $fillable = [
        'card_code','card_name','slp_code','segment','office_address','office_lat','office_lng','office_phone','office_mail','office_fax','site_address','site_lat','site_lng','site_phone','site_mail','site_fax','customer_desc','service_desc','competitor_desc'
    ];

    public function ocrd_local()
    {
        return $this->belongsTo(OcrdLocal::class, 'card_code', 'CardCode');
    }
    
    public function oslp_local()
    {
        return $this->belongsTo(OslpLocal::class, 'slp_code', 'SlpCode');
    }

    public function person()
    {
        return $this->hasMany(OcrdPerson::class);
    }

    public function equipment()
    {
        return $this->hasMany(OcrdEquipment::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class, 'ocrd_card_id', 'id');
    }
}
