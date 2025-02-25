<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_product' => 1,
                'id_category' => 1, // FOOD
                'product_code' => 'FOD001',
                'product_name' => 'Instant Noodles',
                'purchase_price' => 2500,
                'selling_price' => 3000,
            ],
            [
                'id_product' => 2,
                'id_category' => 1, // FOOD
                'product_code' => 'FOD002',
                'product_name' => 'Canned Sardines',
                'purchase_price' => 8000,
                'selling_price' => 10000,
            ],
            [
                'id_product' => 3,
                'id_category' => 2, // SNACK
                'product_code' => 'SNK001',
                'product_name' => 'Potato Chips',
                'purchase_price' => 4000,
                'selling_price' => 5000,
            ],
            [
                'id_product' => 4,
                'id_category' => 2, // SNACK
                'product_code' => 'SNK002',
                'product_name' => 'Chocolate Bar',
                'purchase_price' => 5500,
                'selling_price' => 7000,
            ],
            [
                'id_product' => 5,
                'id_category' => 3, // DAIRY
                'product_code' => 'DRY001',
                'product_name' => 'Fresh Milk 1L',
                'purchase_price' => 12000,
                'selling_price' => 15000,
            ],
            [
                'id_product' => 6,
                'id_category' => 3, // DAIRY
                'product_code' => 'DRY002',
                'product_name' => 'Yogurt',
                'purchase_price' => 8000,
                'selling_price' => 10000,
            ],
            [
                'id_product' => 7,
                'id_category' => 4, // HOUSE
                'product_code' => 'HOU001',
                'product_name' => 'Dish Soap',
                'purchase_price' => 15000,
                'selling_price' => 18000,
            ],
            [
                'id_product' => 8,
                'id_category' => 4, // HOUSE
                'product_code' => 'HOU002',
                'product_name' => 'Floor Cleaner',
                'purchase_price' => 20000,
                'selling_price' => 25000,
            ],
            [
                'id_product' => 9,
                'id_category' => 5, // PERSONAL
                'product_code' => 'PER001',
                'product_name' => 'Shampoo',
                'purchase_price' => 25000,
                'selling_price' => 30000,
            ],
            [
                'id_product' => 10,
                'id_category' => 5, // PERSONAL
                'product_code' => 'PER002',
                'product_name' => 'Toothpaste',
                'purchase_price' => 10000,
                'selling_price' => 12000,
            ],
        ];

        DB::table('m_product')->insert($data);
    }
}
