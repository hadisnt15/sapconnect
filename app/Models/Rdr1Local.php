<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rdr1Local extends Model
{
    protected $table = 'rdr1_local';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';//
    protected $fillable = [
        'OdrId','RdrItemCode','RdrItemQuantity','RdrItemSatuan','RdrItemPrice','RdrItemProfitCenter','RdrItemKetHKN','RdrItemKetFG','RdrItemDisc'
    ];

    public function orderHead(): BelongsTo
    {
        return $this->belongsTo(OrdrLocal::class, 'OdrId', 'id');
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OitmLocal::class, 'RdrItemCode', 'ItemCode');
    }
}
