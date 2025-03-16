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
        $student_projects = $student_projects->map(function ($project) {
            $project->student_name = optional($project->student)->name; 
            $project->student_age = optional($project->student)->age;
            $project->tags = json_decode(optional($project->modul)->tags ?? '[]', true); 
            $project->progect = $project->progect;
            
            return $project;
        });
        
        


        return view('home.home', compact('directions', 'student_projects'));
    }
}
