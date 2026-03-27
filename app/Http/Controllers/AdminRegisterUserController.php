<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SendLoginDetails;
use Illuminate\Validation\Rule;
use App\Rules\ProperNameFormat;
use App\Rules\AgeLimit;

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
            'number.required' => 'Номер телефона обязателен для заполнения',
        ];
        
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'), // Проверка на уникальность почты в таблице users
            ],
            'name' => ['required', new ProperNameFormat],
            'number'=> 'required',
            'idAplication' => 'nullable|exists:applications,id',
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

        // Если idAplication передан, обновляем статус заявки и данные
        if ($request->has('idAplication')) {
            $application = Application::find($request->input('idAplication'));
            if ($application) {
                $application->status = 'Пользователь создан';
                $application->user_id = $user->id;
                $application->email = $request->email; // Обновляем email в заявке
                $application->name = $request->name; // Обновляем имя в заявке
                $application->number = $request->number; // Обновляем номер в заявке
                // Принудительно обновляем время изменения через update()
                $application->update(['updated_at' => now()]);
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
