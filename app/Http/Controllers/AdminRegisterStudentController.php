<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\User;
use App\Models\Student;
use App\Models\Group;
use App\Models\ModulStudent;
use App\Models\Application;
use App\Models\LessonTime;
use App\Models\Modul;
use App\Notifications\SendInfo;
use Carbon\Carbon;
use App\Rules\ProperNameFormat;
use App\Rules\AgeLimit;

class AdminRegisterStudentController extends Controller
{
    public function showe(Request $request)
    {
        $student_birth_date = $request->query('student_birth_date');
        $student_name = $request->query('student_name');
        $branch_id = $request->query('branch_id');
        $user_id = $request->query('user_id');

        $branchs = Branch::all();
        $users = User::where('role', 'user')->get();
        $groups = Group::with(['modul', 'branch', 'lessonTime'])->get();
        return view('admin.adminRegister.student.register', compact('users', 'branchs', 'groups', 'student_name', 'student_birth_date', 'branch_id', 'user_id'));
    }
    public function submitRegister(Request $request)
    {
        $messages = [
            'name.required' => 'Имя ученика обязательно для заполнения',
            'birthdate.required' => 'Дата рождения обязательна для заполнения',
            'birthdate.date' => 'Пожалуйста, введите корректную дату',
            'branch_id.required' => 'Филиал обязательно для выбора',
            'group_id.required' => 'Группа обязательно для выбора',
            'user_id.required' => 'Пользователь обязательно для выбора',
        ];
        
        $request->validate([
            'name' => ['required', new ProperNameFormat],
            'birthdate' => ['required', 'date', new AgeLimit(null, 18, 'student')],
            'branch_id' => 'required',
            'group_id' => 'required',
            'user_id' => 'required',
        ], $messages);

        $student = Student::create([
            'name' => $request->name,
            'birthdate' => $request->birthdate,
            'branch_id' => $request->branch_id,
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
        $parent = User::findOrFail($request->user_id);
    $parentName = $parent->name;
    $childName = $request->name;
    $day = $group->day;
    $time = LessonTime::findOrFail($group->time_id)->lesson_start;
    $moduleName = Modul::findOrFail($group->modul_id)->name;
    $status = 0;

    // Отправляем уведомление пользователю
    $parent->notify(new SendInfo($parentName, $childName, $day, $time, $moduleName, $status));
        // Если есть application_id, обновляем статус заявки на "Готовая" и данные ученик
        if ($request->has('aplication_id')) {
            $application = Application::find($request->aplication_id);
            if ($application) {
                $application->status = 'Готовая';
                $application->student_id = $student->id;
                $application->update(['updated_at' => now()->setTimezone('Europe/Moscow')]);
            }
        }

        return redirect()->route('showeRegisterStudent')->with('register', 'Ученик успешно зарегистрирован!');    
    }
}
