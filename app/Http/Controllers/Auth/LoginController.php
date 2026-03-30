<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    function submitLogin(LoginFormRequest $request)
    {
        $user = User::where('email', $request->login)->first();
        if (!$user){
            return back()->withErrors(['password' => 'Неврная почта'])->withInput();
        }
        else if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('showeHome')->with('login', 'Вы успешно вошли!');
        } else {
            return back()->withErrors(['password' => 'Неверный пароль.'])->withInput();
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect()->route('auth.showeLogin');
    }
}
