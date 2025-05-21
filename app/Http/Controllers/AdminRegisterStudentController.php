<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\User;
use App\Models\Student;
use App\Models\Group;
use App\Models\ModulStudent;
use Carbon\Carbon;

class AdminRegisterStudentController extends Controller
{
    public function showe(Request $request)
    {
        $student_birth_date = $request->query('student_birth_date');
        $student_name = $request->query('student_name');
        $branch_id = $request->query('branche_id');

        $branchs = Branch::all();
        $users = User::where('role', 'user')->get();
        $groups = Group::with(['modul', 'branch', 'lessonTime'])->get();
        return view('admin.adminRegister.student.register', compact('users', 'branchs', 'groups', 'student_name', 'student_birth_date', 'branch_id'));
    }
    public function submitRegister(Request $request)
    {
        $messages = [
            'name.required' => 'Имя студента обязательно для заполнения',
            'name.regex' => 'Введите полное ФИО (например, Софронов Артем Павлович)',
            'birthdate.required' => 'Дата рождения обязательна для заполнения',
            'birthdate.date' => 'Пожалуйста, введите корректную дату',
            'branch_id.required' => 'Филиал обязательно для выбора',
            'group_id.required' => 'Группа обязательно для выбора',
            'user_id.required' => 'Пользователь обязательно для выбора',
        ];
        
        $request->validate([
            'name' => ['required', 'regex:/^\s*\S+\s+\S+\s+\S+/u'],
            'birthdate' => 'required|date',
            'branch_id' => 'required',
            'group_id' => 'required',
            'user_id' => 'required',
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
            'last_payment_date' => Carbon::now()->subMonthNoOverflow()->subDay(),
        ]);

        return redirect()->route('showeRegisterStudent')->with('register', 'Студент успешно зарегистрирован!');    
    }
}
