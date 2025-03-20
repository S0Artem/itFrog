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
            ['name' => 'Артем', 'email' => 'so.artem998@gmail.com', 'login' => 'so.artem', 'password' => Hash::make('25071983EEe'), 'role' => 'admin'],
            ['name' => 'Тимофей', 'email' => 'tim@gmail.com', 'login' => 'Timofei', 'password' => Hash::make('password'), 'role' => 'user'],
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
            ['number' => '+7(900)-329-89-88', 'name' => 'Тимур', 'email' => 'so.artem998@gmail.com'],
            ['number' => '+7(900)-329-89-88', 'name' => 'Алексей', 'email' => 'tim@gmail.com'],
            ['number' => '+7(900)-329-89-88', 'name' => 'Мария', 'email' => 'tim@gmail.com']
        ]);

        DB::table('students')->insert([
            ['age' => 18, 'branche_id' => 1, 'user_id' => 2, 'aplication_id' => 1, 'name' => 'Софронов Артем'],
            ['age' => 20, 'branche_id' => 2, 'user_id' => 2, 'aplication_id' => 2, 'name' => 'Гемаев Тимур'],
            ['age' => 22, 'branche_id' => 3, 'user_id' => 1, 'aplication_id' => 3, 'name' => 'Юсупова Галина']
        ]);

        DB::table('products')->insert([
            ['name' => 'Product A', 'volume' => 10],
            ['name' => 'Product B', 'volume' => 20],
            ['name' => 'Product C', 'volume' => 15]
        ]);




        
        DB::table('directions')->insert([
            [
                'name' => '3D моделирование',
                'description' => 'Курсы по основам 3D-моделирования для начинающих.',
                'photo' => '["3d_basic_1.jpg", "3d_basic_2.jpg"]',
                'icon' => 'img/icon_stud.png'
            ],
            [
                'name' => '3D моделирование старших групп',
                'description' => 'Продвинутые курсы по 3D-моделированию для опытных пользователей.',
                'photo' => '["3d_advanced_1.jpg", "3d_advanced_2.jpg"]',
                'icon' => 'img/icon_stud.png'
            ],
            [
                'name' => 'Создание сайтов',
                'description' => 'Курсы по веб-разработке и созданию современных сайтов.',
                'photo' => '["web_1.jpg", "web_2.jpg"]',
                'icon' => 'img/icon_stud.png'
            ],
            [
                'name' => 'Создание игр',
                'description' => 'Курсы по разработке игр для начинающих.',
                'photo' => '["game_dev_1.jpg", "game_dev_2.jpg"]',
                'icon' => 'img/icon_stud.png'
            ],
            [
                'name' => 'Создание игр старших групп',
                'description' => 'Продвинутые курсы по разработке игр для опытных разработчиков.',
                'photo' => '["game_dev_advanced_1.jpg", "game_dev_advanced_2.jpg"]',
                'icon' => 'img/icon_stud.png'
            ],
        ]);
        
        DB::table('moduls')->insert([
            // Модули для "3D моделирование"
            [
                'name' => 'Основы Blender',
                'description' => 'Изучите базовые инструменты Blender для создания 3D-моделей.',
                'lesson' => 8,
                'direction_id' => 1,
                'tags' => json_encode(["#Blender", "#3DМоделирование", "#Новичкам"])
            ],
            [
                'name' => 'Создание персонажей',
                'description' => 'Учимся создавать 3D-персонажей с нуля.',
                'lesson' => 12,
                'direction_id' => 1,
                'tags' => json_encode(["#Blender", "#Персонажи", "#3DАнимация"])
            ],
            [
                'name' => 'Текстурирование в Blender',
                'description' => 'Освойте наложение текстур на 3D-модели.',
                'lesson' => 6,
                'direction_id' => 1,
                'tags' => json_encode(["#Blender", "#Текстурирование", "#3DГрафика"])
            ],
        
            // Модули для "3D моделирование старших групп"
            [
                'name' => 'Продвинутое моделирование в Blender',
                'description' => 'Техники для создания сложных 3D-моделей.',
                'lesson' => 10,
                'direction_id' => 2,
                'tags' => json_encode(["#Blender", "#ПродвинутыйУровень", "#3DМоделирование"])
            ],
            [
                'name' => 'Анимация в Blender',
                'description' => 'Создание анимаций для 3D-моделей.',
                'lesson' => 14,
                'direction_id' => 2,
                'tags' => json_encode(["#Blender", "#3DАнимация", "#VFX"])
            ],
            [
                'name' => 'Рендеринг в Cycles',
                'description' => 'Освойте фотореалистичный рендеринг в Blender.',
                'lesson' => 8,
                'direction_id' => 2,
                'tags' => json_encode(["#Blender", "#Рендеринг", "#Cycles"])
            ],
        
            // Модули для "Создание сайтов"
            [
                'name' => 'HTML и CSS для начинающих',
                'description' => 'Основы создания веб-страниц.',
                'lesson' => 10,
                'direction_id' => 3,
                'tags' => json_encode(["#HTML", "#CSS", "#ВебРазработка"])
            ],
            [
                'name' => 'JavaScript: основы',
                'description' => 'Изучите базовый синтаксис JavaScript.',
                'lesson' => 12,
                'direction_id' => 3,
                'tags' => json_encode(["#JavaScript", "#ВебРазработка", "#Программирование"])
            ],
            [
                'name' => 'React: современный фронтенд',
                'description' => 'Создание динамических веб-приложений с React.',
                'lesson' => 16,
                'direction_id' => 3,
                'tags' => json_encode(["#React", "#JavaScript", "#Фронтенд"])
            ],
        
            // Модули для "Создание игр"
            [
                'name' => 'Unity: основы',
                'description' => 'Изучите базовые инструменты Unity для создания игр.',
                'lesson' => 10,
                'direction_id' => 4,
                'tags' => json_encode(["#Unity", "#РазработкаИгр", "#Новичкам"])
            ],
            [
                'name' => 'Создание 2D-игр',
                'description' => 'Разработка 2D-игр в Unity.',
                'lesson' => 12,
                'direction_id' => 4,
                'tags' => json_encode(["#Unity", "#2DИгры", "#Геймдев"])
            ],
            [
                'name' => 'Введение в C#',
                'description' => 'Основы программирования на C# для Unity.',
                'lesson' => 8,
                'direction_id' => 4,
                'tags' => json_encode(["#CSharp", "#Программирование", "#Unity"])
            ],
        
            // Модули для "Создание игр старших групп"
            [
                'name' => 'Продвинутый Unity',
                'description' => 'Создание сложных игровых механик в Unity.',
                'lesson' => 14,
                'direction_id' => 5,
                'tags' => json_encode(["#Unity", "#ПродвинутыйУровень", "#Геймдев"])
            ],
            [
                'name' => 'Оптимизация игр',
                'description' => 'Техники оптимизации для игр на Unity.',
                'lesson' => 10,
                'direction_id' => 5,
                'tags' => json_encode(["#Unity", "#Оптимизация", "#Геймдев"])
            ],
            [
                'name' => 'Создание 3D-игр',
                'description' => 'Разработка 3D-игр в Unity.',
                'lesson' => 16,
                'direction_id' => 5,
                'tags' => json_encode(["#Unity", "#3DИгры", "#Геймдев"])
            ],
        ]);


        DB::table('student_progects')->insert([
            [
                'progect' => 'Я изучил основы 3D-моделирования в Blender. За 22 урока я создал модельку чайника, которая висит над прямоугольником. Я настроил реалистичные тени и зеркальность поверхности, чтобы добиться эффекта отражения.',
                'student_id' => 1,
                'modul_id' => 1,
                'video' => 'img/studebt_progect_1.png'
            ],
            [
                'progect' => 'Я освоил анимацию в Blender. За 22 урока я создал анимацию 3D-очков. Мой проект включает плавное движение очков, отражение света на линзах и реалистичные тени.',
                'student_id' => 2,
                'modul_id' => 2,
                'video' => 'img/studebt_progect_2.gif'
            ],
            [
                'progect' => 'Я изучил веб-разработку и создал свой первый сайт на Tilda. За 22 урока я разработал адаптивный сайт-портфолио с анимациями и интерактивными элементами. Мой проект — это современный сайт с удобным интерфейсом.',
                'student_id' => 3,
                'modul_id' => 3,
                'video' => 'img/studebt_progect_3.png'
            ],
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