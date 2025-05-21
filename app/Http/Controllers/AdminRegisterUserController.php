<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Aplication;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SendLoginDetails;
use Illuminate\Validation\Rule;

class AdminRegisterUserController extends Controller
{
    
    function showeAdminRegister(Request $request){
        $email = $request->query('email');
        $name = $request->query('name');
        $number = $request->query('number');
        $idAplication = $request->query('idAplication');
    
        return view('admin.adminRegister.user.register', compact('email', 'name', 'idAplication', 'number'));
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
            'name.regex' => 'Введите полное ФИО (например, Софронов Артем Павлович)',
            'number.required' => 'Имя обязательно для заполнения',
        ];
        
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'), // Проверка на уникальность почты в таблице users
            ],
            'name' => ['required', 'regex:/^\s*\S+\s+\S+\s+\S+/u'],
            'number'=> 'required',
            'idAplication' => 'nullable|exists:aplications,id',
        ], $messages);

        // Генерация уникального логина и пароля
        $password = $this->generateRandomPassword();

        // Создание пользователя
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'number' => $request->number,
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

        return redirect()->route('showeRegisterUser')->with('register', 'Вы успешно зарегистрировали пользователя! Проверьте данные на ' . $user->email);
    }
    function resetShowe(){
        return view('auth.reset.reset');
    }
    function resetUser(Request $request){
        $messages = [
            'email.required' => 'Почта обязательна для заполнения',
            'email.email' => 'Пожалуйста, введите корректный адрес электронной почты',
            'email.exists' => 'Пользователь с такой почтой не найден',
        ];

        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::exists('users', 'email'),  // Проверяем наличие в таблице users по полю email
            ],
        ], $messages);
        $user = User::where('email', $request->email)->firstOrFail();
        $password = $this->generateRandomPassword();
        $user->password = Hash::make($password);
        $user->save();
        $user->notify(new SendLoginDetails($user, $password));
        return redirect()->route('showeLogin')->with('reset', 'Вы успешно изменили пароль! Проверьте данные на ' . $user->email);
    }
}
