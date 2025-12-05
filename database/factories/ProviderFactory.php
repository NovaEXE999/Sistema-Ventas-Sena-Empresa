<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provider>
 */
class ProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $personTypeId = \App\Models\PersonType::query()->inRandomOrder()->value('id') ?? \App\Models\PersonType::factory();

        return [
            'identification' => $this->faker->unique()->numerify('##########'),
            'name' => $this->faker->company(),
            'phone_number' => $this->faker->numerify('3#########'),
            'status' => true,
            'person_type_id' => $personTypeId,
        ];
    }
}
