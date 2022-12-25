<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Tasks\TaskController as TaskController;
use App\Http\Controllers\Users\UserController as UserController;
use App\Http\Controllers\Documents\DocumentController as DocumentController;
use App\Http\Controllers\Admin\AdminController as AdminController;

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

Route::middleware(['auth'])->group(function () {
    Route::controller(TaskController::class)
        ->group(function () {
            Route::any('/', 'index');
            Route::any('/home', 'index');
            Route::delete('tasks/task-file-destroy/{task}/{document}', 'task_file_destroy')->name('tasks.task-file-destroy');
            Route::post('tasks/create-subtask/{task}', 'create_subtask')->name('tasks.create-subtask');
        });
    Route::resources([
        'tasks' => TaskController::class,
        'users' => UserController::class,
        'documents' => DocumentController::class,
        'admin' => AdminController::class,
    ]);
});

Route::middleware(['guest'])->group(function () {
    Route::any('/login', function () {
        return view('auth.login');
    });
    Route::any('/', function () {
        return view('auth.login');
    });
});


Route::fallback(function () {
    return view('errors.404');
});
