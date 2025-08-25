<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SendLoginDetails;
use Illuminate\Validation\Rule;
use App\Models\Branch;
use App\Rules\ProperNameFormat;
use App\Rules\AgeLimit;

class AdminRegisterEmployeeController extends Controller
{
    function showeAdminRegister(){
        $branchs = Branch::all();
        return view('admin.adminRegister.employee.register', compact('branchs'));
    }

    function generateRandomPassword($length = 10)
    {
        return Str::random($length); // Генерируем случайный пароль
    }

    function submitRegister(Request $request)
    {
        $messages = [
            'email.required' => 'Почта обязательна для заполнения',
            'email.email' => 'Пожалуйста, введите корректный адрес электронной почты',
            'email.unique' => 'Пользователь с такой почтой уже зарегистрирован',
            'name.required' => 'Имя обязательно для заполнения',
            'number.required' => 'Номер обязательно для заполнения',
            'branch_id.required' => 'Филиал обязательно для заполнения',
            'birthdate.required' => 'Дата рождения обязательна для заполнения',
            'birthdate.date' => 'Пожалуйста, введите корректную дату',
        ];
        
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'), // Проверка на уникальность почты в таблице users
            ],
            'branch_id' => 'required',
            'name' => ['required', new ProperNameFormat],
            'number'=> 'required',
            'birthdate' => ['required', 'date', new AgeLimit(null, 120, 'user')],
        ], $messages);

        // Генерация уникального пароля
        $password = $this->generateRandomPassword();

        // Создание пользователя
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'number' => $request->number,
            'birthdate' => $request->birthdate,
            'role' => 'teacher',
            'password' => Hash::make($password),
        ]);
        
        $employee = Employee::create([
            'id' => $user->id,
            'branche_id' => $request->branch_id,
        ]);

        return redirect()->route('showeRegisterEmployee')->with('register', 'Вы успешно зарегистрировали пользователя! Проверьте данные на ' . $user->email);
    }
}
