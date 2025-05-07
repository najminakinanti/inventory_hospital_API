<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('warehouses')->insert([
            ['location' => 'Jakarta', 'created_at' => now(), 'updated_at' => now()],
            ['location' => 'Bandung', 'created_at' => now(), 'updated_at' => now()],
            ['location' => 'Surabaya', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
