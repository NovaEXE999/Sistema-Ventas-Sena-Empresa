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
        $userId = \App\Models\User::query()->inRandomOrder()->value('id') ?? \App\Models\User::factory();
        $clientId = \App\Models\Client::query()->inRandomOrder()->value('id') ?? \App\Models\Client::factory();
        $paymentMethodId = \App\Models\PaymentMethod::query()->inRandomOrder()->value('id') ?? \App\Models\PaymentMethod::factory();

        return [
            'total_value' => $this->faker->randomFloat(2, 10000, 5000000),
            'date' => $this->faker->dateTimeThisMonth(),
            'user_id' => $userId,
            'client_id' => $clientId,
            'payment_method_id' => $paymentMethodId,
        ];
    }
}
