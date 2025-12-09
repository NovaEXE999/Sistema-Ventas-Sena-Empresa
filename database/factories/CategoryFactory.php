<?php

namespace Database\Factories;

use App\Models\Measure;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $opCategories = ['Huevos', 'Verduras', 'Mekatos', 'Entretenimiento', 'Deportes', 'Carnes Frias', 'Lacteos'];
        $measureId = Measure::query()->inRandomOrder()->value('id') ?? Measure::factory();

        return [
            'name' => $this->faker->randomElement($opCategories),
            'status' => true,
            'measure_id' => $measureId,
        ];
    }
}
