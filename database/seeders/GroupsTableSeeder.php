<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsTableSeeder extends Seeder
{
    public function run()
    {
        $groups = [];
        
        // Доступные временные слоты (1-5)
        $timeSlots = range(1, 5);
        
        // Доступные дни недели (1-7)
        $weekDays = range(1, 7);
        
        // Для каждого филиала (1-4)
        foreach (range(1, 4) as $branchId) {
            // Для каждого дня недели
            foreach ($weekDays as $day) {
                // Выбираем 2-3 случайных временных слота для этого дня
                $selectedTimeSlots = collect($timeSlots)
                    ->shuffle()
                    ->take(rand(2, 3))
                    ->toArray();
                
                // Для каждого выбранного временного слота
                foreach ($selectedTimeSlots as $timeId) {
                    // Находим доступные модули, которые еще не используются в этом филиале
                    $availableModule = DB::table('moduls')
                        ->whereNotIn('id', function($query) use ($branchId) {
                            $query->select('modul_id')
                                ->from('groups')
                                ->where('branch_id', $branchId);
                        })
                        ->inRandomOrder()
                        ->first();
                    
                    if ($availableModule) {
                        $groups[] = [
                            'branch_id' => $branchId,
                            'modul_id' => $availableModule->id,
                            'time_id' => $timeId,
                            'day' => $day,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                }
            }
        }

        // Вставляем группы
        DB::table('groups')->insert($groups);
    }
}