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
        // Schema::table('users', function (Blueprint $table) {
        //     // Tambahkan kolom status setelah kolom 'name'
        //     $table->enum('status', ['active', 'inactive'])->default('inactive')->after('name');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('users', function (Blueprint $table) {
        //     // Hapus kolom status jika rollback
        //     $table->dropColumn('status');
        // });
    }
};
