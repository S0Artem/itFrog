<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Branch;
use App\Models\ModulStudent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GroupInfoController extends Controller
{
    public function show(Group $group)
    {
        try {
            $branches = Branch::all();
            $selectedBranch = request('branch_id') ?? $group->branch_id;

            // Загружаем связи, включая pivot last_payment_date
            $group->load([
                'modul',
                'branch',
                'students.student.user',
                'teacher.employee.user' => function($query) {
                    $query->select('id', 'name', 'number');
                }
            ]);

            // Дополнительно загружаем user для каждого студента
            $group->students->load('student.user');

            $teacherName = 'Не назначен';
            $teacherPhone = 'Не указан';

            if ($group->teacher && $group->teacher->employee && $group->teacher->employee->user) {
                $teacherName = $group->teacher->employee->user->name;
                $teacherPhone = $group->teacher->employee->user->number ?? 'Не указан';
            }

            // Добавляем расчет статуса оплаты для каждого студента
            $students = $group->students->map(function($modulStudent) {
                $student = $modulStudent->student;
                
                // Проверяем, что у студента есть связь с user
                if (!$student || !$student->user) {
                    return [
                        'id' => $student ? $student->id : 'unknown',
                        'name' => 'Ошибка: нет информации пользователя',
                        'phone' => 'Не указан',
                        'birthdate' => $student ? $student->birthdate : null,
                        'isOverdue' => false,
                        'paymentDisplay' => 'Ошибка данных',
                        'paymentInfo' => 'Ошибка данных',
                        'daysLeft' => null,
                    ];
                }

                // Используем last_payment_date из записи modul_students
                $lastPaymentDate = $modulStudent->last_payment_date;

                $isOverdue = false;
                $paymentDisplay = 'Не указана';
                $daysLeft = null;

                if ($lastPaymentDate) {
                    $startDate = Carbon::parse($lastPaymentDate)->startOfDay();
                    $endDate = $startDate->copy()->addMonth();
                    $now = now()->startOfDay();

                    $isOverdue = $now->gte($endDate);
                    $daysLeft = $now->diffInDays($endDate, false); // false для получения отрицательных значений

                    if ($isOverdue) {
                        $paymentDisplay = "Просрочено на " . abs($daysLeft) . " дн.";
                    } else {
                        $paymentDisplay = "Осталось " . $daysLeft . " дн.";
                    }
                }

                return [
                    'id' => $student->id,
                    'name' => $student->name ?? 'Не указано',
                    'phone' => $student->user->number ?? 'Не указан',
                    'birthdate' => $student->birthdate,
                    'isOverdue' => $isOverdue,
                    'paymentDisplay' => $paymentDisplay,
                    'paymentInfo' => $paymentDisplay,
                    'daysLeft' => $daysLeft,
                ];
            });

            // Загружаем учеников филиала для добавления в группу (только для админа)
            $availableStudents = collect();
            if (Auth::check() && Auth::user()->role === 'admin') {
                // Отладочная информация
                $totalStudentsInBranch = \App\Models\Student::where('branch_id', $group->branch_id)->count();
                $studentsInGroups = \App\Models\Student::where('branch_id', $group->branch_id)
                    ->whereHas('modulStudents', function($query) {
                        $query->whereNull('deleted_at'); // Только активные записи
                    })
                    ->count();
                $studentsWithoutNames = \App\Models\Student::where('branch_id', $group->branch_id)
                    ->whereDoesntHave('modulStudents') // Все ученики, которые не в группах (включая soft-deleted)
                    ->whereDoesntHave('user', function($query) {
                        $query->whereNotNull('name')->where('name', '!=', '');
                    })
                    ->count();

                if (config('app.debug')) {
                    Log::info("Отладка учеников для группы {$group->id}:", [
                        'Всего учеников в филиале' => $totalStudentsInBranch,
                        'Учеников в группах' => $studentsInGroups,
                        'Учеников без имен' => $studentsWithoutNames,
                        'Филиал группы' => $group->branch_id
                    ]);
                }

                $availableStudents = \App\Models\Student::with(['user'])
                    ->where('branch_id', $group->branch_id) // Используем филиал группы
                    ->whereDoesntHave('modulStudents') // Исключаем учеников, которые уже в любых группах (включая soft-deleted)
                    ->whereHas('user', function($query) {
                        $query->whereNotNull('name')
                              ->where('name', '!=', '')
                              ->where('name', '!=', 'test')
                              ->where('name', '!=', 'Test')
                              ->where('name', '!=', 'TEST')
                              ->where('name', 'not like', '%test%')
                              ->where('name', 'not like', '%Test%');
                    }) // Только ученики с заполненными именами, исключаем тестовые
                    ->whereNotNull('birthdate') // Только ученики с указанной датой рождения
                    ->orderBy('id', 'desc') // Сортируем по ID в обратном порядке (новые сначала)
                    ->get()
                    ->map(function($student) {
                        // Проверяем, что у студента есть связь с user
                        if (!$student->user) {
                            return null; // Пропускаем учеников без данных пользователя
                        }

                        // Дополнительная проверка имени
                        if (empty($student->user->name) || 
                            $student->user->name === 'test' || 
                            $student->user->name === 'Test' ||
                            $student->user->name === 'TEST' ||
                            str_contains(strtolower($student->user->name), 'test')) {
                            return null;
                        }

                        // Для учеников, которые не в группах, используем историю платежей
                        $lastPayment = \App\Models\PaymentHistorie::where('student_id', $student->id)
                            ->where('status', 'confirmed')
                            ->whereNotNull('paid_at')
                            ->orderBy('paid_at', 'desc')
                            ->first();

                        $paymentInfo = 'Нет абонемента';
                        $isOverdue = false;
                        $daysLeft = null;

                        if ($lastPayment && $lastPayment->paid_at) {
                            $startDate = Carbon::parse($lastPayment->paid_at)->startOfDay();
                            $endDate = $startDate->copy()->addMonth();
                            $now = now()->startOfDay();

                            $isOverdue = $now->gte($endDate);
                            $daysLeft = $now->diffInDays($endDate, false); // false для получения отрицательных значений

                            if ($isOverdue) {
                                $paymentInfo = "Просрочено на " . abs($daysLeft) . " дн.";
                            } else {
                                $paymentInfo = "Осталось " . $daysLeft . " дн.";
                            }
                        }

                        return [
                            'id' => $student->id,
                            'name' => $student->name ?? 'Не указано',
                            'phone' => $student->user->number ?? 'Не указан',
                            'birthdate' => $student->birthdate,
                            'paymentInfo' => $paymentInfo,
                            'paymentDisplay' => $paymentInfo, // Добавляем для совместимости
                            'isOverdue' => $isOverdue,
                            'daysLeft' => $daysLeft,
                        ];
                    })
                    ->filter(function($student) {
                        // Дополнительная фильтрация: исключаем учеников без имени или с пустыми данными
                        return $student !== null && 
                               !empty($student['name']) && 
                               $student['name'] !== 'Не указано' &&
                               $student['name'] !== 'test' &&
                               $student['name'] !== 'Test' &&
                               $student['name'] !== 'TEST' &&
                               !str_contains(strtolower($student['name']), 'test');
                    })
                    ->values() // Переиндексируем массив
                    ->take(50); // Ограничиваем до 50 учеников для удобства

                if (config('app.debug')) {
                    Log::info("Доступных учеников для добавления: " . $availableStudents->count());
                }
            }

            return view('admin.groupInfo.groupInfo', [
                'group' => $group,
                'branches' => $branches,
                'selectedBranch' => $selectedBranch,
                'teacherName' => $teacherName,
                'teacherPhone' => $teacherPhone,
                'students' => $students,
                'availableStudents' => $availableStudents
            ]);

        } catch (ModelNotFoundException $e) {
            abort(404, 'Группа не найдена');
        }
    }

    public function addStudent(Request $request, Group $group)
    {
        // Проверяем права доступа - только админ может добавлять учеников
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return back()->withErrors(['access' => 'У вас нет прав для добавления учеников в группу']);
        }

        $request->validate([
            'student_id' => 'required|exists:students,id',
        ], [
            'student_id.required' => 'Выберите ученика для добавления',
            'student_id.exists' => 'Выбранный ученик не найден',
        ]);

        // Проверяем, что ученик не уже в этой группе (включая soft-deleted)
        $existingStudent = ModulStudent::withTrashed()
            ->where('student_id', $request->student_id)
            ->where('group_id', $group->id)
            ->first();

        if ($existingStudent && !$existingStudent->trashed()) {
            return back()->withErrors(['student_id' => 'Этот ученик уже в группе']);
        }

        // Ищем soft-deleted запись для восстановления (в любой группе)
        $old = ModulStudent::withTrashed()
            ->where('student_id', $request->student_id)
            ->orderByDesc('updated_at')
            ->first();

        if ($old) {
            // Восстанавливаем soft-deleted запись, но для новой группы
            $old->restore();
            $old->update([
                'group_id' => $group->id,
                'modul_id' => $group->modul_id,
                'updated_at' => now(),
            ]);
            
            $lastPaymentDate = $old->last_payment_date;
            
            // Отладочная информация
            if (config('app.debug')) {
                Log::info("Восстановление ученика в группу:", [
                    'student_id' => $request->student_id,
                    'old_group_id' => $old->getOriginal('group_id'),
                    'new_group_id' => $group->id,
                    'restored_last_payment_date' => $lastPaymentDate,
                    'current_time' => now()
                ]);
            }
        } else {
            // Создаем новую запись
            $lastPayment = \App\Models\PaymentHistorie::where('student_id', $request->student_id)
                ->where('status', 'confirmed')
                ->whereNotNull('paid_at')
                ->orderBy('paid_at', 'desc')
                ->first();
            
            $lastPaymentDate = $lastPayment && $lastPayment->paid_at ? $lastPayment->paid_at : now();

            // Отладочная информация
            if (config('app.debug')) {
                Log::info("Создание новой записи ученика в группу:", [
                    'student_id' => $request->student_id,
                    'group_id' => $group->id,
                    'last_payment_from_history' => $lastPayment ? $lastPayment->paid_at : 'null',
                    'last_payment_date_to_set' => $lastPaymentDate,
                    'current_time' => now()
                ]);
            }

            // Добавляем ученика в группу
            ModulStudent::create([
                'group_id' => $group->id,
                'student_id' => $request->student_id,
                'modul_id' => $group->modul_id,
                'created_at' => now(),
                'updated_at' => now(),
                'last_payment_date' => $lastPaymentDate,
            ]);
        }

        return redirect()->route('group.show', ['group' => $group->id, 'branch_id' => $request->selectedBranch ?? $group->branch_id])
            ->with('success', 'Ученик успешно добавлен в группу');
    }

    function delete(Request $request){
        // Проверяем права доступа - только админ может удалять учеников
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return back()->withErrors(['access' => 'У вас нет прав для удаления учеников из группы']);
        }

        $request->validate([
            'studentId' => 'required',
            'group' => 'required',
            'selectedBranch' => 'required',
        ]);

        // Получаем информацию о студенте перед удалением
        $studentToDelete = ModulStudent::where('student_id', $request->studentId)
            ->where('group_id', $request->group)
            ->first();

        // Отладочная информация
        if (config('app.debug') && $studentToDelete) {
            Log::info("Удаление ученика из группы:", [
                'student_id' => $request->studentId,
                'group_id' => $request->group,
                'last_payment_date_before_delete' => $studentToDelete->last_payment_date,
                'current_time' => now()
            ]);
        }

        // Используем soft delete
        ModulStudent::where('student_id', $request->studentId)
            ->where('group_id', $request->group)
            ->delete();
        return redirect()->route('group.show', ['group' => $request->group, 'branch_id' => $request->selectedBranch]);
    }
    function deleteGroop(Request $request){
        // Проверяем права доступа - только админ может удалять группы
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return back()->withErrors(['access' => 'У вас нет прав для удаления групп']);
        }

        $request->validate([
            'group' => 'required',
        ]);
        Group::where('id', $request->group)
            ->delete();
        return redirect()->route('showeShedule');
    }
}