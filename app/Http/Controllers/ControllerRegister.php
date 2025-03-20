<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerRegister extends Controller
{
    function showeAdminRegister(){
        return view('adminRegister.register');
    }
}
