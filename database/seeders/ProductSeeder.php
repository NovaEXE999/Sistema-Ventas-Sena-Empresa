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
            ['name' => 'Jabon', 'stock' => 200, 'price' => 9000.00, 'status' => true, 'category_id' => 1],
            ['name' => 'Detergente', 'stock' => 150, 'price' => 12000.00, 'status' => true, 'category_id' => 1],
            ['name' => 'Arroz 500g', 'stock' => 300, 'price' => 3500.00, 'status' => true, 'category_id' => 2],
            ['name' => 'Gaseosa 1.5Lt', 'stock' => 80, 'price' => 4500.00, 'status' => true, 'category_id' => 3],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
