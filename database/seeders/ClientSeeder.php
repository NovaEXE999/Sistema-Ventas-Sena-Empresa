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
                'client_type_id' => 2,
            ],
            [
                'identification' => '8009876543',
                'name' => 'Lionel Andres Messi',
                'phone_number' => '3019876543',
                'status' => true,
                'client_type_id' => 1,
            ],
            [
                'identification' => '8009876573',
                'name' => 'Neymar Da Silva',
                'phone_number' => '3019874618',
                'status' => true,
                'client_type_id' => 4,
            ],
            [
                'identification' => '8009876593',
                'name' => 'William Tesillo',
                'phone_number' => '3019874698',
                'status' => true,
                'client_type_id' => 4,
            ],
            [
                'identification' => '9009876512',
                'name' => 'Sebastian Castellanos',
                'phone_number' => '3019874692',
                'status' => true,
                'client_type_id' => 3,
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
