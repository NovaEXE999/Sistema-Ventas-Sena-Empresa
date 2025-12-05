<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $clientTypeId = \App\Models\ClientType::query()->inRandomOrder()->value('id') ?? \App\Models\ClientType::factory();

        return [
            'identification' => $this->faker->unique()->numerify('##########'),
            'name' => $this->faker->name(),
            'phone_number' => $this->faker->numerify('3#########'),
            'status' => true,
            'client_type_id' => $clientTypeId,
        ];
    }
}
