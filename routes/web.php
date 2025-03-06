<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerHome;


Route::get('/', [ControllerHome::class, 'showeHome'])->name('showeHome');
