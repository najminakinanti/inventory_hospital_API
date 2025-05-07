<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('items')->insert([
            [
                'name' => 'Masker Medis',
                'description' => 'Masker sekali pakai untuk tenaga medis',
                'stock' => 1000,
                'jenis' => 'Habis pakai',
                'warehouse_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Alat Suntik',
                'description' => 'Suntikan steril sekali pakai',
                'stock' => 500,
                'jenis' => 'Habis pakai',
                'warehouse_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tempat Tidur Pasien',
                'description' => 'Tempat tidur untuk rawat inap',
                'stock' => 50,
                'jenis' => 'Tidak habis pakai',
                'warehouse_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}

