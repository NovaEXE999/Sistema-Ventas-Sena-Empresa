<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\PaymentMethod;
use App\Models\User;
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
        $userId = User::query()->inRandomOrder()->value('id') ?? User::factory();
        $clientId = Client::query()->inRandomOrder()->value('id') ?? Client::factory();
        $paymentMethodId = PaymentMethod::query()->inRandomOrder()->value('id') ?? PaymentMethod::factory();

        return [
            'total_value' => $this->faker->randomFloat(2, 10000, 5000000),
            'date' => $this->faker->dateTimeThisMonth(),
            'user_id' => $userId,
            'client_id' => $clientId,
            'payment_method_id' => $paymentMethodId,
        ];
    }
}
