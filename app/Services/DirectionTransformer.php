<?php

namespace App\Services;

use App\Models\Direction;
use Illuminate\Support\Collection;


/**
 * Трансформер для преобразования данных напровления
 * 
 * Преобразует модель Direction в массив с вычисляемыми полями
 * 
 * @package App\Services\Transformers
 */
class DirectionTransformer
{

    /**
     * Преобразует одно напровление
     * 
     * @param Direction $direction 
     * @return array
     *  id: int,
     *  icon: string|null,
     *  modules_count: int
     *  moduls_to_display: array<int, string>
     */
    public function transform(Direction $direction): array
    {

        $moduls = $direction->moduls;
        return[
            'id' => $direction->id,
            'icon' => $direction->icon,
            'name' => $direction->name,
            'modules_count' => $moduls->count(),
            'total_lessons' => $moduls->sum('lesson'),
            'moduls_to_display' => $moduls->count() >= 3 
                ? $moduls->random(3)->pluck('name')->toArray()
                : $moduls->pluck('name')->toArray(),
            
            
        ];
    }

    /**
     * Трансформирует коллекцию направлений в массив
     *
     * Применяет метод transform() к каждому элементу коллекции
     *
     * @param Collection $directions Коллекция направлений
     * @return array<int, array{
     *     id: int,
     *     name: string,
     *     icon: string|null,
     *     modules_count: int,
     *     total_lessons: int,
     *     moduls_to_display: array<int, string>
     * }> Массив трансформированных направлений
     */
    public function transformCollection(Collection $directions): array
    {
        return $directions->map(function($direction){
            return $this->transform($direction);
        })->toArray();
    }
}