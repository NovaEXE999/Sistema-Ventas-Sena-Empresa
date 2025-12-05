<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $providers = [
            [
                'identification' => '123450001',
                'name' => 'Jabones S.A.S',
                'phone_number' => '3201112233',
                'status' => true,
                'person_type_id' => 2,
            ],
            [
                'identification' => '123450002',
                'name' => 'Mercados La 14',
                'phone_number' => '3204445566',
                'status' => true,
                'person_type_id' => 2,
            ],
        ];

        foreach ($providers as $provider) {
            Provider::create($provider);
        }
    }
}
