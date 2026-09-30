<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- TAMBAHKAN BARIS INI

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('food')->insert([
            [
                'name' => 'Nasi Goreng Spesial',
                'kategori' => 'Makanan',
                'harga' => 25000,
                'deskripsi' => 'Nasi goreng dengan telur, ayam suwir, dan kerupuk.',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mie Goreng Seafood',
                'kategori' => 'Makanan',
                'harga' => 28000,
                'deskripsi' => 'Mie goreng pedas dengan udang dan cumi.',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Es Teh Manis',
                'kategori' => 'Minuman',
                'harga' => 5000,
                'deskripsi' => 'Es teh melati segar.',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jus Alpukat',
                'kategori' => 'Minuman',
                'harga' => 15000,
                'deskripsi' => 'Jus alpukat murni dengan susu cokelat.',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kentang Goreng',
                'kategori' => 'Cemilan',
                'harga' => 12000,
                'deskripsi' => 'Kentang goreng renyah dengan saus keju.',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}