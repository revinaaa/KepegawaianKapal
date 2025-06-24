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
        if (!Schema::hasColumn('cutis', 'nik')) {
            $table->string('nik')->after('user_nik');
        }
    });
}


public function down()
{
    Schema::table('cutis', function (Blueprint $table) {
        $table->dropColumn('nik');
    });
}
};
