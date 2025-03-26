<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminRegisterController;
use App\Http\Controllers\AplicationController;
use App\Http\Controllers\AdminPortfolioController;
use App\Http\Controllers\AdminAplicationController;



Route::get('/', [HomeController::class, 'showeHome'])->name('showeHome');
Route::get('/login', [LoginController::class, 'showeLogin'])->name('showeLogin');
Route::post('/login',[LoginController::class, 'submitLogin'])->name('submitLogin');
Route::post('/aplication', [AplicationController::class, 'store'])->name('aplication.store');
Route::get('/logout', function(){
    Auth::logout();
    return redirect()->route('showeLogin');
})->name('logout');
Route::get('/admin/potfolio', [AdminPortfolioController::class, 'showeAdminPortfolio'])->name('showeAdminPortfolio');
Route::put('/admin/potfolio/change', [AdminPortfolioController::class, 'studentProgectChange'])->name('studentProgectChange');
Route::get('/admin/aplication', [AdminAplicationController::class, 'showeAdminAplication'])->name('showeAdminAplication');
Route::PATCH('/admin/aplications/{id}/change', [AdminAplicationController::class, 'aplicationChange'])->name('aplicationChange');
Route::get('/admin/register', [AdminRegisterController::class, 'showeAdminRegister'])->name('showeAdminRegister');
Route::post('/admin/register/reg',[AdminRegisterController::class, 'submitRegister'])->name('submitRegister');