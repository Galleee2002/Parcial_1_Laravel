<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('posts')->insert([
            [
                'title' => 'Por qué tu restaurante necesita un menú QR',
                'summary' => 'Ventajas de pasar de la carta impresa a una carta digital.',
                'content' => 'Un menú QR permite actualizar precios y platos al instante, sin costos de reimpresión. Además, los clientes pueden consultarlo desde su celular antes de llegar al local.',
                'published_at' => '2026-08-10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Reservas online: menos llamadas, más mesas ocupadas',
                'summary' => 'Cómo un sistema de reservas ordena el salón y reduce ausencias.',
                'content' => 'Las reservas online funcionan las 24 horas y evitan errores al anotar a mano. Con recordatorios automáticos, bajan las mesas vacías por clientes que no se presentan.',
                'published_at' => '2026-09-02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Cinco claves para la web de un local gastronómico',
                'summary' => 'Horarios, ubicación, carta, fotos y contacto: lo mínimo indispensable.',
                'content' => 'Una buena web gastronómica muestra horarios actualizados, un mapa con la ubicación, la carta destacada, fotos reales de los platos y un medio de contacto directo para reservar.',
                'published_at' => '2026-09-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
