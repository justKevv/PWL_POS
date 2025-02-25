<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_sales' => 1,
                'id_user' => 3, // staff/kasir
                'buyer' => 'John Doe',
                'sales_code' => 'SALE/2024/02/25/001',
                'sales_date' => '2024-02-25 09:30:00',
            ],
            [
                'id_sales' => 2,
                'id_user' => 3,
                'buyer' => 'Jane Smith',
                'sales_code' => 'SALE/2024/02/25/002',
                'sales_date' => '2024-02-25 10:15:00',
            ],
            [
                'id_sales' => 3,
                'id_user' => 3,
                'buyer' => 'Robert Johnson',
                'sales_code' => 'SALE/2024/02/25/003',
                'sales_date' => '2024-02-25 11:00:00',
            ],
            [
                'id_sales' => 4,
                'id_user' => 3,
                'buyer' => 'Mary Williams',
                'sales_code' => 'SALE/2024/02/25/004',
                'sales_date' => '2024-02-25 11:45:00',
            ],
            [
                'id_sales' => 5,
                'id_user' => 2, // manager
                'buyer' => 'David Brown',
                'sales_code' => 'SALE/2024/02/25/005',
                'sales_date' => '2024-02-25 13:20:00',
            ],
            [
                'id_sales' => 6,
                'id_user' => 3,
                'buyer' => 'Sarah Davis',
                'sales_code' => 'SALE/2024/02/25/006',
                'sales_date' => '2024-02-25 14:05:00',
            ],
            [
                'id_sales' => 7,
                'id_user' => 3,
                'buyer' => 'Michael Wilson',
                'sales_code' => 'SALE/2024/02/25/007',
                'sales_date' => '2024-02-25 15:30:00',
            ],
            [
                'id_sales' => 8,
                'id_user' => 3,
                'buyer' => 'Lisa Anderson',
                'sales_code' => 'SALE/2024/02/25/008',
                'sales_date' => '2024-02-25 16:15:00',
            ],
            [
                'id_sales' => 9,
                'id_user' => 2,
                'buyer' => 'James Taylor',
                'sales_code' => 'SALE/2024/02/25/009',
                'sales_date' => '2024-02-25 17:00:00',
            ],
            [
                'id_sales' => 10,
                'id_user' => 3,
                'buyer' => 'Emma Martinez',
                'sales_code' => 'SALE/2024/02/25/010',
                'sales_date' => '2024-02-25 17:45:00',
            ],
        ];

        DB::table('t_sales')->insert($data);
    }
}
