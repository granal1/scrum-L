<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Tasks\TaskController as TaskController;
use App\Http\Controllers\Users\UserController as UserController;
use App\Http\Controllers\Documents\DocumentController as DocumentController;
use App\Http\Controllers\Admin\AdminController as AdminController;
use App\Http\Controllers\Roles\RoleController as RoleController;
use App\Http\Controllers\Profile\ProfileController as ProfileController;
use App\Http\Controllers\Site\SiteController as SiteController;

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
            Route::delete('tasks/task-file-destroy/{task}/{document}', 'task_file_destroy')->name('tasks.task-file-destroy');
            Route::get('tasks/progress/{task}', 'progress')->name('tasks.progress');
            Route::patch('tasks/progress_update/{task}', 'progress_update')->name('tasks.progress_update');
            Route::post('tasks/create-subtask/{task}', 'create_subtask')->name('tasks.create-subtask');
        });
    Route::resources([
        'tasks' => TaskController::class,
        'users' => UserController::class,
        'documents' => DocumentController::class,
        'admin' => AdminController::class,
        'roles' => RoleController::class,
    ]);
    Route::get('documents/create-task/{document}', [DocumentController::class, 'create_task'])->name('documents.create_task');
    Route::get('show/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('edit/{user}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('update/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/', [SiteController::class, 'index'])->name('site.index');
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
