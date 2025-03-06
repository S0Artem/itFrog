<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'Alice', 'email' => 'alice@example.com', 'login' => 'alice123', 'password' => Hash::make('password'), 'role' => 'admin'],
            ['name' => 'Bob', 'email' => 'bob@example.com', 'login' => 'bob321', 'password' => Hash::make('password'), 'role' => 'user'],
            ['name' => 'Charlie', 'email' => 'charlie@example.com', 'login' => 'charlie456', 'password' => Hash::make('password'), 'role' => 'user']
        ]);

        DB::table('branches')->insert([
            ['sity' => 'New York', 'adres' => '123 Main St'],
            ['sity' => 'Los Angeles', 'adres' => '456 Sunset Blvd'],
            ['sity' => 'Chicago', 'adres' => '789 Lakeshore Dr']
        ]);

        DB::table('employees')->insert([
            ['id' => '1', 'branche_id' => '2'],
        ]);

        DB::table('aplications')->insert([
            ['number' => 'A123', 'name' => 'John Doe', 'age' => 18, 'branche_id' => 1, 'employee_id' => '1'],
            ['number' => 'B456', 'name' => 'Jane Doe', 'age' => 20, 'branche_id' => 2, 'employee_id' => '1'],
            ['number' => 'C789', 'name' => 'Mike Smith', 'age' => 22, 'branche_id' => 3, 'employee_id' => '1']
        ]);
        
        DB::table('students')->insert([
            ['age' => 18, 'branche_id' => 1, 'user_id' => 2, 'aplication_id' => 1],
            ['age' => 20, 'branche_id' => 2, 'user_id' => 3, 'aplication_id' => 2],
            ['age' => 22, 'branche_id' => 3, 'user_id' => 1, 'aplication_id' => 3]
        ]);

        DB::table('products')->insert([
            ['name' => 'Product A', 'volume' => 10],
            ['name' => 'Product B', 'volume' => 20],
            ['name' => 'Product C', 'volume' => 15]
        ]);




        DB::table('directions')->insert([
            ['name' => '3D моделирование', 'description' => 'Тут большой текст чтобы на странице этого напровления ьыло много инфы про напровление', 'photo' => 'Тут много фото об этом напровление в виде массива будет и будут выводиться на странице', 'icon' => 'img/icon_stud.png'],
            ['name' => '3D моделирование старших групп', 'description' => 'Тут большой текст чтобы на странице этого напровления ьыло много инфы про напровление', 'photo' => 'Тут много фото об этом напровление в виде массива будет и будут выводиться на странице', 'icon' => 'img/icon_stud.png'],
            ['name' => 'Создание сайтов', 'description' => 'Тут большой текст чтобы на странице этого напровления ьыло много инфы про напровление', 'photo' => 'Тут много фото об этом напровление в виде массива будет и будут выводиться на странице', 'icon' => 'img/icon_stud.png'],
            ['name' => 'Создание игр', 'description' => 'Тут большой текст чтобы на странице этого напровления ьыло много инфы про напровление', 'photo' => 'Тут много фото об этом напровление в виде массива будет и будут выводиться на странице', 'icon' => 'img/icon_stud.png'],
            ['name' => 'Создание игр старших групп', 'description' => 'Тут большой текст чтобы на странице этого напровления ьыло много инфы про напровление', 'photo' => 'Тут много фото об этом напровление в виде массива будет и будут выводиться на странице', 'icon' => 'img/icon_stud.png'],
        ]);
        DB::table('moduls')->insert([
            ['name' => 'Blender создание моделей1', 'description' => 'Introduction', 'lesson' => 8, 'direction_id' => '1'],
            ['name' => '3D-max создание дизайна2', 'description' => 'Advanced', 'lesson' => 16, 'direction_id' => '1'],
            ['name' => 'Blender создание анимаций3', 'description' => 'Expert', 'lesson' => 3,  'direction_id' => '1'],
            ['name' => 'Blender создание моделей4', 'description' => 'Introduction', 'lesson' => 7, 'direction_id' => '2'],
            ['name' => '3D-max создание дизайна5', 'description' => 'Advanced', 'lesson' => 26, 'direction_id' => '2'],
            ['name' => 'Blender создание анимаций6', 'description' => 'Expert', 'lesson' => 3,  'direction_id' => '2'],
            ['name' => 'Blender создание моделей7', 'description' => 'Introduction', 'lesson' => 5, 'direction_id' => '3'],
            ['name' => '3D-max создание дизайна8', 'description' => 'Advanced', 'lesson' => 8, 'direction_id' => '3'],
            ['name' => 'Blender создание анимаций9', 'description' => 'Expert', 'lesson' => 10,  'direction_id' => '3'],
            ['name' => 'Blender создание моделей10', 'description' => 'Introduction', 'lesson' => 5, 'direction_id' => '4'],
            ['name' => '3D-max создание дизайна11', 'description' => 'Advanced', 'lesson' => 17, 'direction_id' => '4'],
            ['name' => 'Blender создание анимаций12', 'description' => 'Expert', 'lesson' => 10,  'direction_id' => '4'],
            ['name' => 'Blender создание моделей13', 'description' => 'Introduction', 'lesson' => 5, 'direction_id' => '5'],
            ['name' => '3D-max создание дизайна14', 'description' => 'Advanced', 'lesson' => 6, 'direction_id' => '5'],
            ['name' => 'Blender создание анимаций15', 'description' => 'Expert', 'lesson' => 10,  'direction_id' => '5'],
            ['name' => 'Blender создание анимаций16', 'description' => 'Expert', 'lesson' => 26,  'direction_id' => '5'],
            ['name' => 'Blender создание анимаций17', 'description' => 'Expert', 'lesson' => 14,  'direction_id' => '5']
        ]);




        DB::table('student_progects')->insert([
            ['progect' => 'Website', 'student_id' => 1, 'modul_id' => 1],
            ['progect' => 'App', 'student_id' => 2, 'modul_id' => 2],
            ['progect' => 'Game', 'student_id' => 3, 'modul_id' => 3]
        ]);

        DB::table('lessons')->insert([
            ['name' => 'Lesson 1', 'number_lesson' => 1, 'modul_id' => 1],
            ['name' => 'Lesson 2', 'number_lesson' => 2, 'modul_id' => 2],
            ['name' => 'Lesson 3', 'number_lesson' => 3, 'modul_id' => 3]
        ]);

        DB::table('lesson_assessments')->insert([
            ['grade' => 85, 'description' => 'Good', 'lesson_id' => 1, 'student_id' => 1, 'employee_id' => 1],
            ['grade' => 90, 'description' => 'Very Good', 'lesson_id' => 2, 'student_id' => 2, 'employee_id' => 1],
            ['grade' => 95, 'description' => 'Excellent', 'lesson_id' => 3, 'student_id' => 3, 'employee_id' => 1]
        ]);

        DB::table('groups')->insert([
            ['branche_id' => 1],
            ['branche_id' => 2],
            ['branche_id' => 3]
        ]);

        DB::table('group_teachers')->insert([
            ['employee_id' => 1, 'group_id' => 1],
            ['employee_id' => 1, 'group_id' => 2],
            ['employee_id' => 1, 'group_id' => 3]
        ]);

        DB::table('transactions')->insert([
            ['product_id' => 1, 'branche_id' => 1, 'student_id' => 1],
            ['product_id' => 2, 'branche_id' => 2, 'student_id' => 2],
            ['product_id' => 3, 'branche_id' => 3, 'student_id' => 3]
        ]);
    }
}