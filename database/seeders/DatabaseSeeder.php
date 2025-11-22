<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Client;
use App\Models\Measure;
use App\Models\Product;
use App\Models\ProductDelivery;
use App\Models\Provider;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Client::factory(10)->create();
        Category::factory(10)->create(); 
        Measure::factory(10)->create();
        Provider::factory(10)->create();
        Product::factory(10)->create();
        ProductDelivery::factory(10)->create();
        Sale::factory(10)->create();
        SaleDetail::factory(10)->create();
        

        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */

        $this->call([
            CategorySeeder::class,
            ClientSeeder::class,
            MeasureSeeder::class,
            ProviderSeeder::class,
            ProductSeeder::class,
            ProductDeliverySeeder::class,   
            SaleSeeder::class,
            SaleDetailSeeder::class,
        ]);
    }
}
