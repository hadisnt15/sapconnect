<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'due_date', 'attachment', 'is_done'
    ];
    
    protected $casts = [
        'due_date' => 'datetime',
    ];
}
