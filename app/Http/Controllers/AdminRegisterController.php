<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Aplication;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SendLoginDetails;
use Illuminate\Validation\Rule;

class AdminRegisterController extends Controller
{
    
    function showeAdminRegister(Request $request){
        $email = $request->query('email');
        $name = $request->query('name');
        $idAplication = $request->query('idAplication');

        return view('admin.adminRegister.register' , compact('email', 'name','idAplication'));
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
        ];
        
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'), // Проверка на уникальность почты в таблице users
            ],
            'name' => 'required',
            'idAplication' => 'nullable|exists:aplications,id',
        ], $messages);

        // Генерация уникального логина и пароля
        $password = $this->generateRandomPassword();

        // Создание пользователя
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($password),
        ]);

        // Если idAplication передан, обновляем статус заявки на "Созданный"
        if ($request->has('idAplication')) {
            $aplication = Aplication::find($request->input('idAplication'));
            if ($aplication) {
                $aplication->status = 'Созданная';
                $aplication->save();
            }
        }

        // Отправка уведомления с логином и паролем
        $user->notify(new SendLoginDetails($user, $password));

        return redirect()->route('showeAdminRegister')->with('register', 'Вы успешно зарегистрировали пользователя! Проверьте данные на ' . $user->email);
    }
}
