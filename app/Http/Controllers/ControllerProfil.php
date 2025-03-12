<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerProfil extends Controller
{
    function showeProfil(){
        $user = Auth::user();
        if (!$user){
            return redirect()->route('showeHome');
        }
        else if ($user->role === 'admin') {
            return redirect()->route("showeAdmin");
        }
    return view('profil.profil');
    }
}
