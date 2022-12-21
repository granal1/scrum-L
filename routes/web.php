<?php

use App\Models\Tasks\Task;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Tasks\TaskController as TaskController;
use App\Http\Controllers\IndexController as IndexController;

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

Route::any('/', [TaskController::class, 'index']);

Route::resource('tasks', TaskController::class);


