<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('employees')->insert([
            ['id' => 2, 'branche_id' => 1], // Москва (user_id = 2)
            ['id' => 3, 'branche_id' => 2], // СПб (user_id = 3)
            ['id' => 4, 'branche_id' => 3], // Новосибирск (user_id = 4)
            ['id' => 5, 'branche_id' => 4], // Екатеринбург (user_id = 5)
            ['id' => 6, 'branche_id' => 1], // Доп преподаватель Москва
            ['id' => 7, 'branche_id' => 2]  // Доп преподаватель СПб
        ]);
    }
}