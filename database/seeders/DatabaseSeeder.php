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
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Factories (10 registros por tabla, ordenados para evitar FK)
        /* Role::factory(10)->create();
        User::factory(10)->create();
        PersonType::factory(10)->create();
        ClientType::factory(10)->create(); */
        /* Measure::factory(10)->create(); */
        /* Category::factory(10)->create(); */
        /* PaymentMethod::factory(10)->create();
        Provider::factory(10)->create();
        Client::factory(10)->create();
        Product::factory(10)->create();
        ProductDelivery::factory(10)->create();
        Sale::factory(10)->create();
        SaleDetail::factory(10)->create(); */

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
        ]);

        // Usuario administrador predeterminado
        $adminRole = Role::firstWhere('name', 'Administrador') ?? Role::create([
            'name' => 'Administrador',
            'status' => true,
        ]);
        $vendorRole = Role::firstWhere('name', 'Vendedor') ?? Role::create([
            'name' => 'Vendedor',
            'status' => true,
        ]);

        $adminUser = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'identification' => '1234567890',
                'name' => 'admin',
                'phone_number' => '3001234567',
                'status' => true,
                'role_id' => $adminRole->id,
                'password' => Hash::make('admin1234'),
            ]
        );
        $vendorUser = User::updateOrCreate(
            ['email' => 'vendedor@gmail.com'],
            [
                'identification' => '0123456789',
                'name' => 'vendedor',
                'phone_number' => '3123456789',
                'status' => true,
                'role_id' => $vendorRole->id,
                'password' => Hash::make('vendedor1234'),
            ]
        );

        $this->call([
            SaleSeeder::class,
            SaleDetailSeeder::class,
        ]);
    }
}
