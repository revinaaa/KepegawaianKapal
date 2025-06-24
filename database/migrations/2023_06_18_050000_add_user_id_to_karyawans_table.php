<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    //     Schema::table('karyawans', function (Blueprint $table) {
    //         // Kolom user_nik sebagai foreign key ke users.nik
    //         $table->string('user_nik')->nullable();

    //         $table->foreign('user_nik')
    //               ->references('nik')->on('users')
    //               ->onDelete('set null');
    //     });
    // }

    // public function down(): void
    // {
    //     Schema::table('karyawans', function (Blueprint $table) {
    //         $table->dropForeign(['user_nik']);
    //         $table->dropColumn('user_nik');
    //     });
    }
};
