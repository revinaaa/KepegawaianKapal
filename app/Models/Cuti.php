<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cuti extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'slug',
        'user_id',
        'jenis_cuti',
        'tanggal_mulai',
        'tanggal_akhir',
        'alasan',
        'email',
        'status',
        'id_karyawan'
    ];


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => function () {
                    return Str::random(10);
                },
            ],
        ];
    }



    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
