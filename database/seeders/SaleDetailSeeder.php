<?php

namespace Database\Seeders;

use App\Models\SaleDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $saleDetail = new SaleDetail();

        $saleDetail->quantity = '20';
        $saleDetail->total = '180000.00';
        $saleDetail->product_id = '1';
        $saleDetail->sale_id = '1';

        $saleDetail->save();
    }
}
