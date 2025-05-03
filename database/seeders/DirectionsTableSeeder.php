<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DirectionsTableSeeder extends Seeder
{
    public function run()
    {
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
            [
                'name' => 'Робототехника',
                'description' => 'Основы программирования роботов и автоматизации.',
                'photo' => '["3d_basic_1.jpg", "3d_basic_2.jpg"]', // Используем существующие фото
                'icon' => 'img/icon_stud.png'
            ],
            [
                'name' => 'Мобильная разработка',
                'description' => 'Создание приложений для смартфонов и планшетов.',
                'photo' => '["web_1.jpg", "web_2.jpg"]',
                'icon' => 'img/icon_stud.png'
            ]
        ]);
    }
}