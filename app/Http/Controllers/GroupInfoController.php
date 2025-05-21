<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Branch;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

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
                'students.user',
                'teacher.employee.user' => function($query) {
                    $query->select('id', 'name', 'number');
                }
            ]);

            $teacherName = 'Не назначен';
            $teacherPhone = 'Не указан';

            if ($group->teacher && $group->teacher->employee && $group->teacher->employee->user) {
                $teacherName = $group->teacher->employee->user->name;
                $teacherPhone = $group->teacher->employee->user->number ?? 'Не указан';
            }

            // Добавляем расчет статуса оплаты для каждого студента
            $students = $group->students->map(function($student) {
                $lastPaymentDate = $student->pivot->last_payment_date ?? null;

                $isOverdue = false;
                $paymentDisplay = 'Не указана';

                if ($lastPaymentDate) {
                    $startDate = Carbon::parse($lastPaymentDate)->startOfDay();
                    $endDate = $startDate->copy()->addMonth();
                    $now = now()->startOfDay();

                    $isOverdue = $now->gte($endDate);

                    $daysLeft = $now->diffInDays($endDate);

                    if ($isOverdue) {
                        $paymentDisplay = "{$startDate->format('d.m.Y')} - {$endDate->format('d.m.Y')}";
                    } else {
                        $paymentDisplay = "{$startDate->format('d.m.Y')} - {$endDate->format('d.m.Y')} ({$daysLeft} дн.)";
                    }
                }

                return [
                    'id' => $student->id,
                    'name' => $student->user->name ?? 'Не указано',
                    'phone' => $student->user->number ?? 'Не указан',
                    'birthdate' => $student->birthdate,
                    'isOverdue' => $isOverdue,
                    'paymentDisplay' => $paymentDisplay,
                ];
            });

            return view('admin.groupInfo.groupInfo', [
                'group' => $group,
                'branches' => $branches,
                'selectedBranch' => $selectedBranch,
                'teacherName' => $teacherName,
                'teacherPhone' => $teacherPhone,
                'students' => $students
            ]);

        } catch (ModelNotFoundException $e) {
            abort(404, 'Группа не найдена');
        }
    }

}