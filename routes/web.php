<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerHome;
use App\Http\Controllers\ControllerLogin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ControllerProfil;
use App\Http\Controllers\ControllerAdmin;


Route::get('/', [ControllerHome::class, 'showeHome'])->name('showeHome');
Route::get('/login', [ControllerLogin::class, 'showeLogin'])->name('showeLogin');
Route::post('/login',[ControllerLogin::class, 'submitLogin'])->name('submitLogin');
Route::get('/logout', function(){
    Auth::logout();
    return back();
})->name('logout');
Route::get('/profil', [ControllerProfil::class, 'showeProfil'])->name('showeProfil');
Route::get('/profil/admin', [ControllerAdmin::class, 'showeAdmin'])->name('showeAdmin');
Route::put('/profil/admin', [ControllerAdmin::class, 'studentProgectChange'])->name('studentProgectChange');