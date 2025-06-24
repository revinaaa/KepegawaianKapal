<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Sluggable;

    protected $fillable = [
        'nik',
        'name',
        'slug',
        'role_id',
        'email',
        'password',
    ];

    protected $primaryKey = 'nik';      // Ganti primary key
    public $incrementing = false;       // Non auto-increment
    protected $keyType = 'string';      // Karena NIK biasanya berupa string

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $attributes = [
        'role_id' => 3
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'user_nik', 'nik');
    }
    public function cutis()
{
    return $this->hasMany(Cuti::class, 'user_nik', 'nik');
}

}
