<?php

namespace Database\Seeders;

use App\Models\store;
use App\Models\products;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua toko yang ada
        $stores = Store::all();

        // Periksa apakah ada toko yang ditemukan
        if ($stores->isEmpty()) {
            Log::info('Tidak ada toko yang ditemukan.');
            return;
        }

        foreach ($stores as $store) {
            // Buat 5 produk untuk setiap toko menggunakan factory
            $products = products::factory()->count(5)->create();

            // Hubungkan produk dengan toko
            $store->products()->attach($products->pluck('id'));
        }
    }
}
