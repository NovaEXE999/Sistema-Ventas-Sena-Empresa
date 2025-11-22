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

        $opProducts = ["Manzanas", "Plátanos", "Naranjas", "Uvas", "Zanahorias", "Papas", "Tomates", "Cebollas", "Pechuga de pollo", "Carne molida", "Salmón", "Arroz", "Frijoles", "Azúcar", "Harina", "Huevos", "Refrescos", "Yogures", "Latas de atún", "Botellas de agua", "Pan de caja", "Leche", "Queso", "Mantequilla", "Jabón de baño", "Shampoo", "Pasta dental", "Cepillo de dientes"];

        return [
            
            'name' => $this->faker->randomElement($opProducts),
            'quantity' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->randomFloat(2, 10000, 5000000),
            'category_id' => $this->faker->numberBetween(2, 10),
            'measure_id' => $this->faker->numberBetween(2, 10),
        ];
    }
}
