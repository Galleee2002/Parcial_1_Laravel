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
                'title' => 'Pedidos Online',
                'short_description' => 'Carta con pedidos para take away y delivery.',
                'full_description' => 'Carta digital con carrito para que los clientes armen su pedido y lo envíen al local por WhatsApp.',
                'price' => 320000,
                'delivery_days' => 15,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Menú QR Multilenguaje',
                'short_description' => 'Carta digital en varios idiomas para turistas.',
                'full_description' => 'Menú QR con la carta traducida al inglés y al portugués, con selector de idioma y alérgenos destacados.',
                'price' => 210000,
                'delivery_days' => 10,
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
