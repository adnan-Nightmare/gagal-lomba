<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shippingMethods = [
            ['name' => 'ANexpress', 'cost' => 20.00],
            ['name' => 'Jokoexpress', 'cost' => 25.00],
            ['name' => 'Gojoexpress', 'cost' => 15.00],
        ];

        foreach($shippingMethods as $shippingMethod){
            ShippingMethod::create($shippingMethod);
        }
    }
}
