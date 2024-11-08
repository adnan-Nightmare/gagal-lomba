<?php

namespace Database\Factories;

use App\Models\products;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class productsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = products::class;
    public function definition(): array
    {
        return [
            'slug' => Str::random(),
            'judul' => fake()->word(),
            'description' => fake()->text(),
            'price' => fake()->randomFloat(2, 1, 100),
            'toko' => 'ANstudio',
            // 'store_id' => 1,
            'stock_quantity' => fake()->numberBetween(1, 100),
        ];
    }
}
