<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total_value' => $this->faker->randomFloat(2, 10000, 5000000),
            'date' => $this->faker->dateTimeThisMonth(),
            'user_id' => $this->faker->numberBetween(2, 10),
            'client_id' => $this->faker->numberBetween(2, 10)
        ];
    }
}
