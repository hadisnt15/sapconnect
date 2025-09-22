<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OcrdReg extends Model
{
    protected $table = 'ocrd_reg';
    protected $keyType = 'string';//
    protected $fillable = [
        'RegCardCode','RegCardName','RegAddress','RegCity','RegState','RegContact','RegPhone'
    ];

    public function order(): HasMany
    {
        return $this->hasmany(OrdrLocal::class, 'OdrCrdCode', 'RegCardCode');
    }
}
