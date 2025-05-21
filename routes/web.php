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
use App\Http\Controllers\AdminRegisterStudentController;
use App\Http\Controllers\SheduleController;
use App\Http\Controllers\GroupInfoController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\CashPaymenеController;
use App\Http\Controllers\PaymentController;


Route::get('/', [HomeController::class, 'showeHome'])->name('showeHome');
Route::get('/login', [LoginController::class, 'showeLogin'])->name('showeLogin');
Route::post('/login',[LoginController::class, 'submitLogin'])->name('submitLogin');
Route::post('/aplication', [AplicationController::class, 'store'])->name('aplication.store');
Route::get('/logout', function(){
    Auth::logout();
    return redirect()->route('showeLogin');
})->name('logout');
Route::get('/admin/potfolio', [AdminPortfolioController::class, 'showeAdminPortfolio'])->name('showeAdminPortfolio')->middleware('role:admin');
Route::get('/admin/potfolio/studentsSearch', [AdminPortfolioController::class, 'studentsSearch'])->name('students.search')->middleware('role:admin');
Route::put('/admin/potfolio/change', [AdminPortfolioController::class, 'studentProgectChange'])->name('studentProgectChange')->middleware('role:admin');
Route::get('/admin/aplication', [AdminAplicationController::class, 'showeAdminAplication'])->name('showeAdminAplication')->middleware('role:admin');
Route::PATCH('/admin/aplications/{id}/change', [AdminAplicationController::class, 'aplicationChange'])->name('aplicationChange')->middleware('role:admin');
Route::get('/admin/register/user', [AdminRegisterUserController::class, 'showeAdminRegister'])->name('showeRegisterUser')->middleware('role:admin');
Route::post('/admin/register/user/reg',[AdminRegisterUserController::class, 'submitRegister'])->name('submitRegisterUser')->middleware('role:admin');
Route::get('/admin/register/employee', [AdminRegisterEmployeeController::class, 'showeAdminRegister'])->name('showeRegisterEmployee')->middleware('role:admin');
Route::post('/admin/register/employee/reg',[AdminRegisterEmployeeController::class, 'submitRegister'])->name('submitRegisterEmployee')->middleware('role:admin');
Route::get('/admin/register/student', [AdminRegisterStudentController::class, 'showe'])->name('showeRegisterStudent')->middleware('role:admin');
Route::post('/admin/register/student/reg', [AdminRegisterStudentController::class, 'submitRegister'])->name('submitRegisterStudent')->middleware('role:admin');
Route::get('/admin/shedule', [SheduleController::class, 'showe'])->name('showeShedule')->middleware('role:admin,teacher');
Route::post('/admin/shedule', [SheduleController::class, 'submit'])->name('submitShedule')->middleware('role:admin,teacher');
Route::get('/admin/shedule/group/{group}', [GroupInfoController::class, 'show'])->name('group.show')->middleware('role:admin,teacher');
Route::get('/admin/sheduleTeacher', [SheduleController::class, 'showeTeacher'])->name('showeSheduleTeacher')->middleware('role:admin,teacher');
Route::get('/profil', [ProfilController::class, 'showe'])->name('showeProfil')->middleware('role:admin,teacher,user');//
Route::post('/payment/create', [PaymentController::class, 'create'])->name('payment.create')->middleware('role:user');
Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback')->middleware('role:user');
Route::get('/cashPaymen', [CashPaymenеController::class, 'showe'])->name('cashPaymen.showe')->middleware('role:admin,teacher');
Route::post('/cashPaymen/create', [CashPaymenеController::class, 'submit'])->name('submitCashPaymen')->middleware('role:admin,teacher');
Route::get('/resetPassword', [AdminRegisterUserController::class, 'resetShowe'])->name('resetShowe');
Route::post('/resetPassword/reset', [AdminRegisterUserController::class, 'resetUser'])->name('resetUser');