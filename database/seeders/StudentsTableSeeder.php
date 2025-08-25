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
        $userIds = DB::table('users')->where('role', 'user')->pluck('id')->toArray();
        $branchIds = DB::table('branches')->pluck('id')->toArray();

        // Перемешиваем ID родителей для случайного распределения
        shuffle($userIds);

        // Распределяем студентов:
        // - 83 родителя с 1 учеником
        // - 84 родителя с 2 учениками
        // - 83 родителя с 3 учениками
        $index = 0;

        // 83 родителя с 1 учеником
        for ($i = 0; $i < 83; $i++) {
            $gender = $faker->randomElement(['male', 'female']);
            $students[] = [
                'birthdate' => $faker->dateTimeBetween('-15 years', '-6 years')->format('Y-m-d'),
                'branch_id' => $faker->randomElement($branchIds),
                'user_id' => $userIds[$index],
                'name' => $faker->lastName($gender) . ' ' . $faker->firstName($gender) . ' ' . $faker->middleName($gender),
                'created_at' => now(),
                'updated_at' => now()
            ];
            $index++;
        }

        // 84 родителя с 2 учениками
        for ($i = 0; $i < 84; $i++) {
            for ($j = 0; $j < 2; $j++) {
                $gender = $faker->randomElement(['male', 'female']);
                $students[] = [
                    'birthdate' => $faker->dateTimeBetween('-15 years', '-6 years')->format('Y-m-d'),
                    'branch_id' => $faker->randomElement($branchIds),
                    'user_id' => $userIds[$index],
                    'name' => $faker->lastName($gender) . ' ' . $faker->firstName($gender) . ' ' . $faker->middleName($gender),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            $index++;
        }

        // 83 родителя с 3 учениками
        for ($i = 0; $i < 83; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $gender = $faker->randomElement(['male', 'female']);
                $students[] = [
                    'birthdate' => $faker->dateTimeBetween('-15 years', '-6 years')->format('Y-m-d'),
                    'branch_id' => $faker->randomElement($branchIds),
                    'user_id' => $userIds[$index],
                    'name' => $faker->lastName($gender) . ' ' . $faker->firstName($gender) . ' ' . $faker->middleName($gender),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            $index++;
        }

        DB::table('students')->insert($students);
    }
}