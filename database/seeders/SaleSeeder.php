<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\User;
use App\Models\Client;
use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstWhere('email', 'vendedor@gmail.com') ?? User::first();
        $client = Client::first();
        $paymentMethod = PaymentMethod::first();

        if ($user && $client && $paymentMethod) {
            $sale = new Sale();
            $sale->total_value = 180000;
            $sale->date = now();
            $sale->user_id = $user->id;
            $sale->client_id = $client->id;
            $sale->payment_method_id = $paymentMethod->id;
            $sale->save();
        }

    }
}
