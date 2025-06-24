<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('cutis', function (Blueprint $table) {
        $table->string('lampiran', 255)->nullable()->change();
    });
}

public function down()
{
    Schema::table('cutis', function (Blueprint $table) {
        $table->string('lampiran', 50)->nullable()->change(); // jika sebelumnya 50
    });
}

};
