<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            BranchesTableSeeder::class,
            LessonTimesTableSeeder::class, // Должен быть перед GroupsTableSeeder
            EmployeesTableSeeder::class,
            ApplicationsTableSeeder::class,
            DirectionsTableSeeder::class,
            ModulsTableSeeder::class,
            GroupsTableSeeder::class, // Теперь все зависимости существуют
            GroupTeachersTableSeeder::class,
            LessonsTableSeeder::class,
            StudentsTableSeeder::class,
            ModulStudentsTableSeeder::class,
            LessonAssessmentsTableSeeder::class,
            StudentProjectsTableSeeder::class
        ]);
    }
}