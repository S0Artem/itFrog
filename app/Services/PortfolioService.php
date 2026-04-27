<?php

namespace App\Services;

use App\Models\Student;
use App\Models\StudentProject;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

class PortfolioService
{
    public function getAllStudentProjects(): LazyCollection
    {
        return StudentProject::with(['student:id,name,birthdate', 'modul:id,tags'])
            ->cursor();
    }

    public function transformProject(StudentProject $project): object
    {
        return (object)[
                'id'           => $project->id,
                'video'        => $project->video,
                'project'      => $project->project,
                'student_id'   => $project->student_id,
                'student_name' => optional($project->student)->name,
                'student_age'  => Carbon::parse(optional($project->student)->birthdate)->age,
                'tags'         => json_decode(optional($project->modul)->tags ?? '[]', true),
            ];
    }

    public function getStudentByIds(array $ids): Collection
    {
        return Student::whereIn('id', array_unique($ids))
            ->get()
            ->keyBy('id');
    }

    public function getPortfolioData(): array
    {
        $projects = $this->getAllStudentProjects();
        $transformed_projects = [];
        $studentIds = [];

        foreach ($projects as $project) {
            $studentIds[] = $project->student_id;
            $transformedProjects[] = $this->transformProject($project);
        }

        return [
            'projects' => $transformed_projects,
            'students' => $this->getStudentByIds($studentIds),
        ];
    }
}