<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimeSheetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::get('reset-password', [UserController::class, 'resetPasswordForm']);
    Route::post('password-update', [UserController::class, 'passwordUpdate']);

    Route::resource('tasks', TaskController::class);
    Route::post('changeTaskStatus', [TaskController::class, 'changeTaskStatus'])->name('changeTaskStatus');



    ################## Start:: Admin #################
    Route::group(['middleware' => ['isAdmin']], function () {
        Route::get('users', [UserController::class, 'userLists']);
        Route::post('users', [UserController::class, 'userLists']);
        Route::post('changeUserStatus', [UserController::class, 'changeUserStatus'])->name('changeUserStatus');
        Route::delete('user-delete/{id}', [UserController::class, 'userDelete'])->name('user.delete');

        ### Start: TimeSheet
        Route::get('timesheet', [TimeSheetController::class, 'index'])->name('timesheet.index');
        Route::get('timesheet/create', [TimeSheetController::class, 'create'])->name('timesheet.create');
        Route::post('timesheet/store', [TimeSheetController::class, 'store'])->name('timesheet.store');
        Route::get('timesheet/store/{id}/edit/', [TimeSheetController::class, 'edit'])->name('timesheet.edit');
        Route::put('timesheet/store/update/{id}', [TimeSheetController::class, 'update'])->name('timesheet.update');
        Route::delete('timesheet/delete/{id}', [TimeSheetController::class, 'delete'])->name('timesheet.delete');
        ### End: TimeSheet

    });
    ################## End:: Admin #################
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
