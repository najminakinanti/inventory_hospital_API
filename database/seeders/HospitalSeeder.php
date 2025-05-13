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
                'name' => 'RS Harapan Sehat',
                'address' => 'Jl. Sehat No. 123, Jakarta',
                'email' => 'harapan@gmail.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'RS Aman Sentosa',
                'address' => 'Jl. Aman No. 456, Bandung',
                'email' => 'aman@gmail.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]
        ]);
    }

}

