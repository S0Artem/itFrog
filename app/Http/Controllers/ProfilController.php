<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Student;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Group;
use App\Models\GroupTeacher;
use App\Models\Modul;
use App\Models\ModulStudent;
use Carbon\Carbon;

class ProfilController extends Controller
{
    public function showe()
    {
        $userId = Auth::id();

        // Получаем филиал
        $employee = Employee::find($userId);
        $branchId = $employee?->branche_id;
        $branch = Branch::find($branchId);

        // Получаем все group_id, где учитель прикреплён
        $groupIds = GroupTeacher::where('employee_id', $userId)->pluck('group_id');

        // Получаем все modul_id из этих групп
        $modulIds = \App\Models\Group::whereIn('id', $groupIds)->pluck('modul_id')->unique();

        // Получаем модули по этим ID
        $moduls = Modul::whereIn('id', $modulIds)->get();



        $userInfo = User::find($userId, ['email', 'name', 'number']);
        $userStudents = Student::with([
            'branch',
            'groups.time',
            'groups.modul',
            'groups.teachers.user',
        ])->where('user_id', $userId)
        ->get();
        foreach ($userStudents as $student) {
            foreach ($student->groups as $group) {
                $lastPaymentDate = $group->pivot->last_payment_date;

                if ($lastPaymentDate) {
                    $startDate = Carbon::parse($lastPaymentDate)->startOfDay();
                    $endDate = $startDate->copy()->addMonth();

                    $now = now()->startOfDay();

                    $group->formatted_payment_date = $startDate->format('d.m.Y');
                    $group->formatted_expiry_date = $endDate->format('d.m.Y');

                    $isOverdue = $now->gte($endDate);
                    $group->is_payment_overdue = $isOverdue;

                    // Рассчитываем количество оставшихся дней
                    $daysLeft = $now->diffInDays($endDate);

                    if ($isOverdue) {
                        $group->payment_display = "{$startDate->format('d.m.Y')} - {$endDate->format('d.m.Y')} (просрочено, можете оплатить на сайте либо наличными в филиале)";
                    } else {
                        $group->payment_display = "{$startDate->format('d.m.Y')} - {$endDate->format('d.m.Y')} ({$daysLeft} дн.)";
                    }

                    // Добавляем цвет для отображения
                    $paymentColor = '';
                    $showButton = false; // по умолчанию кнопка скрыта

                    if ($daysLeft <= 7 && $daysLeft >= 0) {
                        $paymentColor = 'orange'; // Желтый цвет, если осталось от 1 до 7 дней
                        $showButton = true; // показываем кнопку
                    } elseif ($isOverdue) {
                        $paymentColor = 'red'; // Красный, если просрочено
                        $showButton = true; // показываем кнопку
                    }

                    // Отображаем дату с соответствующим цветом
                    $group->payment_color = $paymentColor;
                    $group->show_button = $showButton; // добавляем флаг для показа кнопки

                } else {
                    $group->is_payment_overdue = true;
                    $group->payment_display = 'Не указана';
                    $group->show_button = false; // кнопка скрыта, если дата не указана
                }
            }
        }




        return view('profil.profil', compact('userInfo', 'userStudents', 'branch', 'moduls'));
    }
}
