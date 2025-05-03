<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonsTableSeeder extends Seeder
{
    public function run()
    {
        $lessons = [];
        $moduls = DB::table('moduls')->get();

        foreach ($moduls as $modul) {
            for ($i = 1; $i <= $modul->lesson; $i++) {
                $lessons[] = [
                    'name' => 'Урок ' . $i . ' - ' . $modul->name,
                    'number_lesson' => $i,
                    'modul_id' => $modul->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        DB::table('lessons')->insert($lessons);
    }
}