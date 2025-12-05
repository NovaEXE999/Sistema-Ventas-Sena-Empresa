<?php

namespace Database\Seeders;

use App\Models\ClientType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Aprendiz', 'status' => true],
            ['name' => 'Instructor', 'status' => true],
            ['name' => 'Funcionario', 'status' => true],
            ['name' => 'Externo', 'status' => true],
        ];

        foreach ($types as $type) {
            ClientType::create($type);
        }
    }
}
