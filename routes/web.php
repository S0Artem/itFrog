<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminRegisterUserController;
use App\Http\Controllers\AplicationController;
use App\Http\Controllers\AdminPortfolioController;
use App\Http\Controllers\AdminAplicationController;
use App\Http\Controllers\AdminRegisterEmployeeController;


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
Route::get('/admin/register/user', [AdminRegisterUserController::class, 'showeAdminRegister'])->name('showeRegisterUser');
Route::post('/admin/register/user/reg',[AdminRegisterUserController::class, 'submitRegister'])->name('submitRegisterUser');
Route::get('/admin/register/employee', [AdminRegisterEmployeeController::class, 'showeAdminRegister'])->name('showeRegisterEmployee');
Route::post('/admin/register/employee/reg',[AdminRegisterEmployeeController::class, 'submitRegister'])->name('submitRegisterEmployee');