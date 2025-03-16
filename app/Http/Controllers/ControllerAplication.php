<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aplication;

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
        return redirect()->route('showeHome');
    }

}
