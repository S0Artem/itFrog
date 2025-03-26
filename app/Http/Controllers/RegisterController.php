<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Aplication;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SendLoginDetails;

class RegisterController extends Controller
{
    
    function showeAdminRegister(Request $request){
        $email = $request->query('email');
        $name = $request->query('name');
        $idAplication = $request->query('idAplication');

        return view('adminRegister.register' , compact('email', 'name','idAplication'));
    }

    function generateUniqueLogin($name)
    {
        $login = Str::slug($name); // Преобразуем имя в логин
        $originalLogin = $login;
        $counter = 1;

        // Проверяем, существует ли уже такой логин в базе данных
        while (User::where('login', $login)->exists()) {
            $login = $originalLogin . $counter;
            $counter++;
        }

        return $login;
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
            'name.required' => 'Имя обязательно для заполнения',
        ];

        $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'idAplication' => 'nullable|exists:aplications,id', // idAplication не обязательно, но если есть, проверяем его существование
        ], $messages);

        // Генерация уникального логина и пароля
        $login = $this->generateUniqueLogin($request->name);
        $password = $this->generateRandomPassword();

        // Создание пользователя
        $user = User::create([
            'email' => $request->email,
            'login' => $login,
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
