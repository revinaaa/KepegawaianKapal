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
        Schema::create('bpjs_ketenagakerjaans', function (Blueprint $table) {
            $table->id();
            $table->string('no_kartu', 50)->unique();
            $table->string('slug', 255)->nullable();
            $table->string('nama', 255)->nullable();
            $table->string('kelas_rawat', 255)->nullable();
            $table->date('tanggal_daftar')->nullable();
            $table->string('status_bpjs', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bpjs_ketenagakerjaans');
    }
};
