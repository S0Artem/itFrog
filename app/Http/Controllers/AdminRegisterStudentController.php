<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\User;
use App\Models\Student;
use App\Models\Group;
use App\Models\ModulStudent;

class AdminRegisterStudentController extends Controller
{
    public function showe()
    {
        $branchs = Branch::all();
        $users = User::all();
        $groups = Group::with(['modul', 'branch', 'lessonTime'])->get();
        return view('admin.adminRegister.student.register', compact('users', 'branchs', 'groups'));
    }
    public function submitRegister(Request $request)
    {
        $messages = [
            'name.required' => 'Имя студента обязательно для заполнения',
            'birthdate.required' => 'Дата рождения обязательна для заполнения',
            'birthdate.date' => 'Пожалуйста, введите корректную дату',
            'branch_id.required' => 'Филиал обязательно для выбора',
            'group_id.required' => 'Группа обязательно для выбора',
            'user_id.required' => 'Пользователь обязательно для выбора',
        ];
        
        $request->validate([
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'branch_id' => 'required|exists:branches,id',
            'group_id' => 'required|exists:groups,id',
            'user_id' => 'required|exists:users,id',
        ], $messages);

        $student = Student::create([
            'name' => $request->name,
            'birthdate' => $request->birthdate,
            'branche_id' => $request->branch_id,
            'user_id' => $request->user_id,
        ]);

        $group = Group::findOrFail($request->group_id);
        
        ModulStudent::create([
            'group_id' => $request->group_id,
            'student_id' => $student->id,
            'modul_id' => $group->modul_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('showeRegisterStudent')->with('register', 'Студент успешно зарегистрирован!');    
    }
}
