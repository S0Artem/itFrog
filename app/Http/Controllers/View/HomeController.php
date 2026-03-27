<?php

namespace App\Http\Controllers\View;

use App\Models\Direction;
use App\Models\StudentProject;
use App\Models\Branch;
use App\Services\DirectionTransformer;
use App\Services\StudentProjectTransformer;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

/**
 * Класс для вывода главной страницы
 * 
 * @package App\Http\Controllers\View
 */
class HomeController extends Controller
{

    /**
     * Показывает главную страницу

     * @return View
     */
    function showeHome(): View
    {
        $directions = $this->getDirection();

        $branches = Branch::get();

        $student_projects = $this->getStudentProjects();

        return view('home.home', compact('directions', 'student_projects', 'branches'));
    }

    /**
     * Получить напровения с нужными полями
     * 
     * @return array< array{
     *     id: int,
     *     name: string,
     *     icon: string|null,
     *     modules_count: int,
     *     total_lessons: int,
     *     moduls_to_display: array<int, string>
     * }> Массив трансформированных направлений
     */
    function getDirection(): array
    {
        $directions = Direction::with('moduls')
            ->inRandomOrder()
            ->get();

        $transformer = new DirectionTransformer();
        $transformed = $transformer->transformCollection($directions);
        
        return $transformed;
    }

    /**
     * 
     * Получаем студ работы с нужными полями
     * 
     * @return array< array{
     *      video: string|null,
     *      tags: array|[],
     *      student_age: int,
     *      project: string|null,
     * }> Массив трансформированных студ проектов
     */
    function getStudentProjects(): array
    {
        $student_projects = StudentProject::with('student', 'modul')->get();
        $transformer = new StudentProjectTransformer();
        $transformed = $transformer->transformCollection($student_projects);
        return $transformed;
    }
}
