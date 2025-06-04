<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HospitalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('hospitals')->insert([
            [
                'name' => 'RS Harmoni Sejahtera',
                'address' => 'Jl. Melati No. 12, Jakarta Selatan',
                'email' => 'harmoni.sejahtera@medistock.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'RS Sumber Sejahtera',
                'address' => 'Jl. Kenanga No. 56, Bandung Barat',
                'email' => 'sumber.sejahtera@medistock.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'RS Prima Sejahtera',
                'address' => 'Jl. Anggrek No. 79, Surabaya Timur',
                'email' => 'prima.sejahtera@medistock.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'RS Mitra Sejahtera',
                'address' => 'Jl. Bougenville No. 31, Solo',
                'email' => 'mitra.sejahtera@medistock.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'RS Global Sejahtera',
                'address' => 'Jl. Flamboyan No. 4, Semarang Timur',
                'email' => 'global.sejahtera@medistock.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
        ]);
    }
}


