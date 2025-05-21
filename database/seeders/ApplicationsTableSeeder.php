<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ApplicationsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('ru_RU');
        $applications = [];

        $statuses = ['Новая', 'В работе', 'Отказ', 'Обработана', 'Созданная'];

        for ($i = 0; $i < 50; $i++) {
            $gender = $faker->randomElement(['male', 'female']); // случайный пол

            $userName = $faker->lastName($gender) . ' ' . $faker->firstName($gender) . ' ' . $faker->middleName($gender);
            $studentName = $faker->lastName($gender) . ' ' . $faker->firstName($gender) . ' ' . $faker->middleName($gender);

            $applications[] = [
                'number' => '+7(9' . $faker->numerify('##) ###-##-##'),
                'name' => $userName,
                'email' => $faker->unique()->safeEmail,
                'student_name' => $studentName,
                'student_birth_date' => $faker->dateTimeBetween('-17 years', '-6 years')->format('Y-m-d'),
                'branche_id' => $faker->numberBetween(1, 4),
                'status' => $statuses[array_rand($statuses)],
                'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
                'updated_at' => now(),
            ];
        }


        DB::table('aplications')->insert($applications);
    }
}
