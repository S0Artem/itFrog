<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentProject;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TeacherPortfolioController extends Controller
{
    public function showeTeacherPortfolio()
    {
        $userId = Auth::id();

        // Шаг 1: Получаем employee_id
        $employeeId = DB::table('employees')->where('id', $userId)->value('id');

        if (!$employeeId) {
            abort(403, 'Доступ запрещён: вы не преподаватель');
        }

        // Шаг 2: Получаем все группы преподавателя
        $groupIds = DB::table('group_teachers')
            ->where('employee_id', $employeeId)
            ->pluck('group_id');

        // Шаг 3: Получаем всех студентов этих групп
        $studentIds = DB::table('modul_students')
            ->whereIn('group_id', $groupIds)
            ->pluck('student_id')
            ->unique();

        // Шаг 4: Получаем проекты этих студентов
        $student_projects = StudentProject::with(['student:id,name,birthdate', 'modul:id,tags'])
            ->whereIn('student_id', $studentIds)
            ->cursor();

        $transformed_projects = [];

        foreach ($student_projects as $project) {
            $transformed_projects[] = (object)[
                'id'           => $project->id,
                'video'        => $project->video,
                'project'      => $project->project,
                'student_id'   => $project->student_id,
                'student_name' => optional($project->student)->name,
                'student_age'  => \Carbon\Carbon::parse(optional($project->student)->birthdate)->age,
                'tags'         => json_decode(optional($project->modul)->tags ?? '[]', true),
            ];
        }

        // Загружаем нужных студентов (по id)
        $students = Student::whereIn('id', $studentIds)->get()->keyBy('id');

        return view('admin.adminPortfolio.portfolio', [
            'student_projects' => $transformed_projects,
            'selectedStudents' => $students,
        ]);
    }


    function studentProgectChange(Request $request){
        $messages = [
            'student_id.required' => 'Ученика выбрать обязательно',
            'student_id.exists' => 'Выбранный Ученик не найден',
            'text.required' => 'Описание проекта обязательно для заполнения',
            'text.min' => 'Описание проекта должно содержать минимум 10 символов',
        ];
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'text' => 'required|min:10',
        ], $messages);
        $student_projects = StudentProject::findOrFail($request->id);
        

        // Обновляем проект
        $student_projects->project = $request->text;
        $student_projects->student_id = $request->student_id;  // Убедитесь, что это правильное поле
        $student_projects->save();
    
        // Перенаправляем или возвращаем ответ
        return redirect()->route('showeTeacherPortfolio')->with('success', 'Проект успешно обновлен');
    }
    public function studentsSearch(Request $request)
    {
        $q = $request->input('q');

        $students = Student::select('id', 'name', 'birthdate')
            ->where('name', 'like', "%$q%")
            ->limit(20)
            ->get();

        return response()->json(
            $students->map(function ($s) {
                $age = \Carbon\Carbon::parse($s->birthdate)->age;
                return [
                    'id' => $s->id,
                    'label' => "{$s->name}, {$age} лет"
                ];
            })
        );
    }
}
