<?php

namespace App\Http\Controllers;

use App\Models\ModulStudent;
use App\Models\Student;
use App\Models\Modul;
use App\Models\StudentProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreatePortfolio extends Controller
{
    public function showCreateStudentProjectForm()
    {
        $userId = Auth::id();

        // Шаг 1: Получаем employee_id
        $employeeId = DB::table('employees')->where('id', $userId)->value('id');

        if (!$employeeId) {
            abort(403, 'Доступ запрещён: вы не преподаватель');
        }

        // Получаем все группы преподавателя
        $groupIds = DB::table('group_teachers')
            ->where('employee_id', $employeeId)
            ->pluck('group_id');

        // Получаем всех учеников этих групп с их модулями
        $students = DB::table('modul_students')
            ->join('students', 'modul_students.student_id', '=', 'students.id')
            ->join('groups', 'modul_students.group_id', '=', 'groups.id')
            ->join('moduls', 'groups.modul_id', '=', 'moduls.id')
            ->whereIn('modul_students.group_id', $groupIds)
            ->select('students.id as student_id', 'students.name as student_name', 
                    'moduls.id as modul_id', 'moduls.name as modul_name')
            ->get();

        return view('teacher.createPortfolio.createPortfolio', compact('students'));
    }

    public function store(Request $request)
    {
        $messages = [
            'student_id.required' => 'Ученика выбрать обязательно',
            'student_id.exists' => 'Выбранный ученик не найден',
            'modul_id.required' => 'Модуль обязателен для выбора',
            'modul_id.exists' => 'Выбранный модуль не найден',
            'description.required' => 'Описание проекта обязательно для заполнения',
            'description.min' => 'Описание проекта должно содержать минимум 10 символов',
            'description.max' => 'Описание проекта не должно превышать 1000 символов',
            'media.required' => 'Файл обязателен для загрузки',
            'media.file' => 'Загруженный файл не является корректным файлом',
            'media.mimes' => 'Поддерживаются только файлы форматов: jpeg, png, jpg, mp4',
            'media.max' => 'Размер файла не должен превышать 1 МБ',
        ];

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'modul_id' => 'required|exists:moduls,id',
            'description' => 'required|string|min:10|max:1000',
            'media' => 'required|file|mimes:jpeg,png,jpg,mp4|max:1024'
        ], $messages);

        // Проверяем размеры изображения/видео
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            if ($file->getMimeType() === 'image/jpeg' || $file->getMimeType() === 'image/png' || $file->getMimeType() === 'image/jpg') {
                $image = getimagesize($file->getPathname());
                if ($image[0] !== 768 || $image[1] !== 432) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['media' => "Изображение должно иметь размер 768x432 пикселей, а у вас {$image[0]}x{$image[1]}"]);
                }
            }
        }

        // Создаем запись проекта в базе данных
        $studentProject = StudentProject::create([
            'student_id' => $request->student_id,
            'modul_id' => $request->modul_id,
            'project' => $request->description,
            'video' => '', // Временно Пусто.е, обновим после сохранения файла
        ]);

        // Сохраняем файл
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $extension = $file->getClientOriginalExtension();
            $fileName = 'student_progect_' . $studentProject->id . '.' . $extension;
            
            // Сохраняем файл в папку public/img
            $file->move(public_path('img'), $fileName);
            
            // Обновляем путь к файлу в базе данных
            $studentProject->update([
                'video' => 'img/' . $fileName
            ]);
        }

        return redirect()->back()->with('success', 'Проект успешно создан');
    }
}
