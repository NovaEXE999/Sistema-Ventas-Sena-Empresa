<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SaleDetail>
 */
class SaleDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productId = \App\Models\Product::query()->inRandomOrder()->value('id') ?? \App\Models\Product::factory();
        $saleId = \App\Models\Sale::query()->inRandomOrder()->value('id') ?? \App\Models\Sale::factory();

        return [
            'quantity' => $this->faker->numberBetween(1, 30),
            'subtotal' => $this->faker->randomFloat(2, 10000, 5000000),
            'product_id' => $productId,
            'sale_id' => $saleId,
        ];
    }
}
