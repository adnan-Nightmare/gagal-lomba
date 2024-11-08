<?php

namespace Database\Seeders;

use App\Models\products;
use App\Models\store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StoreSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua pengguna yang ada
        $users = User::all();

        foreach ($users as $user) {
            Store::factory()->create(['user_id' => $user->id]); // Buat toko untuk setiap pengguna
        }
    }
}
