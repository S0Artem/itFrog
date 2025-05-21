<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentProgect;
use App\Models\Student;
use Carbon\Carbon;

class AdminPortfolioController extends Controller
{
    public function showeAdminPortfolio() {
        $student_projects = StudentProgect::with(['student:id,name,birthdate', 'modul:id,tags'])->cursor();

        $transformed_projects = [];
        $studentIds = [];

        foreach ($student_projects as $project) {
            $studentIds[] = $project->student_id;

            $transformed_projects[] = (object)[
                'id'           => $project->id,
                'video'        => $project->video,
                'progect'      => $project->progect,
                'student_id'   => $project->student_id,
                'student_name' => optional($project->student)->name,
                'student_age'  => \Carbon\Carbon::parse(optional($project->student)->birthdate)->age,
                'tags'         => json_decode(optional($project->modul)->tags ?? '[]', true),
            ];
        }

        // Загружаем только нужных студентов, одним запросом
        $students = Student::whereIn('id', array_unique($studentIds))->get()->keyBy('id');

        return view('admin.adminPortfolio.portfolio', [
            'student_projects' => $transformed_projects,
            'selectedStudents' => $students, // 👈 Переименовано!
        ]);
    }


    function studentProgectChange(Request $request){
        $messages = [
            'student_id' => 'Ученика выбрать обязательно',
            'text.required' => 'Описание обязательно',
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
        return redirect()->route('showeAdminPortfolio');
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
