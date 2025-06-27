<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('karyawans', function (Blueprint $table) {
        // Jangan drop kalau belum ada
        if (!Schema::hasColumn('karyawans', 'status_keluarga')) {
            $table->enum('status_keluarga', ['Menikah', 'Belum Menikah'])->default('Belum Menikah')->after('no_kk');
        }
    });
}

public function down()
{
    Schema::table('karyawans', function (Blueprint $table) {
        $table->dropColumn('status_keluarga');
    });
}

};
