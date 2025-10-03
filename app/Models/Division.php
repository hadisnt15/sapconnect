<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    
    protected $table = 'division';
    protected $fillable = [
        'div_name','div_desc'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_division', 'div_id', 'user_id');
    }
}
