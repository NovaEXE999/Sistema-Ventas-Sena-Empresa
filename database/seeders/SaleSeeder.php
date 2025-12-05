<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sale = new Sale();

        $sale->total_value = '180000';
        $sale->date = now();
        $sale->user_id = 1;
        $sale->client_id = 1;
        $sale->payment_method_id = 1;

        $sale->save();

    }
}
