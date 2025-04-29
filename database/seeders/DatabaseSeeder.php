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
            ['name' => 'Артем', 'email' => 'so.artem998@gmail.com', 'password' => Hash::make('25071983EEe'), 'role' => 'admin'],
            ['name' => 'Тимофей', 'email' => 'tim@gmail.com', 'password' => Hash::make('password'), 'role' => 'user'],
            ['name' => 'Херогов Георгий', 'email' => 'so.artem99@gmail.com', 'password' => Hash::make('25071983EEe'), 'role' => 'teacher'],
            ['name' => 'Пилеев Аравис', 'email' => 'so.artem9@gmail.com', 'password' => Hash::make('25071983EEe'), 'role' => 'teacher'],
            ['name' => 'Пивнов Алексей', 'email' => 'so.artem@gmail.com', 'password' => Hash::make('25071983EEe'), 'role' => 'teacher'],
        ]);

        

        DB::table('branches')->insert([
            ['sity' => 'New York', 'adres' => '123 Main St'],
            ['sity' => 'Los Angeles', 'adres' => '456 Sunset Blvd'],
            ['sity' => 'Chicago', 'adres' => '789 Lakeshore Dr']
        ]);

        DB::table('employees')->insert([
            ['id' => 3, 'branche_id' => 1],
            ['id' => 4, 'branche_id' => 3],
            ['id' => 5, 'branche_id' => 2],
        ]);

        DB::table('lesson_times')->insert([
            ['id' => '1', 'lesson_start' => '09:00', 'lesson_end' => '11:00', 'break_start' => '10:00', 'break_end' => '10:15'],
            ['id' => '2', 'lesson_start' => '11:15', 'lesson_end' => '13:15', 'break_start' => '12:15', 'break_end' => '12:30'],
            ['id' => '3', 'lesson_start' => '13:30', 'lesson_end' => '15:30', 'break_start' => '14:30', 'break_end' => '14:45'],
            ['id' => '4', 'lesson_start' => '15:45', 'lesson_end' => '17:45', 'break_start' => '16:45', 'break_end' => '17:00'],
            ['id' => '5', 'lesson_start' => '18:00', 'lesson_end' => '20:00', 'break_start' => '19:00', 'break_end' => '19:15'],
        ]);

        DB::table('aplications')->insert([
            ['number' => '+7(900)-329-89-88', 'name' => 'Тимур', 'email' => 'so.artem998@gmail.com'],
            ['number' => '+7(900)-329-89-88', 'name' => 'Алексей', 'email' => 'tim@gmail.com'],
            ['number' => '+7(900)-329-89-88', 'name' => 'Мария', 'email' => 'tim@gmail.com']
        ]);

        DB::table('students')->insert([
            ['birthdate' => '2010-10-04', 'branche_id' => 1, 'user_id' => 2, 'name' => 'Софронов Артем'],
            ['birthdate' => '2015-08-13', 'branche_id' => 2, 'user_id' => 2, 'name' => 'Гемаев Тимур'],
            ['birthdate' => '2011-11-01', 'branche_id' => 3, 'user_id' => 1, 'name' => 'Юсупова Галина']
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
            // Модули для "3D моделирование" (6-12 лет)
            [
                'name' => 'Основы Blender',
                'description' => 'Изучите базовые инструменты Blender для создания простых 3D-моделей.',
                'lesson' => 8,
                'direction_id' => 1,
                'tags' => json_encode(["#Blender", "#3DМоделирование", "#Дети"]),
                'min_age' => 6,
                'max_age' => 12
            ],
            [
                'name' => 'Создание персонажей',
                'description' => 'Учимся создавать простых 3D-персонажей.',
                'lesson' => 12,
                'direction_id' => 1,
                'tags' => json_encode(["#Blender", "#Персонажи", "#ДетскоеТворчество"]),
                'min_age' => 8,
                'max_age' => 14
            ],
            [
                'name' => 'Текстурирование в Blender',
                'description' => 'Основы наложения текстур на 3D-модели.',
                'lesson' => 6,
                'direction_id' => 1,
                'tags' => json_encode(["#Blender", "#Текстурирование", "#ДляНачинающих"]),
                'min_age' => 10,
                'max_age' => 16
            ],
            
            // Модули для "3D моделирование старших групп" (12-20 лет)
            [
                'name' => 'Продвинутое моделирование в Blender',
                'description' => 'Техники для создания сложных 3D-моделей.',
                'lesson' => 10,
                'direction_id' => 2,
                'tags' => json_encode(["#Blender", "#ПродвинутыйУровень", "#Профессионально"]),
                'min_age' => 12,
                'max_age' => 20
            ],
            [
                'name' => 'Анимация в Blender',
                'description' => 'Создание анимаций для 3D-моделей.',
                'lesson' => 14,
                'direction_id' => 2,
                'tags' => json_encode(["#Blender", "#3DАнимация", "#ДляПодростков"]),
                'min_age' => 14,
                'max_age' => 20
            ],
            [
                'name' => 'Рендеринг в Cycles',
                'description' => 'Освойте фотореалистичный рендеринг в Blender.',
                'lesson' => 8,
                'direction_id' => 2,
                'tags' => json_encode(["#Blender", "#Рендеринг", "#ДляСтаршеклассников"]),
                'min_age' => 16,
                'max_age' => 20
            ],
            
            // Модули для "Создание сайтов" (8-18 лет)
            [
                'name' => 'HTML и CSS для детей',
                'description' => 'Основы создания веб-страниц для начинающих.',
                'lesson' => 10,
                'direction_id' => 3,
                'tags' => json_encode(["#HTML", "#CSS", "#ДляШкольников"]),
                'min_age' => 8,
                'max_age' => 14
            ],
            [
                'name' => 'JavaScript: основы',
                'description' => 'Изучите базовый синтаксис JavaScript.',
                'lesson' => 12,
                'direction_id' => 3,
                'tags' => json_encode(["#JavaScript", "#ВебРазработка", "#ДляПодростков"]),
                'min_age' => 12,
                'max_age' => 18
            ],
            [
                'name' => 'React: современный фронтенд',
                'description' => 'Создание динамических веб-приложений с React.',
                'lesson' => 16,
                'direction_id' => 3,
                'tags' => json_encode(["#React", "#JavaScript", "#ДляСтаршеклассников"]),
                'min_age' => 14,
                'max_age' => 20
            ],
            
            // Модули для "Создание игр" (6-16 лет)
            [
                'name' => 'Unity: первые шаги',
                'description' => 'Основы создания простых игр для детей.',
                'lesson' => 10,
                'direction_id' => 4,
                'tags' => json_encode(["#Unity", "#РазработкаИгр", "#ДляДетей"]),
                'min_age' => 6,
                'max_age' => 12
            ],
            [
                'name' => 'Создание 2D-игр',
                'description' => 'Разработка 2D-игр в Unity для начинающих.',
                'lesson' => 12,
                'direction_id' => 4,
                'tags' => json_encode(["#Unity", "#2DИгры", "#ДляШкольников"]),
                'min_age' => 10,
                'max_age' => 16
            ],
            [
                'name' => 'Введение в C#',
                'description' => 'Основы программирования на C# для Unity.',
                'lesson' => 8,
                'direction_id' => 4,
                'tags' => json_encode(["#CSharp", "#Программирование", "#ДляПодростков"]),
                'min_age' => 12,
                'max_age' => 18
            ],
            
            // Модули для "Создание игр старших групп" (14-20 лет)
            [
                'name' => 'Продвинутый Unity',
                'description' => 'Создание сложных игровых механик в Unity.',
                'lesson' => 14,
                'direction_id' => 5,
                'tags' => json_encode(["#Unity", "#ПродвинутыйУровень", "#ДляСтаршеклассников"]),
                'min_age' => 14,
                'max_age' => 20
            ],
            [
                'name' => 'Оптимизация игр',
                'description' => 'Техники оптимизации для игр на Unity.',
                'lesson' => 10,
                'direction_id' => 5,
                'tags' => json_encode(["#Unity", "#Оптимизация", "#Профессионально"]),
                'min_age' => 16,
                'max_age' => 20
            ],
            [
                'name' => 'Создание 3D-игр',
                'description' => 'Разработка 3D-игр в Unity.',
                'lesson' => 16,
                'direction_id' => 5,
                'tags' => json_encode(["#Unity", "#3DИгры", "#ДляСтудентов"]),
                'min_age' => 16,
                'max_age' => 20
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
            ['grade' => 85, 'description' => 'Good', 'lesson_id' => 1, 'student_id' => 1, 'employee_id' => 3],
            ['grade' => 90, 'description' => 'Very Good', 'lesson_id' => 2, 'student_id' => 2, 'employee_id' => 5],
            ['grade' => 95, 'description' => 'Excellent', 'lesson_id' => 3, 'student_id' => 3, 'employee_id' => 4]
        ]);

        DB::table('groups')->insert([
            // Филиал 1
    [
        'branch_id' => 1,
        'modul_id' => 1,
        'time_id' => 1,
        'day' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'branch_id' => 1,
        'modul_id' => 2,
        'time_id' => 2,
        'day' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'branch_id' => 1,
        'modul_id' => 7,
        'time_id' => 3,
        'day' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'branch_id' => 1,
        'modul_id' => 10,
        'time_id' => 4,
        'day' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'branch_id' => 1,
        'modul_id' => 13,
        'time_id' => 5,
        'day' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ],

    // Филиал 2
    [
        'branch_id' => 2,
        'modul_id' => 3,
        'time_id' => 1,
        'day' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'branch_id' => 2,
        'modul_id' => 5,
        'time_id' => 2,
        'day' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'branch_id' => 2,
        'modul_id' => 8,
        'time_id' => 3,
        'day' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'branch_id' => 2,
        'modul_id' => 12,
        'time_id' => 4,
        'day' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'branch_id' => 2,
        'modul_id' => 15,
        'time_id' => 5,
        'day' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ],

    // Филиал 3
    [
        'branch_id' => 3,
        'modul_id' => 1,
        'time_id' => 1,
        'day' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'branch_id' => 3,
        'modul_id' => 4,
        'time_id' => 3,
        'day' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'branch_id' => 3,
        'modul_id' => 6,
        'time_id' => 4,
        'day' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'branch_id' => 3,
        'modul_id' => 9,
        'time_id' => 5,
        'day' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'branch_id' => 3,
        'modul_id' => 14,
        'time_id' => 1,
        'day' => 3,
        'created_at' => now(),
        'updated_at' => now()
    ]
        ]);

        DB::table('group_teachers')->insert([
            ['employee_id' => 4, 'group_id' => 1],
            ['employee_id' => 3, 'group_id' => 2],
            ['employee_id' => 5, 'group_id' => 3]
        ]);

        DB::table('transactions')->insert([
            ['product_id' => 1, 'branche_id' => 1, 'student_id' => 1],
            ['product_id' => 2, 'branche_id' => 2, 'student_id' => 2],
            ['product_id' => 3, 'branche_id' => 3, 'student_id' => 3]
        ]);
    }
}