<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aplication;
use App\Models\User;

class ControllerAplication extends Controller
{
    function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'number' => 'required'
        ]);
        Aplication::create([
            'name'=>$request['name'], 
            'email'=>$request['email'], 
            'number'=>$request['number']]
        );
        return redirect()->route('showeHome')->with('form', 'Заявка успешно отправлена!')->withFragment('home__form');
    }
}
