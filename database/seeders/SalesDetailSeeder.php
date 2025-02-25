<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Sale 1 items
            [
                'id_sales_detail' => 1,
                'id_sales' => 1,
                'id_product' => 1,
                'price' => 3000,
                'qty' => 3,
            ],
            [
                'id_sales_detail' => 2,
                'id_sales' => 1,
                'id_product' => 2,
                'price' => 10000,
                'qty' => 1,
            ],
            [
                'id_sales_detail' => 3,
                'id_sales' => 1,
                'id_product' => 3,
                'price' => 5000,
                'qty' => 2,
            ],
            // Sale 2 items
            [
                'id_sales_detail' => 4,
                'id_sales' => 2,
                'id_product' => 4,
                'price' => 7000,
                'qty' => 2,
            ],
            [
                'id_sales_detail' => 5,
                'id_sales' => 2,
                'id_product' => 5,
                'price' => 15000,
                'qty' => 1,
            ],
            [
                'id_sales_detail' => 6,
                'id_sales' => 2,
                'id_product' => 6,
                'price' => 10000,
                'qty' => 2,
            ],
            // Sale 3 items
            [
                'id_sales_detail' => 7,
                'id_sales' => 3,
                'id_product' => 7,
                'price' => 18000,
                'qty' => 1,
            ],
            [
                'id_sales_detail' => 8,
                'id_sales' => 3,
                'id_product' => 8,
                'price' => 25000,
                'qty' => 1,
            ],
            [
                'id_sales_detail' => 9,
                'id_sales' => 3,
                'id_product' => 9,
                'price' => 30000,
                'qty' => 1,
            ],
            // Sale 4 items
            [
                'id_sales_detail' => 10,
                'id_sales' => 4,
                'id_product' => 10,
                'price' => 12000,
                'qty' => 2,
            ],
            [
                'id_sales_detail' => 11,
                'id_sales' => 4,
                'id_product' => 1,
                'price' => 3000,
                'qty' => 5,
            ],
            [
                'id_sales_detail' => 12,
                'id_sales' => 4,
                'id_product' => 2,
                'price' => 10000,
                'qty' => 1,
            ],
            // Sale 5 items
            [
                'id_sales_detail' => 13,
                'id_sales' => 5,
                'id_product' => 3,
                'price' => 5000,
                'qty' => 3,
            ],
            [
                'id_sales_detail' => 14,
                'id_sales' => 5,
                'id_product' => 4,
                'price' => 7000,
                'qty' => 2,
            ],
            [
                'id_sales_detail' => 15,
                'id_sales' => 5,
                'id_product' => 5,
                'price' => 15000,
                'qty' => 1,
            ],
            // Sale 6 items
            [
                'id_sales_detail' => 16,
                'id_sales' => 6,
                'id_product' => 6,
                'price' => 10000,
                'qty' => 2,
            ],
            [
                'id_sales_detail' => 17,
                'id_sales' => 6,
                'id_product' => 7,
                'price' => 18000,
                'qty' => 1,
            ],
            [
                'id_sales_detail' => 18,
                'id_sales' => 6,
                'id_product' => 8,
                'price' => 25000,
                'qty' => 1,
            ],
            // Sale 7 items
            [
                'id_sales_detail' => 19,
                'id_sales' => 7,
                'id_product' => 9,
                'price' => 30000,
                'qty' => 1,
            ],
            [
                'id_sales_detail' => 20,
                'id_sales' => 7,
                'id_product' => 10,
                'price' => 12000,
                'qty' => 2,
            ],
            [
                'id_sales_detail' => 21,
                'id_sales' => 7,
                'id_product' => 1,
                'price' => 3000,
                'qty' => 4,
            ],
            // Sale 8 items
            [
                'id_sales_detail' => 22,
                'id_sales' => 8,
                'id_product' => 2,
                'price' => 10000,
                'qty' => 2,
            ],
            [
                'id_sales_detail' => 23,
                'id_sales' => 8,
                'id_product' => 3,
                'price' => 5000,
                'qty' => 3,
            ],
            [
                'id_sales_detail' => 24,
                'id_sales' => 8,
                'id_product' => 4,
                'price' => 7000,
                'qty' => 2,
            ],
            // Sale 9 items
            [
                'id_sales_detail' => 25,
                'id_sales' => 9,
                'id_product' => 5,
                'price' => 15000,
                'qty' => 2,
            ],
            [
                'id_sales_detail' => 26,
                'id_sales' => 9,
                'id_product' => 6,
                'price' => 10000,
                'qty' => 3,
            ],
            [
                'id_sales_detail' => 27,
                'id_sales' => 9,
                'id_product' => 7,
                'price' => 18000,
                'qty' => 1,
            ],
            // Sale 10 items
            [
                'id_sales_detail' => 28,
                'id_sales' => 10,
                'id_product' => 8,
                'price' => 25000,
                'qty' => 1,
            ],
            [
                'id_sales_detail' => 29,
                'id_sales' => 10,
                'id_product' => 9,
                'price' => 30000,
                'qty' => 1,
            ],
            [
                'id_sales_detail' => 30,
                'id_sales' => 10,
                'id_product' => 10,
                'price' => 12000,
                'qty' => 2,
            ],
        ];

        DB::table('t_sales_detail')->insert($data);
    }
}
