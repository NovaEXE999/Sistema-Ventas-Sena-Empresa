<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'identification' => '9001234567',
                'name' => 'Cristiano Ronaldo Do Santos Aveiro',
                'phone_number' => '3001234567',
                'status' => true,
                'client_type_id' => 1,
            ],
            [
                'identification' => '8009876543',
                'name' => 'Lionel Andres Messi',
                'phone_number' => '3019876543',
                'status' => true,
                'client_type_id' => 2,
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
