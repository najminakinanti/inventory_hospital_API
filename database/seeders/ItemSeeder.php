<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['Masker Medis', 'Masker sekali pakai untuk tenaga medis', 1000, 'ProteksiDiri'],
            ['Alat Suntik', 'Suntikan steril sekali pakai', 500, 'Sterilisasi'],
            ['Tempat Tidur Pasien', 'Tempat tidur untuk rawat inap', 50, 'Furniture'],
            ['Sarung Tangan Medis', 'Sarung tangan latex steril', 2000, 'ProteksiDiri'],
            ['Hand Sanitizer', 'Pembersih tangan berbasis alkohol', 800, 'Sterilisasi'],
            ['Alat Tes Rapid', 'Kit tes cepat untuk diagnosa', 300, 'Laboratorium'],
            ['Thermometer Digital', 'Alat pengukur suhu tubuh', 150, 'Monitoring'],
            ['Alat Ukur Tekanan Darah', 'Sphygmomanometer manual', 120, 'Monitoring'],
            ['Kapas Medis', 'Kapas steril untuk perawatan luka', 2000, 'Sterilisasi'],
            ['Plester Luka', 'Plester perekat untuk luka kecil', 1500, 'Sterilisasi'],
            ['Tabung Oksigen', 'Tabung oksigen medis ukuran 1L', 40, 'AlatBantu'],
            ['Infus Set', 'Alat infus lengkap', 300, 'AlatBantu'],
            ['Kursi Roda', 'Kursi roda standar', 20, 'AlatBantu'],
            ['Masker N95', 'Masker respirator N95', 700, 'ProteksiDiri'],
            ['Alat ECG', 'Alat rekam jantung elektronik', 10, 'Monitoring'],
            ['Kaca Pembesar', 'Kaca pembesar kecil untuk medis', 150, 'AlatBantu'],
            ['Kursi Periksa', 'Kursi untuk pemeriksaan pasien', 30, 'Furniture'],
            ['Lampu Operasi', 'Lampu khusus ruang operasi', 5, 'Bedah'],
            ['Tabung Darah', 'Tabung untuk pengambilan darah', 1000, 'Laboratorium'],
            ['Perban Elastis', 'Perban elastis untuk pembalut', 1200, 'Sterilisasi'],
        ];

        $insertData = [];
        foreach ($items as $item) {
            $insertData[] = [
                'name' => $item[0],
                'description' => $item[1],
                'stock' => $item[2],
                'kategori' => $item[3],  // pakai kategori enum sesuai list
                'warehouse_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('items')->insert($insertData);
    }
}

