<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use Illuminate\Http\Request;
use App\Models\StudentProgect;

class ControllerHome extends Controller
{
    function showeHome(){
        $directions = Direction::with('moduls')->get();
        $directions = $directions->map(function ($direction) {
            $direction->modules_count = $direction->moduls->count();
            $direction->total_lessons = $direction->moduls->sum('lesson');
            $direction->moduls_to_display = $direction->moduls->random(3);

            return $direction;
        });



        $student_projects = StudentProgect::with('student', 'modul')->get();

        $student_projects = StudentProgect::with('student', 'modul')->get();

        $student_projects = $student_projects->map(function ($project) {
            $project->student_name = optional($project->student)->name ?? 'Неизвестно'; 
            $project->student_age = optional($project->student)->age ?? 'Неизвестно'; 
            $project->tags = array_slice(json_decode(optional($project->modul)->tags ?? '[]', true), 0, 2); 
            $project->progect = $project->progect ?? 'Описание отсутствует';

            return $project;
        });
        
        


        return view('home.home', compact('directions', 'student_projects'));
    }
}
