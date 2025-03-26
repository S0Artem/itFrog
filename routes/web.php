<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AplicationController;
use App\Http\Controllers\RegisterController;


Route::get('/', [HomeController::class, 'showeHome'])->name('showeHome');
Route::get('/login', [LoginController::class, 'showeLogin'])->name('showeLogin');
Route::post('/login',[LoginController::class, 'submitLogin'])->name('submitLogin');
Route::post('/aplication', [AplicationController::class, 'store'])->name('aplication.store');
Route::get('/logout', function(){
    Auth::logout();
    return redirect()->route('showeLogin');
})->name('logout');
Route::get('/admin/potfolio', [AdminController::class, 'showeAdminPortfolio'])->name('showeAdminPortfolio');
Route::put('/admin/potfolio/change', [AdminController::class, 'studentProgectChange'])->name('studentProgectChange');
Route::get('/admin/aplication', [AdminController::class, 'showeAdminAplication'])->name('showeAdminAplication');
Route::PATCH('/admin/aplications/{id}/change', [AdminController::class, 'aplicationChange'])->name('aplicationChange');
Route::get('/admin/register', [RegisterController::class, 'showeAdminRegister'])->name('showeAdminRegister');
Route::post('/admin/register/reg',[RegisterController::class, 'submitRegister'])->name('submitRegister');