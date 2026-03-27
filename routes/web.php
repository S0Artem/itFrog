<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\View\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminRegisterUserController;
use App\Http\Controllers\Actions\ApplicationController;
use App\Http\Controllers\AdminPortfolioController;
use App\Http\Controllers\AdminApplicationController;
use App\Http\Controllers\AdminRegisterEmployeeController;
use App\Http\Controllers\AdminRegisterStudentController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\SheduleController;
use App\Http\Controllers\GroupInfoController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TeacherPortfolioController;
use App\Http\Controllers\CreatePortfolio;
use App\Http\Controllers\DirectionController;


Route::get('/', [HomeController::class, 'showeHome'])->name('showeHome');
Route::get('/login', [LoginController::class, 'showeLogin'])->name('showeLogin');
Route::post('/login',[LoginController::class, 'submitLogin'])->name('submitLogin');
Route::post('/application', [ApplicationController::class, 'store'])->name('application.store');
Route::get('/logout', function(){
    Auth::logout();
    return redirect()->route('showeLogin');
})->name('logout');
Route::get('/admin/potfolio', [AdminPortfolioController::class, 'showeAdminPortfolio'])->name('showeAdminPortfolio')->middleware('role:admin');
Route::get('/admin/potfolio/studentsSearch', [AdminPortfolioController::class, 'studentsSearch'])->name('students.search')->middleware('role:admin');
Route::put('/admin/potfolio/change', [AdminPortfolioController::class, 'studentProgectChange'])->name('studentProgectChange')->middleware('role:admin');
Route::get('/admin/application', [AdminApplicationController::class, 'showeAdminApplication'])->name('showeAdminApplication')->middleware('role:admin');
Route::patch('/admin/application/change/{id}', [AdminApplicationController::class, 'applicationChange'])->name('applicationChange')->middleware('role:admin');
Route::delete('/admin/application/delete/{id}', [AdminApplicationController::class, 'deleteApplication'])->name('deleteApplication')->middleware('role:admin');
Route::get('/admin/register/user', [AdminRegisterUserController::class, 'showeAdminRegister'])->name('showeRegisterUser')->middleware('role:admin');
Route::post('/admin/register/user/reg',[AdminRegisterUserController::class, 'submitRegister'])->name('submitRegisterUser')->middleware('role:admin');
Route::get('/admin/register/employee', [AdminRegisterEmployeeController::class, 'showeAdminRegister'])->name('showeRegisterEmployee')->middleware('role:admin');
Route::post('/admin/register/employee/reg',[AdminRegisterEmployeeController::class, 'submitRegister'])->name('submitRegisterEmployee')->middleware('role:admin');
Route::get('/admin/register/student', [AdminRegisterStudentController::class, 'showe'])->name('showeRegisterStudent')->middleware('role:admin');
Route::post('/admin/register/student/reg', [AdminRegisterStudentController::class, 'submitRegister'])->name('submitRegisterStudent')->middleware('role:admin');
Route::get('/admin/shedule', [SheduleController::class, 'showe'])->name('showeShedule')->middleware('role:admin,teacher');
Route::post('/admin/shedule', [SheduleController::class, 'submit'])->name('submitShedule')->middleware('role:admin,teacher');
Route::get('/admin/shedule/group/{group}', [GroupInfoController::class, 'show'])->name('group.show')->middleware('role:admin,teacher');
Route::post('/admin/shedule/group/{group}/add-student', [GroupInfoController::class, 'addStudent'])->name('group.addStudent')->middleware('role:admin');
Route::post('/admin/shedule/group/{group}/del', [GroupInfoController::class, 'delete'])->name('group.show.delete')->middleware('role:admin,teacher');
Route::post('/admin/shedule/group/{group}/delGroop', [GroupInfoController::class, 'deleteGroop'])->name('group.show.deleteGroop')->middleware('role:admin,teacher');
Route::get('/admin/sheduleTeacher', [SheduleController::class, 'showeTeacher'])->name('showeSheduleTeacher')->middleware('role:admin,teacher');
Route::get('/profil', [ProfilController::class, 'showe'])->name('showeProfil')->middleware('role:admin,teacher,user');//
Route::post('/payment/create', [PaymentController::class, 'create'])->name('payment.create')->middleware('role:user');
Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback')->middleware('role:user');
Route::get('/resetPassword', [AdminRegisterUserController::class, 'resetShowe'])->name('resetShowe');
Route::post('/resetPassword/reset', [AdminRegisterUserController::class, 'resetUser'])->name('resetUser');
Route::get('/teacher/potfolio', [TeacherPortfolioController::class, 'showeTeacherPortfolio'])->name('showeTeacherPortfolio')->middleware('role:admin,teacher');
Route::get('/teacher/potfolio/studentsSearch', [TeacherPortfolioController::class, 'studentsSearch'])->name('students.teacher.search')->middleware('role:admin,teacher');
Route::put('/teacher/potfolio/change', [TeacherPortfolioController::class, 'studentProgectChange'])->name('studentTeacherProgectChange')->middleware('role:admin,teacher');

Route::get('/teacher/portfolio/create', [CreatePortfolio::class, 'showCreateStudentProjectForm'])->name('showCreateStudentProjectForm')->middleware('role:teacher');
Route::post('/teacher/portfolio/store', [CreatePortfolio::class, 'store'])->name('portfolio.store')->middleware('role:teacher');

Route::get('/direction/{id}', [DirectionController::class, 'show'])->name('direction.show');








Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index')->middleware('role:admin');
Route::patch('/admin/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update')->middleware('role:admin');
Route::post('/admin/users/{id}/reset-password', [AdminUserController::class, 'resetPassword'])->name('admin.users.reset-password')->middleware('role:admin');
Route::patch('/admin/students/{id}', [AdminUserController::class, 'updateStudent'])->name('admin.students.update')->middleware('role:admin');







// Тестовый маршрут для скачивания файла
Route::get('/test-download', function () {
    return response()->download(public_path('docs/privacy-policy.pdf'));
});