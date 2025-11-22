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
        $product = new Product();

        $product->name = 'Jabon';
        $product->quantity = '200';
        $product->price = '9000.00';
        $product->category_id = '1';
        $product->measure_id = '1';

        $product->save();
    }
}
