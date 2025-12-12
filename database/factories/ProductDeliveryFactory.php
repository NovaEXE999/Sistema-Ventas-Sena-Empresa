<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductDelivery>
 */
class ProductDeliveryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productId = Product::query()->inRandomOrder()->value('id') ?? Product::factory();
        $providerId = Provider::query()->inRandomOrder()->value('id') ?? Provider::factory();

        return [
            'date' => $this->faker->dateTimeThisMonth(),
            'delivered_amount' => $this->faker->numberBetween(100, 1000),
            'product_id' => $productId,
            'provider_id' => $providerId,
        ];
    }
}
