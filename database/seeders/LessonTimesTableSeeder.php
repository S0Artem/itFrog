<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonTimesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('lesson_times')->insert([
            ['id' => 1, 'lesson_start' => '09:00', 'lesson_end' => '11:00', 'break_start' => '10:00', 'break_end' => '10:15'],
            ['id' => 2, 'lesson_start' => '11:15', 'lesson_end' => '13:15', 'break_start' => '12:15', 'break_end' => '12:30'],
            ['id' => 3, 'lesson_start' => '13:30', 'lesson_end' => '15:30', 'break_start' => '14:30', 'break_end' => '14:45'],
            ['id' => 4, 'lesson_start' => '15:45', 'lesson_end' => '17:45', 'break_start' => '16:45', 'break_end' => '17:00'],
            ['id' => 5, 'lesson_start' => '18:00', 'lesson_end' => '20:00', 'break_start' => '19:00', 'break_end' => '19:15']
        ]);
    }
}