<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use App\Models\Branch;
use Illuminate\Http\Request;

class DirectionController extends Controller
{
    public function show($id)
    {
        $direction = Direction::with('moduls')->findOrFail($id);
        $branches = Branch::all();
        
        // Устанавливаем заголовок страницы
        view()->share('pageTitle', $direction->name . ' - itFrog');
        
        return view('directions.show', compact('direction', 'branches'));
    }
}
