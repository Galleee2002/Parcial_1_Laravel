<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('services')->insert([
            [
                'title' => 'Menú QR Básico',
                'short_description' => 'Carta digital accesible con código QR.',
                'full_description' => 'Menú digital para celulares, con categorías y platos actualizables sin reimprimir.',
                'price' => 150000,          
                'delivery_days' => 7,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Landing Gastronómica',
                'short_description' => 'Página web para presentar el local.',
                'full_description' => 'Landing con horarios, ubicación, carta destacada y contacto para atraer reservas.',
                'price' => 280000,          
                'delivery_days' => 14,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Web Premium + Reservas',
                'short_description' => 'Sitio completo con sistema de reservas.',
                'full_description' => 'Web institucional con menú digital y módulo de reservas online para mesas.',
                'price' => 450000,          
                'delivery_days' => 21,
                'is_active' => false,       
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
