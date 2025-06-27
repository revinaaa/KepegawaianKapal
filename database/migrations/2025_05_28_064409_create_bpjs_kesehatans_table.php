<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('bpjs_kesehatans', function (Blueprint $table) {
        $table->id();
        $table->string('nik'); // foreign key ke karyawans
        $table->string('no_kartu')->unique();
        $table->string('slug')->unique();
        $table->string('kelas_rawat');
        $table->date('tanggal_daftar');
        $table->string('status_bpjs');
        $table->timestamps();

        $table->foreign('nik')->references('nik')->on('karyawans')->onDelete('cascade');
        
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bpjs_kesehatans');
    }
};
