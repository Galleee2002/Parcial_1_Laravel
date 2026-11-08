<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserHasServiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users_have_services')->insert([
            [
                'user_fk' => 2,
                'service_fk' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
