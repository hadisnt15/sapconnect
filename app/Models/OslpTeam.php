<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OslpTeam extends Model
{
    protected $table = 'oslp_team';
    protected $fillable = [
        'SlpCodeLeader','SlpCodeMember'
    ];

    public function oslpLead()
    {
        return $this->belongsTo(OslpLocal::class, 'SlpCodeLeader', 'SlpCode');
    }
}
