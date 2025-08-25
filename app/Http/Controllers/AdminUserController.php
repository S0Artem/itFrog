<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{


    public function index(Request $request)
    {
        $query = User::query()->with(['student.branch', 'student.groups.time', 'student.groups.modul']);

        // Filtering
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->input('email') . '%');
        }
        if ($request->filled('number')) {
            $query->where('number', 'like', '%' . $request->input('number') . '%');
        }
        if ($request->filled('branch_id')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('branch_id', $request->input('branch_id'));
            });
        }
        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        // Preserve query parameters for pagination
        $users = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->except('page'));

        // Calculate age and payment details for students
        foreach ($users as $user) {
            foreach ($user->student as $student) {
                if ($student->birthdate) {
                    $age = Carbon::parse($student->birthdate)->diff(now());
                    $student->age_text = $age->y . ' года ' . $age->m . ' месяцев';
                } else {
                    $student->age_text = 'нет информации';
                }

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

                        $daysLeft = $now->diffInDays($endDate);
                        $group->payment_display = $isOverdue 
                            ? "просрочено" 
                            : "{$daysLeft} дн.";
                    }
                }
            }
        }

        return view('admin.adminUsers.adminUsers', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($id)],
            'number' => 'nullable|string|max:255',
            'role' => 'required|in:user,teacher,admin',
        ], [
            'name.required' => 'ФИО обязательно для заполнения',
            'email.required' => 'Почта обязательна для заполнения',
            'email.email' => 'Введите корректный адрес электронной почты',
            'email.unique' => 'Эта почта уже используется',
            'role.required' => 'Роль обязательна для выбора',
        ]);

        if ($validator->fails()) {
            return back()->withErrors(['user_' . $id => $validator->errors()->first()])
                        ->withFragment('user_' . $id);
        }

        $user = User::findOrFail($id);
        $originalEmail = $user->email;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'role' => $request->role,
        ]);

        // Automatically reset password if email changed
        $successMessage = 'Данные пользователя успешно обновлены';
        if ($originalEmail !== $request->email) {
            try {
                $password = $this->generateRandomPassword();
                $user->password = Hash::make($password);
                $user->save();
                $user->notify(new \App\Notifications\SendLoginDetails($user, $password));
                $successMessage .= ' и пароль сброшен. Новый пароль отправлен на ' . $user->email;
            } catch (\Exception $e) {
                return back()->withErrors(['user_' . $id => 'Ошибка при отправке нового пароля: ' . $e->getMessage()])
                            ->withFragment('user_' . $id);
            }
        }

        return redirect()->route('admin.users.index')
                        ->with('success_user_' . $id, $successMessage)
                        ->withFragment('user_' . $id);
    }

    public function resetPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $messages = [
            'email.required' => 'Почта обязательна для заполнения',
            'email.email' => 'Пожалуйста, введите корректный адрес электронной почты',
        ];

        // Validate email
        try {
            Validator::make(['email' => $user->email], [
                'email' => ['required', 'email'],
            ], $messages)->validate();

            $password = $this->generateRandomPassword();
            $user->password = Hash::make($password);
            $user->save();
            $user->notify(new \App\Notifications\SendLoginDetails($user, $password));

            return redirect()->route('admin.users.index')
                            ->with('success_user_' . $id, 'Пароль успешно сброшен! Новый пароль отправлен на ' . $user->email)
                            ->withFragment('user_' . $id);
        } catch (\Exception $e) {
            return back()->withErrors(['user_' . $id => 'Ошибка при сбросе пароля: ' . $e->getMessage()])
                        ->withFragment('user_' . $id);
        }
    }

    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $userId = $student->user_id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'birthdate' => 'nullable|date|before:today',
        ], [
            'name.required' => 'ФИО ученика обязательно для заполнения',
            'birthdate.date' => 'Введите корректную дату рождения',
            'birthdate.before' => 'Дата рождения должна быть раньше сегодняшнего дня',
        ]);

        if ($validator->fails()) {
            return back()->withErrors(['student_' . $id => $validator->errors()->first()])
                        ->withFragment('user_' . $userId);
        }

        $student->update([
            'name' => $request->name,
            'birthdate' => $request->birthdate ? Carbon::parse($request->birthdate)->format('Y-m-d') : null,
        ]);

        return redirect()->route('admin.users.index')
                        ->with('success_student_' . $id, 'Данные ученика успешно обновлены')
                        ->withFragment('user_' . $userId);
    }

    protected function generateRandomPassword($length = 10)
    {
        return Str::random($length);
    }
}