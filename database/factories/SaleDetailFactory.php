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
        return [
            'quantity' => $this->faker->numberBetween(1, 30),
            'total' => $this->faker->randomFloat(2, 10000, 5000000),
            'product_id' => $this->faker->numberBetween(2, 10),
            'sale_id' => $this->faker->numberBetween(2, 10)
        ];
    }
}
