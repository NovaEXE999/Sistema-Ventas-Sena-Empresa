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
        //
        $client = new Client();

        $client->first_name = 'Cristiano';
        $client->middle_name = 'Ronaldo';
        $client->last_name = 'Do santos';
        $client->second_last_name = 'Aveiro';

        $client->save();
    }
}
