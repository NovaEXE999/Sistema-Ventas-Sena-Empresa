<?php

namespace Database\Seeders;

use App\Models\ProductDelivery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductDeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $productDeliveries = new ProductDelivery();

        $productDeliveries->date = now();
        $productDeliveries->delivered_amount = '90';
        $productDeliveries->product_id = '1';
        $productDeliveries->provider_id = '1';

        $productDeliveries->save();
    }
}
