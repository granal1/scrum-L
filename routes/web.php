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
use App\Http\Controllers\UserStatuses\UserStatusController as UserStatusController;
use App\Http\Controllers\OutgoingFiles\OutgoingFileController as OutgoingFileController;
use App\Http\Controllers\ArchiveDocuments\ArchiveDocumentController as ArchiveDocumentController;
use App\Http\Controllers\ArchiveOutgoingDocuments\ArchiveOutgoingDocumentController as ArchiveOutgoingDocumentController;
use App\Http\Controllers\PhoneBook\PhoneBookController;
use App\Http\Controllers\Logs\LogsController;

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
        'user_statuses' => UserStatusController::class,
        'outgoing_files' => OutgoingFileController::class,
        //'archive_documents' => ArchiveDocumentController::class,
        'logs' => LogsController::class,
    ]);

    Route::get('archive_documents/show/{document_id}', [ArchiveDocumentController::class, 'show'])->name('archive_documents.show');
    Route::get('archive_documents/edit/{document_id}', [ArchiveDocumentController::class, 'edit'])->name('archive_documents.edit');
    Route::get('archive_documents/index', [ArchiveDocumentController::class, 'index'])->name('archive_documents.index');
    Route::delete('archive_documents/destroy/{document_id}', [ArchiveDocumentController::class, 'destroy'])->name('archive_documents.destroy');
    Route::patch('archive_documents/update/{document_id}', [ArchiveDocumentController::class, 'update'])->name('archive_documents.update');

    Route::get('archive_outgoing_documents/show/{document_id}', [ArchiveOutgoingDocumentController::class, 'show'])->name('archive_outgoing_documents.show');
    Route::get('archive_outgoing_documents/edit/{document_id}', [ArchiveOutgoingDocumentController::class, 'edit'])->name('archive_outgoing_documents.edit');
    Route::get('archive_outgoing_documents/index', [ArchiveOutgoingDocumentController::class, 'index'])->name('archive_outgoing_documents.index');
    Route::delete('archive_outgoing_documents/destroy/{document_id}', [ArchiveOutgoingDocumentController::class, 'destroy'])->name('archive_outgoing_documents.destroy');
    Route::patch('archive_outgoing_documents/update/{document_id}', [ArchiveOutgoingDocumentController::class, 'update'])->name('archive_outgoing_documents.update');



    Route::get('documents/create-task/{document}', [DocumentController::class, 'create_task'])->name('documents.create_task');
    Route::get('show/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('edit/{user}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('update/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('phonebook', [PhoneBookController::class, 'index'])->name('phonebook.index');
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
