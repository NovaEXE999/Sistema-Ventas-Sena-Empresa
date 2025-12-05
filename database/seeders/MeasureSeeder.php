<?php

namespace Database\Seeders;

use App\Models\Measure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeasureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $measures = [
            ['name' => 'Und', 'status' => true],
            ['name' => 'Kg', 'status' => true],
            ['name' => 'Lt', 'status' => true],
            ['name' => 'Lb', 'status' => true],
            ['name' => 'Canastas', 'status' => true],
        ];

        foreach ($measures as $measure) {
            Measure::create($measure);
        }
    }
}
