<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ModulStudentsTableSeeder extends Seeder
{
    const MIN_STUDENTS_PER_GROUP = 4;
    const MAX_STUDENTS_PER_GROUP = 10;

    public function run()
    {
        $faker = Faker::create('ru_RU');
        
        // Получаем все группы с информацией о филиале
        $groups = DB::table('groups')
            ->join('branches', 'groups.branch_id', '=', 'branches.id')
            ->select('groups.id', 'groups.branch_id', 'groups.modul_id', 'branches.sity')
            ->get();

        // Получаем всех студентов сгруппированных по филиалам
        $studentsByBranch = DB::table('students')
            ->select('id', 'branche_id')
            ->get()
            ->groupBy('branche_id');

        foreach ($groups as $group) {
            // Проверяем есть ли студенты в этом филиале
            if (!isset($studentsByBranch[$group->branch_id])) {
                continue;
            }

            $availableStudents = $studentsByBranch[$group->branch_id];
            $studentsCount = min(
                $faker->numberBetween(self::MIN_STUDENTS_PER_GROUP, self::MAX_STUDENTS_PER_GROUP),
                count($availableStudents)
            );

            // Выбираем случайных студентов для группы
            $selectedStudents = $availableStudents->random($studentsCount);

            $assignments = [];
            foreach ($selectedStudents as $student) {
                $assignments[] = [
                    'group_id' => $group->id,
                    'student_id' => $student->id,
                    'modul_id' => $group->modul_id,
                    'last_payment_date' => $faker->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            // Вставляем записи для этой группы
            DB::table('modul_students')->insert($assignments);

            // Удаляем выбранных студентов из доступных
            $studentsByBranch[$group->branch_id] = $studentsByBranch[$group->branch_id]
                ->whereNotIn('id', $selectedStudents->pluck('id'));
        }
    }
}