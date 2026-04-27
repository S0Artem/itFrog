<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Models\StudentProject;
use App\Models\Student;
use Carbon\Carbon;

class AdminPortfolioController extends Controller
{
    public function showeAdminPortfolio() {
        
        $student_projects = StudentProject::with(['student:id,name,birthdate', 'modul:id,tags'])->cursor();

        $transformed_projects = [];
        $studentIds = [];

        foreach ($student_projects as $project) {
            $studentIds[] = $project->student_id;

            $transformed_projects[] = (object)[
                'id'           => $project->id,
                'video'        => $project->video,
                'project'      => $project->project,
                'student_id'   => $project->student_id,
                'student_name' => optional($project->student)->name,
                'student_age'  => Carbon::parse(optional($project->student)->birthdate)->age,
                'tags'         => json_decode(optional($project->modul)->tags ?? '[]', true),
            ];
        }

        // Загружаем только нужных учеников, одним запросом
        $students = Student::whereIn('id', array_unique($studentIds))->get()->keyBy('id');

        return view('admin.adminPortfolio.portfolio', [
            'student_projects' => $transformed_projects,
            'selectedStudents' => $students, // 👈 Переименовано!
        ]);
    }
}







