<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_stock' => 1,
                'id_product' => 1,
                'id_user' => 1,
                'date_stock' => '2024-02-25 08:00:00',
                'stock_quantity' => 100,
            ],
            [
                'id_stock' => 2,
                'id_product' => 2,
                'id_user' => 1,
                'date_stock' => '2024-02-25 08:15:00',
                'stock_quantity' => 50,
            ],
            [
                'id_stock' => 3,
                'id_product' => 3,
                'id_user' => 2,
                'date_stock' => '2024-02-25 09:00:00',
                'stock_quantity' => 75,
            ],
            [
                'id_stock' => 4,
                'id_product' => 4,
                'id_user' => 2,
                'date_stock' => '2024-02-25 09:30:00',
                'stock_quantity' => 60,
            ],
            [
                'id_stock' => 5,
                'id_product' => 5,
                'id_user' => 3,
                'date_stock' => '2024-02-25 10:00:00',
                'stock_quantity' => 40,
            ],
            [
                'id_stock' => 6,
                'id_product' => 6,
                'id_user' => 3,
                'date_stock' => '2024-02-25 10:30:00',
                'stock_quantity' => 45,
            ],
            [
                'id_stock' => 7,
                'id_product' => 7,
                'id_user' => 1,
                'date_stock' => '2024-02-25 11:00:00',
                'stock_quantity' => 30,
            ],
            [
                'id_stock' => 8,
                'id_product' => 8,
                'id_user' => 2,
                'date_stock' => '2024-02-25 11:30:00',
                'stock_quantity' => 25,
            ],
            [
                'id_stock' => 9,
                'id_product' => 9,
                'id_user' => 3,
                'date_stock' => '2024-02-25 13:00:00',
                'stock_quantity' => 35,
            ],
            [
                'id_stock' => 10,
                'id_product' => 10,
                'id_user' => 1,
                'date_stock' => '2024-02-25 13:30:00',
                'stock_quantity' => 55,
            ],
        ];

        DB::table('t_stock')->insert($data);
    }
}
