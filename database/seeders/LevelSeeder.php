<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_level' => 1, 'code_level' => 'ADM', 'name_level' => 'Administrator'],
            ['id_level' => 2, 'code_level' => 'MNG', 'name_level' => 'Manager'],
            ['id_level' => 3, 'code_level' => 'STF', 'name_level' => 'Staff'],
        ];

        DB::table('m_level')->insert($data);
    }
}
