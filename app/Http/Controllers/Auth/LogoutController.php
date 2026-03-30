<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * logout из системы
 *
 * @package App\Http\Controllers\Auth
 */
class LogoutController extends Controller
{
    /**
     * Метод logout из системы

     */
    function logout()
    {
        Auth::logout();
        return redirect()->route('auth.showeLogin');
    }
}