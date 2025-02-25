<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_user' => 1,
                'id_level' => 1,
                'username' => 'admin',
                'name' => 'Administrator',
                'password' => Hash::make('12345'),
            ],
            [
                'id_user' => 2,
                'id_level' => 2,
                'username' => 'manager',
                'name' => 'Manager',
                'password' => Hash::make('12345'),
            ],
            [
                'id_user' => 3,
                'id_level' => 3,
                'username' => 'staff',
                'name' => 'Staff/Kasir',
                'password' => Hash::make('12345'),
            ],
        ];

        DB::table('m_user')->insert($data);
    }
}
