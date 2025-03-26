<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ControllerLogin extends Controller
{
    function showeLogin()
    {
        return(view('login.login'));
    }
    function submitLogin(Request $request)
    {
        $messages = [
            'login.required' => 'Логин обязателен для заполнения',
            'password.required' => 'Пароль обязателен для заполнения'
        ];
        $request->validate([
            'login' => 'required',
            'password' => 'required'
        ], $messages);

        $user = User::where('login', $request->login)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('showeHome')->with('login', 'Вы успешно вошли!');
        } else {
            return back()->withErrors(['password' => 'Неверный пароль.'])->withInput();
        }
    }
}
