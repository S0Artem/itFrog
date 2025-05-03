<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StudentsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('ru_RU');
        $students = [];

        for ($i = 0; $i < 500; $i++) {
            $students[] = [
                'birthdate' => $faker->dateTimeBetween('-15 years', '-6 years')->format('Y-m-d'),
                'branche_id' => $faker->numberBetween(1, 4),
                'user_id' => $faker->numberBetween(2, 55), // ID родителей (от 2 потому что 1 - админ)
                'name' => $faker->firstName . ' ' . $faker->lastName,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('students')->insert($students);
    }
}