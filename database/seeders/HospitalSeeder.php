<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HospitalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('hospitals')->insert([
            [
                'name' => 'RS Umum Jakarta',
                'address' => 'Jl. Sudirman No.1, Jakarta',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'RS Kesehatan Bandung',
                'address' => 'Jl. Asia Afrika No.10, Bandung',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}

