<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerHome;
use App\Http\Controllers\ControllerLogin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ControllerAdmin;
use App\Http\Controllers\ControllerAplication;
use App\Http\Controllers\ControllerRegister;


Route::get('/', [ControllerHome::class, 'showeHome'])->name('showeHome');
Route::get('/login', [ControllerLogin::class, 'showeLogin'])->name('showeLogin');
Route::post('/login',[ControllerLogin::class, 'submitLogin'])->name('submitLogin');
Route::post('/aplication', [ControllerAplication::class, 'store'])->name('aplication.store');
Route::get('/logout', function(){
    Auth::logout();
    return redirect()->route('showeLogin');
})->name('logout');
Route::get('/admin/potfolio', [ControllerAdmin::class, 'showeAdminPortfolio'])->name('showeAdminPortfolio');
Route::put('/admin/potfolio/change', [ControllerAdmin::class, 'studentProgectChange'])->name('studentProgectChange');
Route::get('/admin/aplication', [ControllerAdmin::class, 'showeAdminAplication'])->name('showeAdminAplication');
Route::put('/admin/aplications/{id}/change', [ControllerAdmin::class, 'aplicationChange'])->name('aplicationChange');
Route::get('/admin/register', [ControllerRegister::class, 'showeAdminRegister'])->name('showeAdminRegister');
Route::post('/admin/register/reg',[ControllerRegister::class, 'submitRegister'])->name('submitRegister');