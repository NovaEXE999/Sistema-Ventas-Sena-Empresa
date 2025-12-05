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
        $deliveries = [
            ['date' => now(), 'delivered_amount' => 90, 'product_id' => 1, 'provider_id' => 1],
            ['date' => now(), 'delivered_amount' => 60, 'product_id' => 2, 'provider_id' => 2],
        ];

        foreach ($deliveries as $delivery) {
            ProductDelivery::create($delivery);
        }
    }
}
