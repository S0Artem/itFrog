<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulsTableSeeder extends Seeder
{
    public function run()
    {
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
            // Новые модули для робототехники
            [
                'name' => 'LEGO Mindstorms',
                'description' => 'Основы сборки и программирования роботов LEGO.',
                'lesson' => 10,
                'direction_id' => 6, // ID нового направления
                'tags' => json_encode(["#Робототехника", "#LEGO", "#ДляДетей"]),
                'min_age' => 8,
                'max_age' => 14
            ],
            [
                'name' => 'Arduino для начинающих',
                'description' => 'Основы работы с микроконтроллерами Arduino.',
                'lesson' => 12,
                'direction_id' => 6,
                'tags' => json_encode(["#Arduino", "#Электроника", "#ДляПодростков"]),
                'min_age' => 12,
                'max_age' => 18
            ],
            // Новые модули для мобильной разработки
            [
                'name' => 'Разработка под Android',
                'description' => 'Создание простых приложений для Android.',
                'lesson' => 14,
                'direction_id' => 7,
                'tags' => json_encode(["#Android", "#Kotlin", "#ДляСтаршеклассников"]),
                'min_age' => 14,
                'max_age' => 20
            ],
            [
                'name' => 'Продвинутая разработка под Android',
                'description' => 'Создание cложные приложений для Android.',
                'lesson' => 14,
                'direction_id' => 7,
                'tags' => json_encode(["#Android", "#Kotlin", "#ДляСтудентов"]),
                'min_age' => 18,
                'max_age' => 24
            ]
        ]);
    }
}