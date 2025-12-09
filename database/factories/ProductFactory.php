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

        $opProducts = ["Manzanas", "Platanos", "Naranjas", "Uvas", "Zanahorias", "Papas", "Tomates", "Cebollas", "Pechuga de pollo", "Carne molida", "Salmón", "Arroz", "Frijoles", "Azカcar", "Harina", "Huevos", "Refrescos", "Yogures", "Latas de atun", "Botellas de agua", "Pan de caja", "Leche", "Queso", "Mantequilla", "Jabon de baño", "Shampoo", "Pasta dental", "Cepillo de dientes"];
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
