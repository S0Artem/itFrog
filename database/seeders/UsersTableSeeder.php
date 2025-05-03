<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('ru_RU');

        // Администратор
        DB::table('users')->insert([
            'name' => 'Администратор',
            'email' => 'so.artem998@gmail.com',
            'password' => Hash::make('25071983EEe'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Преподаватели
        $teachers = [
            ['name' => 'Иванов Петр Сергеевич', 'email' => 'teacher1@example.com'],
            ['name' => 'Смирнова Анна Владимировна', 'email' => 'teacher2@example.com'],
            ['name' => 'Петров Дмитрий Иванович', 'email' => 'teacher3@example.com'],
            ['name' => 'Козлова Елена Александровна', 'email' => 'teacher4@example.com'],
        ];

        foreach ($teachers as $teacher) {
            DB::table('users')->insert([
                'name' => $teacher['name'],
                'email' => $teacher['email'],
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Родители (50 человек)
        $parents = [];
        for ($i = 0; $i < 50; $i++) {
            $parents[] = [
                'name' => $faker->lastName . ' ' . $faker->firstName . ' ' . $faker->middleName,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('users')->insert($parents);
    }
}