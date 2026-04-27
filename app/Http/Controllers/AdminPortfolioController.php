<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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


    function studentProgectChange(Request $request){
        $messages = [
            'student_id.required' => 'Ученика выбрать обязательно',
            'student_id.exists' => 'Выбранный ученик не найден',
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
        return redirect()->route('showeAdminPortfolio')->with('success', 'Проект успешно обновлен');
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
                $age = Carbon::parse($s->birthdate)->age;
                return [
                    'id' => $s->id,
                    'label' => "{$s->name}, {$age} лет"
                ];
            })
        );
    }
}







