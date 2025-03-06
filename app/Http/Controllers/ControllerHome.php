<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use Illuminate\Http\Request;

class ControllerHome extends Controller
{
    function showeHome(){
        $directions = Direction::with('moduls')->get();

        // Добавляем подсчёт общего количества курсов (модулей) и уроков
        $directions = $directions->map(function ($direction) {
            //колл модулей
            $direction->modules_count = $direction->moduls->count();
            //колл уроков
            $direction->total_lessons = $direction->moduls->sum('lesson');
            //ввыод 3 курсов
            $direction->moduls_to_display = $direction->moduls->random(3);

            return $direction;
        });
        return view('home.home', compact('directions'));
    }
}
