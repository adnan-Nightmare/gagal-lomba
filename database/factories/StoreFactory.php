<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Store;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Store::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'user_id' => \App\Models\User::factory(), // Misalnya, buat user baru
            // Tambahkan atribut lain yang diperlukan
        ];
    }
}
