<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // RS User
        $hospitalId = DB::table('hospitals')->insertGetId([
            'name' => 'RS Citra Medika',
            'address' => 'Jl. Kesehatan No.10, Depok',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'RS Citra Medika',
            'email' => 'rscitra@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'hospital',
            'hospital_id' => $hospitalId,
            'warehouse_id' => null,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
         
        // RS User
        $hospitalId = DB::table('hospitals')->insertGetId([
            'name' => 'RS Cahaya Medika',
            'address' => 'Jl. Persatuan No.10, Sleman',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'RS Cahaya Medika',
            'email' => 'rscahaya@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'hospital',
            'hospital_id' => $hospitalId,
            'warehouse_id' => null,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Inventory User
        $warehouseId = DB::table('warehouses')->insertGetId([
            'location' => 'Gudang Utama Yogyakarta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Gudang Utama Yogyakarta',
            'email' => 'inventoryadmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'inventory',
            'hospital_id' => null,
            'warehouse_id' => $warehouseId,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
