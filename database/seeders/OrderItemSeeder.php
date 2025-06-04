<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $orderItems = [];

        // Buat 1-5 item random untuk setiap order (order_id 1-12)
        for ($orderId = 1; $orderId <= 12; $orderId++) {
            $itemCount = rand(1, 5);
            $usedItems = [];
            for ($i = 0; $i < $itemCount; $i++) {
                // Pastikan item_id unik per order
                do {
                    $itemId = rand(1, 20);
                } while (in_array($itemId, $usedItems));
                $usedItems[] = $itemId;

                $orderItems[] = [
                    'order_id' => $orderId,
                    'item_id' => $itemId,
                    'quantity' => rand(1, 100),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('order_items')->insert($orderItems);
    }
}

