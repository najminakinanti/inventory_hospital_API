<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'hospital_id' => 1,
                'status' => 'Diproses',
                'order_date' => now()->subDays(2),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'hospital_id' => 1,
                'status' => 'Dikirim',
                'order_date' => now()->subDay(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}

