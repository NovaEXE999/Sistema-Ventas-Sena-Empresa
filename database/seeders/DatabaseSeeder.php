<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Client;
use App\Models\ClientType;
use App\Models\Measure;
use App\Models\PaymentMethod;
use App\Models\PersonType;
use App\Models\Product;
use App\Models\ProductDelivery;
use App\Models\Provider;
use App\Models\Role;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Factories (10 registros por tabla, ordenados para evitar FK)
        Role::factory(10)->create();
        User::factory(10)->create();
        PersonType::factory(10)->create();
        ClientType::factory(10)->create();
        /* Measure::factory(10)->create(); */
        /* Category::factory(10)->create(); */
        PaymentMethod::factory(10)->create();
        Provider::factory(10)->create();
        Client::factory(10)->create();
        Product::factory(10)->create();
        ProductDelivery::factory(10)->create();
        Sale::factory(10)->create();
        SaleDetail::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            PersonTypeSeeder::class,
            ClientTypeSeeder::class,
            MeasureSeeder::class,
            CategorySeeder::class,
            ProviderSeeder::class,
            ClientSeeder::class,
            ProductSeeder::class,
            ProductDeliverySeeder::class,   
            PaymentMethodSeeder::class,
            SaleSeeder::class,
            SaleDetailSeeder::class,
        ]);
    }
}
