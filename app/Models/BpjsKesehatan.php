<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BpjsKesehatan extends Model
{
    use HasFactory;
    use Sluggable;

    protected $table = 'bpjs_kesehatans';

    protected $fillable = [
        'no_kartu',
        'slug',
        'nama',
        'kelas_rawat',
        'tanggal_daftar',
        'status_bpjs',
    ];


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }
}
