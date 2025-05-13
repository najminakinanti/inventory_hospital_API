<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('warehouses')->insert([
            [
                'name' => 'Gudang Jogja',
                'address' => 'Jl. Persatuan No. 123, Sleman',
                'email' => 'gudangjogja@gmail.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
        ]);
    }
}
