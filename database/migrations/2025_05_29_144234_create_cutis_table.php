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
       Schema::create('cutis', function (Blueprint $table) {
        $table->id(); // Gunakan ID sebagai primary key default
        $table->string('user_nik'); // Foreign key ke users.nik
        $table->string('slug', 255)->nullable();
        $table->string('jenis_cuti', 255)->nullable();
        $table->date('tanggal_mulai')->nullable();
        $table->date('tanggal_akhir')->nullable();
        $table->text('alasan');
        $table->string('email', 100)->nullable();
        $table->enum('status', ['ditolak', 'proses', 'diterima'])->default('proses');
        $table->string('lampiran')->nullable();
        $table->timestamps();

        // Foreign key ke users.nik
        $table->foreign('user_nik')->references('nik')->on('users')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cutis');
    }
};
