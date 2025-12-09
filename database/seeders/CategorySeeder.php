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
            ['name' => 'Limpieza y Desinfeccion', 'measure_id' => 1, 'status' => true],
            ['name' => 'Abarrotes', 'measure_id' => 1, 'status' => true],
            ['name' => 'Bebidas', 'measure_id' => 3, 'status' => true],
            ['name' => 'Lacteos', 'measure_id' => 5, 'status' => true],
            ['name' => 'Huevos', 'measure_id' => 5, 'status' => true],
            ['name' => 'Verduras', 'measure_id' => 4, 'status' => true],
            ['name' => 'Mekatos', 'measure_id' => 1, 'status' => true],
            ['name' => 'Entretenimiento', 'measure_id' => 1, 'status' => true],
            ['name' => 'Deportes', 'measure_id' => 1, 'status' => true],
            ['name' => 'Carnes Frias', 'measure_id' => 2, 'status' => true],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
