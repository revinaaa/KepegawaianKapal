<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;

class Karyawan extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'karyawans';

    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
    'nik',
    'nama',
    'email', 
    'alamat', 
    'foto',
    'slug',
    'area_kerja',
    'doh',
    'id_jabatan',
    'nama_kapal',
    'tempat_lahir',
    'tanggal_lahir',
    'no_telepon',
    'jenis_kelamin',
    'golongan_darah',
    'agama',
    'jenis_bank',
    'no_akun_bank',
    'nama_akun_bank',
    'kode_pajak',
    'no_kk',
    'nama_istri',
    'nik_istri',
    'status_keluarga',
    'nama_anak_pertama',
    'nik_anak_pertama',
    'nama_anak_kedua',
    'nik_anak_kedua',
    'nama_anak_ketiga',
    'nik_anak_ketiga',
    'nama_ibu',
    'nik_ibu',
    'pendidikan',
    'usia',
    'no_telepon_darurat',


    // Relasi ke User
    'user_nik',

    
];


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }

    // Relasi ke tabel jabatan
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }

    // Relasi ke tabel cuti (menggunakan NIK)
    public function cutis()
    {
        return $this->hasMany(Cuti::class, 'id_karyawan', 'nik');
    }

    // Relasi ke tabel users (dengan foreign key user_nik)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_nik', 'nik');
    }

public function bpjsKesehatan()
{
    return $this->hasOne(BpjsKesehatan::class, 'nik', 'nik');
}

public function bpjsKetenagakerjaan()
{
    return $this->hasOne(BpjsKetenagakerjaan::class, 'nik', 'nik');
}


}
