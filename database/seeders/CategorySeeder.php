<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_category' => 1,
                'code_category' => 'FOOD',
                'name_category' => 'Food and Beverages',
            ],
            [
                'id_category' => 2,
                'code_category' => 'SNACK',
                'name_category' => 'Snacks and Confectionery',
            ],
            [
                'id_category' => 3,
                'code_category' => 'DAIRY',
                'name_category' => 'Dairy Products',
            ],
            [
                'id_category' => 4,
                'code_category' => 'HOUSE',
                'name_category' => 'Household Items',
            ],
            [
                'id_category' => 5,
                'code_category' => 'PERSONAL',
                'name_category' => 'Personal Care',
            ],
        ];

        DB::table('m_category')->insert($data);
    }
}
