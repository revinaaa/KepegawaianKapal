<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug', 255)->nullable();
            $table->string('area_kerja')->nullable();
            $table->date('doh')->nullable();
            $table->foreignId('id_jabatan')->constrained('jabatans')->onDelete('cascade');
            $table->string('nama_kapal')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_telepon')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('golongan_darah')->nullable();
            $table->string('agama')->nullable();
            $table->string('jenis_bank')->nullable();
            $table->string('no_akun_bank')->nullable();
            $table->string('nama_akun_bank')->nullable();
            $table->foreignId('id_bpjs_kesehatan')->nullable()->constrained('bpjs_kesehatans')->onDelete('set null');
            $table->foreignId('id_bpjs_ketenagakerjaan')->nullable()->constrained('bpjs_ketenagakerjaans')->onDelete('set null');
            $table->string('kode_pajak')->nullable();
            $table->string('no_kk')->nullable();
            $table->string('nama_istri')->nullable();
            $table->string('nik_istri')->nullable();
            $table->string('nama_anak_pertama')->nullable();
            $table->string('nik_anak_pertama')->nullable();
            $table->string('nama_anak_kedua')->nullable();
            $table->string('nik_anak_kedua')->nullable();
            $table->string('nama_anak_ketiga')->nullable();
            $table->string('nik_anak_ketiga')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
