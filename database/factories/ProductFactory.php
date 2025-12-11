<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $opProducts = ["Huevos A", "Huevos AA", "Huevos AAA", "Platano", "Manzanas", "Bagre", "Carne de cerdo"];
        $categoryId = Category::query()->inRandomOrder()->value('id') ?? Category::factory();

        return [
            'name' => $this->faker->randomElement($opProducts),
            'stock' => $this->faker->numberBetween(1, 200),
            'price' => $this->faker->randomFloat(2, 10000, 50000),
            'status' => true,
            'category_id' => $categoryId,
        ];
    }
}
