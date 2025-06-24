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
        // Schema::table('cutis', function (Blueprint $table) {
        //     $table->string('user_nik')->nullable(); // tanpa 'after'


        //     // Foreign key ke tabel users, kolom nik
        //     $table->foreign('user_nik')->references('nik')->on('users')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('cutis', function (Blueprint $table) {
        //     $table->dropForeign(['user_nik']);
        //     $table->dropColumn('user_nik');
        // });
    }
};
