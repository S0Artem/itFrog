<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerProfil extends Controller
{
    function showeProfil(){
        return view('profil.profil');
    }
}
