<?php

namespace Database\Seeders;

use App\Models\PersonType;
use Illuminate\Database\Seeder;

class PersonTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Natural', 'status' => true],
            ['name' => 'Juridica', 'status' => true],
        ];

        foreach ($types as $type) {
            PersonType::create($type);
        }
    }
}
