<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Group;
use App\Models\ModulStudent;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;

class CashPaymenеController extends Controller
{
    public function showe()
    {
        if (!Auth::check() || Auth::user()->role == 'user') {
            return abort(403);
        }

        $userId = Auth::user()->id;

        $employee = Employee::find($userId);
        if (!$employee) {
            return abort(403);
        }

        $branchId = $employee->branche_id;

        $groups = Group::where('branch_id', $branchId)->with('modul')->get();

        $students = Student::where('branche_id', $branchId)
            ->with(['groups' => function ($query) {
                $query->select('groups.id'); // или убери select, если нужен last_payment_date
            }])
            ->get();

        foreach ($students as $student) {
            foreach ($student->groups as $group) {
                $lastPaymentDate = $group->pivot->last_payment_date ?? null;

                if ($lastPaymentDate) {
                    $startDate = Carbon::parse($lastPaymentDate)->startOfDay();
                    $endDate = $startDate->copy()->addMonth();
                    $now = now()->startOfDay();

                    $daysLeft = $now->diffInDays($endDate, false); // отрицательные — просрочено

                    if ($now->gte($endDate)) {
                        $group->payment_display = "{$startDate->format('d.m.Y')} - {$endDate->format('d.m.Y')} (просрочено)";
                        $group->payment_color = 'red';
                    } elseif ($daysLeft <= 7) {
                        $group->payment_display = "{$startDate->format('d.m.Y')} - {$endDate->format('d.m.Y')} ({$daysLeft} дн.)";
                        $group->payment_color = 'orange';
                    } else {
                        $group->payment_display = "{$startDate->format('d.m.Y')} - {$endDate->format('d.m.Y')} ({$daysLeft} дн.)";
                        $group->payment_color = 'black';
                    }
                } else {
                    $group->payment_display = 'Не указана';
                    $group->payment_color = 'red';
                }
            }
        }

        return view('teacher.cashPaymen.cashPaymen', compact('groups', 'students'));
    }


    public function submit(Request $request)
    {
        $messages = [
            'student_id.required' => 'Ученик обязательен для выбора',
            'group_id.required' => 'Группа обязательна для выбора',
        ];
        
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'group_id' => 'required|exists:groups,id',
        ], $messages);

        $studentId = $request->input('student_id');
        $groupId = $request->input('group_id');

        // Получаем студента
        $student = Student::find($studentId);
        if (!$student) {
            return back()->withErrors(['student_id' => 'Ученик не найден']);
        }

        // Проверяем, состоит ли студент в выбранной группе
        $group = $student->groups()->where('groups.id', $groupId)->first();

        if (!$group) {
            return back()->withErrors(['group_id' => 'Ученик не состоит в выбранной группе']);
        }

        // Получаем текущую дату оплаты из pivot
        $lastPaymentDate = $group->pivot->last_payment_date;

        $today = Carbon::today();

        if ($lastPaymentDate) {
            $endDate = Carbon::parse($lastPaymentDate)->addMonth()->startOfDay();
            $daysPast = $today->diffInDays($endDate, false); // отрицательное, если дата в прошлом

            if ($daysPast < -6) {
                // Если просрочка больше 6 дней — начинаем с сегодняшнего дня
                $newDate = $today;
            } else {
                // Если просрочка меньше 6 дней или ещё не наступил конец оплаты — добавляем месяц к endDate
                $newDate = $endDate;
            }
        } else {
            // Если даты оплаты не было — ставим сегодня
            $newDate = $today;
        }

        // Обновляем дату оплаты в pivot
        $student->groups()->updateExistingPivot($groupId, [
            'last_payment_date' => $newDate->format('Y-m-d'),
        ]);

        return back()->with('success', 'Дата оплаты успешно продлена на месяц');
    }
}
