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
                'adres' => 'ул. Тверская, д. 12',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'sity' => 'Санкт-Петербург',
                'adres' => 'Невский проспект, д. 45',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'sity' => 'Новосибирск',
                'adres' => 'ул. Ленина, д. 1',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'sity' => 'Екатеринбург',
                'adres' => 'ул. Малышева, д. 51',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}