<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('order_items')->insert([
            [
                'order_id' => 1,
                'item_id' => 1,
                'quantity' => 100,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'order_id' => 1,
                'item_id' => 2,
                'quantity' => 50,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'order_id' => 2,
                'item_id' => 3,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
