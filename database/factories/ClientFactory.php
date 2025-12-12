<?php

namespace Database\Factories;

use App\Models\ClientType;
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
        $clientTypeId = ClientType::query()->inRandomOrder()->value('id') ?? ClientType::factory();

        return [
            'identification' => $this->faker->unique()->numerify('##########'),
            'name' => $this->faker->name(),
            'phone_number' => $this->faker->numerify('3#########'),
            'status' => true,
            'client_type_id' => $clientTypeId,
        ];
    }
}
