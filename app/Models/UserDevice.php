<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    protected $table = 'user_devices';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'device_id',
        'session_id',
        'ip',
        'device',
        'platform',
        'browser',
        'last_active',
    ];

    protected $dates = ['last_active'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
