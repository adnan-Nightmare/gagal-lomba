<?php

namespace Database\Seeders;

use App\Models\category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorys = [
            ['name' => 'Home & Kitchen'],
            ['name' => 'Electronics'],
            ['name' => 'Clothing'],
            ['name' => 'Sports'],
            ['name' => 'Beauty'],
            ['name' => 'Toys'],
        ];

        foreach($categorys as $category){
            category::create($category);
        }
    }
}
