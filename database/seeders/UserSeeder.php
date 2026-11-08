<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario de prueba del panel: admin@restocode.com / restocode
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Admin RestoCode',
            'email' => 'admin@restocode.com',
            'password' => Hash::make('restocode'),
            'role' => 'administrador',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Usuario común: usuario@restocode.com / restocode
        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Usuario RestoCode',
            'email' => 'usuario@restocode.com',
            'password' => Hash::make('restocode'),
            'role' => 'usuario',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
