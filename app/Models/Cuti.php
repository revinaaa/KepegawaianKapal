<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cuti extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'user_nik', 
        'nik',
        'jenis_cuti',
        'tanggal_mulai',
        'tanggal_akhir',
        'lampiran',
        'status',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'nik', 'nik');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_nik', 'nik');
    }
}
