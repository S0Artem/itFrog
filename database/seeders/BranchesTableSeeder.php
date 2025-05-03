<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('branches')->insert([
            [
                'sity' => 'Москва',
                'adres' => 'ул. Тверская, 12',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'sity' => 'Санкт-Петербург',
                'adres' => 'Невский проспект, 45',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'sity' => 'Новосибирск',
                'adres' => 'ул. Ленина, 1',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'sity' => 'Екатеринбург',
                'adres' => 'ул. Малышева, 51',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}