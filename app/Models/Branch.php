<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branch';
    protected $fillable = ['branch_name','branch_desc'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_branch', 'branch_id', 'user_id');
    }
}
