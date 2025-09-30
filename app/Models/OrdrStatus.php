<?php

namespace App\Models;

use App\Models\OrdrLocal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdrStatus extends Model
{
    protected $table = 'ordr_status';
    protected $fillable = ['ref_num', 'pesanan_status'];

    public function ordrLocal(): BelongsTo
    {
        // foreign key di tabel ordr_status = ref_num
        // owner key di tabel ordr_local = OdrRefNum
        return $this->belongsTo(OrdrLocal::class, 'ref_num', 'OdrRefNum');
    }
}
