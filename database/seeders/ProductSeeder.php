<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Huevos A', 'stock' => 100, 'price' => 8000.00, 'status' => true, 'category_id' => 1],
            ['name' => 'Huevos AA', 'stock' => 75, 'price' => 9500.00, 'status' => true, 'category_id' => 1],
            ['name' => 'Huevos AAA', 'stock' => 50, 'price' => 11000.00, 'status' => true, 'category_id' => 1],
            ['name' => 'Platano', 'stock' => 80, 'price' => 1000.00, 'status' => true, 'category_id' => 2],
            ['name' => 'Manzanas', 'stock' => 100, 'price' => 12000.00, 'status' => true, 'category_id' => 3],
            ['name' => 'Bagre', 'stock' => 20, 'price' => 23000.00, 'status' => true, 'category_id' => 4],
            ['name' => 'Carne de cerdo', 'stock' => 20, 'price' => 15000.00, 'status' => true, 'category_id' => 5],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
