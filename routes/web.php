<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\View\HomeController;

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\View\AdminPortfolioController as AdminPortfolioControllerView;
use App\Http\Controllers\AdminPortfolioController;


use App\Http\Controllers\AdminRegisterUserController;
use App\Http\Controllers\Actions\ApplicationController;
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



// ==================== Home ====================
Route::get('/', [HomeController::class, 'showeHome'])->name('showeHome');
// ==================== Home ====================


// ==================== AUTH ====================
Route::middleware('guest')->name('auth.')->prefix('login')->group(function () {
    Route::get('/', function () {
        return view('auth.login.login');
    })->name('showeLogin');

    Route::post('/',[LoginController::class, 'submitLogin'])
        ->name('submitLogin');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');
});
// ==================== AUTH ====================


// ==================== Admin =====================
Route::prefix('admin')->group(function () {

    Route::middleware('role:admin')->group(function (){

        Route::get('/potfolio', [AdminPortfolioControllerView::class, 'showeAdminPortfolio'])
            ->name('showeAdminPortfolio');
        
        Route::get('/potfolio/studentsSearch', [AdminPortfolioController::class, 'studentsSearch'])
            ->name('students.search');

        Route::put('/potfolio/change', [AdminPortfolioController::class, 'studentProgectChange'])
            ->name('studentProgectChange');

        Route::get('/application', [AdminApplicationController::class, 'showeAdminApplication'])
            ->name('showeAdminApplication');

        Route::patch('/application/change/{id}', [AdminApplicationController::class, 'applicationChange'])
            ->name('applicationChange');

        Route::delete('/application/delete/{id}', [AdminApplicationController::class, 'deleteApplication'])
            ->name('deleteApplication');

        Route::get('/register/user', [AdminRegisterUserController::class, 'showeAdminRegister'])
            ->name('showeRegisterUser');

        Route::post('/register/user/reg',[AdminRegisterUserController::class, 'submitRegister'])
            ->name('submitRegisterUser');

        Route::get('/register/employee', [AdminRegisterEmployeeController::class, 'showeAdminRegister'])
            ->name('showeRegisterEmployee');

        Route::post('/register/employee/reg',[AdminRegisterEmployeeController::class, 'submitRegister'])
            ->name('submitRegisterEmployee');

        Route::get('/register/student', [AdminRegisterStudentController::class, 'showe'])
            ->name('showeRegisterStudent');

        Route::post('/register/student/reg', [AdminRegisterStudentController::class, 'submitRegister'])
            ->name('submitRegisterStudent');

        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('admin.users.index');

        Route::patch('/users/{id}', [AdminUserController::class, 'update'])
            ->name('admin.users.update');

        Route::post('/users/{id}/reset-password', [AdminUserController::class, 'resetPassword'])
            ->name('admin.users.reset-password');

        Route::patch('/students/{id}', [AdminUserController::class, 'updateStudent'])
            ->name('admin.students.update');

        Route::post('/shedule/group/{group}/add-student', [GroupInfoController::class, 'addStudent'])
            ->name('group.addStudent');
    });

    Route::middleware('role:admin,teacher')->group(function (){

        Route::get('/shedule', [SheduleController::class, 'showe'])
            ->name('showeShedule');

        Route::post('/shedule', [SheduleController::class, 'submit'])
            ->name('submitShedule');

        Route::get('/shedule/group/{group}', [GroupInfoController::class, 'show'])
            ->name('group.show');

        Route::post('/shedule/group/{group}/del', [GroupInfoController::class, 'delete'])
            ->name('group.show.delete');

        Route::post('/shedule/group/{group}/delGroop', [GroupInfoController::class, 'deleteGroop'])
            ->name('group.show.deleteGroop');

        Route::get('/sheduleTeacher', [SheduleController::class, 'showeTeacher'])
            ->name('showeSheduleTeacher');

    });

});
// ==================== Admin =====================


Route::post('/application', [ApplicationController::class, 'store'])->name('application.store');
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













// Тестовый маршрут для скачивания файла
Route::get('/test-download', function () {
    return response()->download(public_path('docs/privacy-policy.pdf'));
});