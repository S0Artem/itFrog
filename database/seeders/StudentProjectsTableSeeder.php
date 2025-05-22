<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StudentProjectsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('ru_RU');
        $projects = [];
        
        // Доступные файлы проектов
        $availableProjects = [
            'img/studebt_progect_1.png',
            'img/studebt_progect_2.png',
            'img/studebt_progect_3.png'
        ];
        
        // Получаем всех студентов с их модулями
        $students = DB::table('modul_students')
            ->select('student_id', 'modul_id')
            ->distinct()
            ->get();

        foreach ($students as $student) {
            // Выбираем случайный проект из доступных
            $randomProject = $availableProjects[array_rand($availableProjects)];
            
            $projects[] = [
                'progect' => $this->generateProjectDescription($randomProject, $faker),
                'student_id' => $student->student_id,
                'modul_id' => $student->modul_id,
                'video' => $randomProject,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Разбиваем на части для больших объемов данных
        foreach (array_chunk($projects, 500) as $chunk) {
            DB::table('student_progects')->insert($chunk);
        }
    }
    
    /**
     * Генерирует описание проекта на основе типа файла
     */
    protected function generateProjectDescription(string $projectFile, $faker): string
    {
        if (str_contains($projectFile, '1.png')) {
            return "3D-модель чайника с реалистичными материалами и освещением. " . $faker->realText(100);
        } elseif (str_contains($projectFile, '2.gif')) {
            return "Анимация 3D-очков с плавным движением и эффектами. " . $faker->realText(100);
        } else {
            return "Веб-сайт портфолио с адаптивным дизайном. " . $faker->realText(100);
        }
    }
}