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
        return [
            'date' => $this->faker->dateTimeThisMonth(),
            'delivered_amount' => $this->faker->numberBetween(100, 1000),
            'product_id' => $this->faker->numberBetween(2, 10),
            'provider_id' => $this->faker->numberBetween(2, 10),
        ];
    }
}
