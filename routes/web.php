<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Tasks\TaskController as TaskController;

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

Route::middleware(['auth'])->group(function(){
    Route::any('/', [TaskController::class, 'index']);
    Route::any('/home', [TaskController::class, 'index']);
    Route::resource('tasks', TaskController::class);
});

Route::middleware(['guest'])->group(function(){
    Route::any('/login', function(){
        return view('auth.login');
    });
});



//Route::fallback(function () {
//    return view('errors.404');
//});



