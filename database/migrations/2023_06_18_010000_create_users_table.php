<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('nik')->primary(); // NIK sebagai primary key
            $table->string('name');
            $table->string('slug')->unique(); // Slug harus unik
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('status', ['active', 'inactive'])->default('inactive'); // Status akun
            $table->foreignId('role_id') // Relasi ke roles
                  ->nullable()
                  ->constrained('roles')
                  ->onDelete('set null');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
