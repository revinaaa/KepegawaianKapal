<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BpjsKetenagakerjaan extends Model
{
    use HasFactory;
    use Sluggable;

    protected $table = 'bpjs_ketenagakerjaans';

    protected $fillable = [
        'nik',
        'no_kartu',
        'slug',
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
    public function karyawan()
{
    return $this->belongsTo(Karyawan::class, 'nik', 'nik');
}

}
