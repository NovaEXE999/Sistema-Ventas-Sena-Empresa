<?php

namespace Database\Factories;

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

        $opProducts = ["Manzanas", "Plケtanos", "Naranjas", "Uvas", "Zanahorias", "Papas", "Tomates", "Cebollas", "Pechuga de pollo", "Carne molida", "SalmИn", "Arroz", "Frijoles", "Azカcar", "Harina", "Huevos", "Refrescos", "Yogures", "Latas de atカn", "Botellas de agua", "Pan de caja", "Leche", "Queso", "Mantequilla", "JabИn de baヵo", "Shampoo", "Pasta dental", "Cepillo de dientes"];
        $categoryId = \App\Models\Category::query()->inRandomOrder()->value('id') ?? \App\Models\Category::factory();

        return [
            'name' => $this->faker->randomElement($opProducts),
            'stock' => $this->faker->numberBetween(1, 200),
            'price' => $this->faker->randomFloat(2, 10000, 5000000),
            'status' => true,
            'category_id' => $categoryId,
        ];
    }
}
