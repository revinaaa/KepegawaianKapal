<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory;
    use Sluggable;

    protected $table = 'karyawans';

    protected $fillable = [
        'nama',
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
        'id_bpjs_kesehatan',
        'id_bpjs_ketenagakerjaan',
        'kode_pajak',
        'no_kk',
        'nama_istri',
        'nik_istri',
        'nama_anak_pertama',
        'nik_anak_pertama',
        'nama_anak_kedua',
        'nik_anak_kedua',
        'nama_anak_ketiga',
        'nik_anak_ketiga',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }

    // Relasi ke Jabatan
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }

    // Relasi ke BPJS Kesehatan
    public function bpjsKesehatan()
    {
        return $this->belongsTo(BpjsKesehatan::class, 'id_bpjs_kesehatan');
    }

    // Relasi ke BPJS Ketenagakerjaan
    public function bpjsKetenagakerjaan()
    {
        return $this->belongsTo(BpjsKetenagakerjaan::class, 'id_bpjs_ketenagakerjaan');
    }
}
