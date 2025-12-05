<?php

namespace Database\Factories;

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
        $productId = \App\Models\Product::query()->inRandomOrder()->value('id') ?? \App\Models\Product::factory();
        $providerId = \App\Models\Provider::query()->inRandomOrder()->value('id') ?? \App\Models\Provider::factory();

        return [
            'date' => $this->faker->dateTimeThisMonth(),
            'delivered_amount' => $this->faker->numberBetween(100, 1000),
            'product_id' => $productId,
            'provider_id' => $providerId,
        ];
    }
}
