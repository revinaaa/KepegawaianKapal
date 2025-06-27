<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            // Hapus kolom BPJS Kesehatan
            $table->dropColumn([
                'no_kartu_kes',
                'nama_kes',
                'kelas_rawat_kes',
                'tanggal_daftar_kes',
                'status_bpjs_kes',
            ]);

            // Hapus kolom BPJS Ketenagakerjaan
            $table->dropColumn([
                'no_kartu_kerja',
                'nama_kerja',
                'kelas_rawat_kerja',
                'tanggal_daftar_kerja',
                'status_bpjs_kerja',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            // Tambahkan kembali kolom BPJS Kesehatan
            $table->string('no_kartu_kes')->default('');
            $table->string('nama_kes')->default('');
            $table->string('kelas_rawat_kes')->default('');
            $table->date('tanggal_daftar_kes')->nullable();
            $table->string('status_bpjs_kes')->default('');

            // Tambahkan kembali kolom BPJS Ketenagakerjaan
            $table->string('no_kartu_kerja')->default('');
            $table->string('nama_kerja')->default('');
            $table->string('kelas_rawat_kerja')->default('');
            $table->date('tanggal_daftar_kerja')->nullable();
            $table->string('status_bpjs_kerja')->default('');
        });
    }
};

