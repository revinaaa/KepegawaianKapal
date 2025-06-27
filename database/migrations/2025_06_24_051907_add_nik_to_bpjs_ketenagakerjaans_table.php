<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 public function up(): void
    {
        Schema::table('bpjs_ketenagakerjaans', function (Blueprint $table) {
            $table->string('nik')->after('id');

            // Jika ingin pakai foreign key juga:
            $table->foreign('nik')->references('nik')->on('karyawans')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('bpjs_ketenagakerjaans', function (Blueprint $table) {
            $table->dropForeign(['nik']);
            $table->dropColumn('nik');
        });
    }
};
