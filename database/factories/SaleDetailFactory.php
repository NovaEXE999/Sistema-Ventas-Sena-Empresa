<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Sale;
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
        $productId = Product::query()->inRandomOrder()->value('id') ?? Product::factory();
        $saleId = Sale::query()->inRandomOrder()->value('id') ?? Sale::factory();
        $price = is_numeric($productId)
            ? Product::find($productId)?->price ?? $this->faker->randomFloat(2, 1000, 500000)
            : $this->faker->randomFloat(2, 1000, 500000);
        $quantity = $this->faker->numberBetween(1, 30);

        return [
            'quantity' => $quantity,
            'price' => $price,
            'subtotal' => $price * $quantity,
            'product_id' => $productId,
            'sale_id' => $saleId,
        ];
    }
}
