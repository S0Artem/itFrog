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

        $statuses = ['Новая', 'В работе', 'Отказ', 'Обработана', 'Пользователь создан', 'Готовая'];
        $userIds = DB::table('users')->where('role', 'user')->pluck('id')->toArray();
        $branchIds = DB::table('branches')->pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) {
            $gender = $faker->randomElement(['male', 'female']);
            $userName = $faker->lastName($gender) . ' ' . $faker->firstName($gender) . ' ' . $faker->middleName($gender);
            $studentName = $faker->lastName($gender) . ' ' . $faker->firstName($gender) . ' ' . $faker->middleName($gender);

            $applications[] = [
                'number' => $faker->unique()->numerify('+7(9##)-###-##-##'),
                'name' => $userName,
                'email' => $faker->unique()->safeEmail,
                'student_name' => $studentName,
                'student_birth_date' => $faker->dateTimeBetween('-17 years', '-6 years')->format('Y-m-d'),
                'branch_id' => $faker->randomElement($branchIds),
                'user_id' => $faker->randomElement($userIds),
                'student_id' => null,
                'employee_id' => null,
                'status' => $statuses[array_rand($statuses)],
                'created_at' => $faker->dateTimeBetween('-3 months', 'now', 'Europe/Moscow'),
                'updated_at' => now()->setTimezone('Europe/Moscow'),
            ];
        }

        DB::table('applications')->insert($applications);
    }
}
