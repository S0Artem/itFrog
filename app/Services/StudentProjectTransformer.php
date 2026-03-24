<?php

namespace App\Services;

use App\Models\StudentProject;
use \Carbon\Carbon;
use Illuminate\Support\Collection;


/**
 * Трансформер для преобразования данных напровления
 * 
 * Преобразует модель StudentProject в массив с вычисляемыми полями
 * 
 * @package App\Services\Transformers
 */
class StudentProjectTransformer
{

    /**
     * Преобразует одно напровление
     * 
     * @param StudentProject $studentProject 
     * @return array
     *  video: string|null,
     *  tags: array|[],
     *  student_age: int,
     *  project: string|null,
     */
    public function transform(StudentProject $studentProject): array
    {
        return[
            'video' => $studentProject->video,
            'tags' => json_decode(optional($studentProject->modul)->tags ?? '[]', true),
            'student_age' => Carbon::parse(optional($studentProject->student)->birthdate)->age,
            'student_name' => $studentProject->student->name,
            'project' => $studentProject->project,
        ];
    }

    /**
     * Трансформирует коллекцию студ проектов в массив
     *
     * Применяет метод transform() к каждому элементу коллекции
     *
     * @param Collection $studentProjects Коллекция студ проектов
     * @return array<int, array{
     *      video: string|null,
     *      tags: array|[],
     *      student_age: int,
     *      project: string|null,
     * }> Массив трансформированных студ проектов
     */
    public function transformCollection(Collection $studentProjects): array
    {
        return $studentProjects->map(function($studentProject){
            return $this->transform($studentProject);
        })->toArray();
    }
}