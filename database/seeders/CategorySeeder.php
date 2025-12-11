<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Huevos', 'measure_id' => 2, 'status' => true],
            ['name' => 'Verduras', 'measure_id' => 1, 'status' => true],
            ['name' => 'Frutas', 'measure_id' => 1, 'status' => true],
            ['name' => 'Pescado y Mariscos', 'measure_id' => 1, 'status' => true],
            ['name' => 'Carnes Frias', 'measure_id' => 1, 'status' => true],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
