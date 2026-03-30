<?php
namespace App\Services\Home;

use App\Models\Direction;
use App\Models\StudentProject;
use Illuminate\Support\Facades\Cache;
use App\Models\Branch;
use \Carbon\Carbon;


class HomeDataService
{

    /**
     * Получаем все данные для главной страницы
     *
     * @return array{
     *      directions:array,
     *      student_projects:array,
     *      branches:array,
     * }
     */
    public function getHomePageData(): array
    {
        return[
            'directions' => $this->getCachedDirections(),
            'student_projects' => $this->getCachedProjects(),
            'branches' => $this->getCachedBranches(),
        ];
    }



    /**
     * Получаем филиаллы и записываем в кеш раз в 300 секунд
     *
     * @return array<int, array{id: int,
     *      name: string,
     *      address: string|null,
     * }>
     * 
     * @cache 300 секунд
     * @cache-key branches_cache
     */
    private function getCachedBranches(): array
    {
        return Cache::remember('branches_cache', 300, function () {
            return Branch::get()->toArray();
        });
    }

    /**
     * Получить направления с кэшированием
     * 
     * @return array<int, array{
     *     id: int,
     *     icon: string|null,
     *     name: string,
     *     modules_count: int,
     *     total_lessons: int,
     *     moduls_to_display: array<int, string>
     * }>
     * 
     * @cache 300 секунд
     * @cache-key directions_cache
     */
    function getCachedDirections(): array
    {
        return Cache::remember('directions_cache', 300, function () {
            return Direction::with('moduls')
                ->inRandomOrder()
                ->get()
                ->map(fn ($d) =>[
                    'id' => $d->id,
                    'icon' => $d->icon,
                    'name' => $d->name,
                    'modules_count' => $d->moduls->count(),
                    'total_lessons' => $d->moduls->sum('lesson'),
                    'moduls_to_display' => $d->moduls->count() >= 3 
                        ? $d->moduls->random(3)->pluck('name')->toArray()
                        : $d->moduls->pluck('name')->toArray(),
                ])
                ->toArray();
        });
    }

    /**
     * 
     * Получить студенческие проекты с кэшированием
     * 
     * @return array<int, array{
     *      video: string|null,
     *      tags: array|[],
     *      student_age: int,
     *      student_name: string|'Неизвестно',
     *      project: string|null,
     * }>
     * 
     * @cache 300 секунд
     * @cache-key studentProjects_cache
     */
    function getCachedProjects(): array
    {

        return Cache::remember('studentProjects_cache', 300, function() {
            return StudentProject::with('student', 'modul')
                ->get()
                ->map(fn ($s) =>[
                    'video' => $s->video,
                    'tags' => json_decode(optional($s->modul)->tags ?? '[]', true),
                    'student_age' => Carbon::parse(optional($s->student)->birthdate)->age,
                    'student_name' => optional($s->student)->name ?? 'Неизвестно',
                    'project' => $s->project,
                ])
                ->toArray();
        });
    }
}