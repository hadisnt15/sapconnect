<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'phone',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $attributes = [
        'role' => 'salesman', // default
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // public function order(): BelongsTo
    // {
    //     return $this->belongsTo(OrdrLocal::class, 'SlpCode', 'OdrSlpCode');
    // }

    public function oslpReg()
    {
        return $this->hasOne(OslpReg::class,'RegUserId','id');
    }

    public function devices()
    {
        return $this->hasMany(UserDevice::class);
    }

    public function divisions()
    {
        return $this->belongsToMany(Division::class, 'user_division', 'user_id', 'div_id')->orderBy('div_name');
    }
    
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'user_branch', 'user_id', 'branch_id')->orderBy('branch_name');
    }

    public function reports()
    {
        return $this->belongsToMany(Report::class, 'user_reports', 'user_id', 'report_id')->orderBy('name');
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when(
            $filters['search'] ?? false, fn ($query, $search) =>
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('role', 'like', '%' . $search . '%')
        );
    }
}   
