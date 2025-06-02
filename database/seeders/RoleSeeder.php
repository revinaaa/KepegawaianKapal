<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => 1, 'nama' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama' => 'hrd', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nama' => 'karyawan', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
