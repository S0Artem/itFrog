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
        
        // Статусы заявок
        $statuses = ['Новая', 'В работе', 'Отказ', 'Обработана'];
        
        // Генерируем 50 случайных заявок
        for ($i = 0; $i < 50; $i++) {
            $applications[] = [
                'number' => '+7(9' . $faker->numerify('##) ###-##-##'),
                'name' => $faker->firstName . ' ' . $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'age' => $faker->numberBetween(6, 18),
                'branche_id' => $faker->numberBetween(1, 4),
                'status' => $statuses[array_rand($statuses)],
                'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
                'updated_at' => now()
            ];
        }

        DB::table('aplications')->insert($applications);
    }
}