<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use Illuminate\Http\Request;
use App\Models\StudentProject;
use App\Models\Branch;

class HomeController extends Controller
{
    function showeHome(){
        $directions = Direction::with('moduls')->inRandomOrder()->get();
        $directions = $directions->map(function ($direction) {
            $direction->modules_count = $direction->moduls->count();
            $direction->total_lessons = $direction->moduls->sum('lesson');
            $direction->moduls_to_display = $direction->moduls->count() >= 3 ? $direction->moduls->random(3) : $direction->moduls;

            return $direction;
        });
        $branches = Branch::get();



        $student_projects = StudentProject::with('student', 'modul')->get();
        $student_projects = $student_projects->map(function ($project) {
            $project->student_name = optional($project->student)->name; 
            $project->student_age = \Carbon\Carbon::parse(optional($project->student)->birthdate)->age;
            $project->tags = json_decode(optional($project->modul)->tags ?? '[]', true); 
            $project->project = $project->project;
            
            return $project;
        });
        
        


        return view('home.home', compact('directions', 'student_projects', 'branches'));
    }
}
