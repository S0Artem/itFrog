<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerHome;
use App\Http\Controllers\ControllerLogin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ControllerProfil;
use App\Http\Controllers\ControllerAdmin;
use App\Http\Controllers\ControllerAplication;


Route::get('/', [ControllerHome::class, 'showeHome'])->name('showeHome');
Route::get('/login', [ControllerLogin::class, 'showeLogin'])->name('showeLogin');
Route::post('/login',[ControllerLogin::class, 'submitLogin'])->name('submitLogin');
Route::post('/aplication', [ControllerAplication::class, 'store'])->name('aplication.store');
Route::get('/logout', function(){
    Auth::logout();
    return back();
})->name('logout');
Route::get('/profil', [ControllerProfil::class, 'showeProfil'])->name('showeProfil');
Route::get('/profil/admin/potfolio', [ControllerAdmin::class, 'showeAdminPortfolio'])->name('showeAdminPortfolio');
Route::put('/profil/admin/potfolio/change', [ControllerAdmin::class, 'studentProgectChange'])->name('studentProgectChange');
Route::get('/profil/admin/aplication', [ControllerAdmin::class, 'showeAdminAplication'])->name('showeAdminAplication');
Route::put('/admin/aplications/{id}/change', [ControllerAdmin::class, 'aplicationChange'])->name('aplicationChange');