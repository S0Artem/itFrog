<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AdminApplicationController extends Controller
{
    public function showeAdminApplication(Request $request)
    {
        $query = Application::query()->with(['branch', 'user']); // использует связи

        // Фильтрация по родителю
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->input('email') . '%');
        }
        if ($request->filled('number')) {
            $query->where('number', 'like', '%' . $request->input('number') . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        } else {
            // По умолчанию скрываем готовые заявки и отказы, если не запрошены явно
            if (!$request->filled('show_ready')) {
                $query->whereNotIn('status', ['Готовая', 'Отказ']);
            }
        }
        if ($request->filled('age')) {
            $targetAge = (int) $request->input('age');
            $query->whereRaw('TIMESTAMPDIFF(YEAR, student_birth_date, CURDATE()) = ?', [$targetAge]);
        }
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->input('branch_id'));
        }
        $applications = $query->orderBy('created_at', 'desc')->get();
        foreach ($applications as $application) {
            if ($application->student_birth_date) {
                $age = Carbon::parse($application->student_birth_date)->diff(now());
                $application->age_text = $age->y . ' года ' . $age->m . ' месяцев';
            } else {
                $application->age_text = 'нет информации';
            }
        }

        $users = \App\Models\User::where('role', 'user')->get();
        return view('admin.adminAplication.aplication', compact('applications', 'users'));
    }


    public function applicationChange(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Новая,В работе,Отказ,Обработана,Пользователь создан,Готовая',
            'user_id' => 'required_if:status,Пользователь создан|nullable|exists:users,id',
        ], [
            'user_id.required_if' => 'Выберите пользователя для заявки',
        ]);

        $application = Application::findOrFail($id);
        if ($application->status === 'Готовая') {
            return back()->withErrors([
                'application_' . $id => 'Невозможно изменить готовую заявку'
            ])->withFragment('application_' . $id);
        }

        if ($application->status === 'Пользователь создан' && $request->input('status') !== 'Пользователь создан') {
            return back()->withErrors([
                'application_' . $id => 'Невозможно изменить статус заявки, по которой был создан пользователь'
            ])->withFragment('application_' . $id);
        }

        $oldStatus = $application->status;
        $application->status = $request->input('status');
        
        if ($request->input('status') === 'Пользователь создан' && $request->input('user_id')) {
            $application->user_id = $request->input('user_id');
            
            // Обновляем данные заявки из выбранного пользователя
            $user = \App\Models\User::find($request->input('user_id'));
            if ($user) {
                $application->name = $user->name;
                $application->email = $user->email;
                $application->number = $user->number;
            }
        }
        
        // Принудительно обновляем время изменения через update()
        $application->update(['updated_at' => now()]);

        return redirect()->route('showeAdminApplication')
            ->with('success_' . $id, 'Статус заявки успешно обновлен')
            ->with('success_id', $id)
            ->with('scroll_to_id', $id) // Добавляем флаг для автоматического перехода
            ->withFragment('application_' . $id);
    }

    public function deleteApplication($id)
    {
        $application = Application::findOrFail($id);
        
        // Проверяем, что заявка имеет статус "Отказ"
        if ($application->status !== 'Отказ') {
            return back()->withErrors([
                'application_' . $id => 'Можно удалять только заявки со статусом "Отказ"'
            ])->withFragment('application_' . $id);
        }

        $application->delete();

        return redirect()->route('showeAdminApplication')
            ->with('success', 'Заявка успешно удалена')
            ->with('deleted_id', $id);
    }
}
