<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class LessonAssessmentsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $assessments = [];
        $allStudents = DB::table('students')->pluck('id')->toArray();

        foreach ($allStudents as $studentId) {
            $studentGroups = DB::table('modul_students')
                ->where('student_id', $studentId)
                ->pluck('group_id');

            foreach ($studentGroups as $groupId) {
                $moduleId = DB::table('groups')->where('id', $groupId)->value('modul_id');
                $moduleLessons = DB::table('lessons')
                    ->where('modul_id', $moduleId)
                    ->pluck('id');

                foreach ($moduleLessons as $lessonId) {
                    $assessments[] = [
                        'grade' => $faker->numberBetween(60, 100),
                        'description' => $faker->randomElement([
                            'Хорошая работа', 
                            'Отличный результат',
                            'Нужно больше практики',
                            'Превосходно!',
                            'Можно лучше'
                        ]),
                        'lesson_id' => $lessonId,
                        'student_id' => $studentId,
                        'employee_id' => DB::table('groups')
                            ->join('group_teachers', 'groups.id', '=', 'group_teachers.group_id')
                            ->where('groups.id', $groupId)
                            ->value('group_teachers.employee_id'),
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
        }

        foreach (array_chunk($assessments, 500) as $chunk) {
            DB::table('lesson_assessments')->insert($chunk);
        }
    }
}