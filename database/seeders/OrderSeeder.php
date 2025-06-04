<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $orders = [];
        for ($i = 1; $i <= 12; $i++) {
            $orders[] = [
                'hospital_id' => rand(1,5),
                'status' => ['Diproses', 'Dikirim', 'Selesai'][array_rand(['Diproses', 'Dikirim', 'Selesai'])],
                'order_date' => now()->subDays(rand(1, 30)),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('orders')->insert($orders);
    }
}
