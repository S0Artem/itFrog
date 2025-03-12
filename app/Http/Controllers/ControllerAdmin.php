<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentProgect;
use App\Models\Student;

class ControllerAdmin extends Controller
{
    function showeAdmin(){

        $student_projects = StudentProgect::with('student', 'modul')->get();

        $student_projects = StudentProgect::with('student', 'modul')->get();

        $student_projects = $student_projects->map(function ($project) {
            $project->student_name = optional($project->student)->name ?? 'Неизвестно'; 
            $project->student_age = optional($project->student)->age ?? 'Неизвестно'; 
            $project->tags = json_decode(optional($project->modul)->tags ?? '[]', true);
            $project->progect = $project->progect ?? 'Описание отсутствует';
            return $project;
        });

        $students = Student::all(); // Получаем всех детей для выпадающего списка

        
        return view('profilAdmin.profilAdmin', compact('student_projects', 'students'));
    }
    function studentProgectChange(Request $request){
        $messages = [
            'student_id' => 'Косякнул с ребеноком',
            'text.required' => 'Нельзя без текста уж',
        ];
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'text' => 'required',
        ], $messages);
        $student_projects = StudentProgect::findOrFail($request->id);
        

        // Обновляем проект
        $student_projects->progect = $request->text;
        $student_projects->student_id = $request->student_id;  // Убедитесь, что это правильное поле
        $student_projects->save();
    
        // Перенаправляем или возвращаем ответ
        return redirect()->route('showeAdmin');
    }
}
