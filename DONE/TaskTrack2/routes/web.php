<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    RegisterController,
    DashboardController,
    ProjectController,
    TaskController,
    SubtaskController,
    SubtaskAttachmentController,
    ProjectMemberController
};

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| REGISTER
|--------------------------------------------------------------------------
*/

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

/*
|--------------------------------------------------------------------------
| AUTH MIDDLEWARE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PROJECTS
    |--------------------------------------------------------------------------
    */
    Route::resource('projects', ProjectController::class);

    /*
    |--------------------------------------------------------------------------
    | PROJECT MEMBERS
    |--------------------------------------------------------------------------
    */
    Route::post('projects/{project}/members', [ProjectMemberController::class, 'store'])
        ->name('projects.members.store');

    /*
    |--------------------------------------------------------------------------
    | TASKS
    |--------------------------------------------------------------------------
    */

    // Create task
    Route::post('projects/{project}/tasks', [TaskController::class, 'store'])
        ->name('projects.tasks.store');

    // Edit task page  ✅ FIXED NAME EXISTS HERE
    Route::get('projects/{project}/tasks/{task}/edit', [TaskController::class, 'edit'])
        ->name('projects.edit_tasks');

    // Update task
    Route::put('projects/{project}/tasks/{task}', [TaskController::class, 'update'])
        ->name('projects.tasks.update');

    // Delete task
    Route::delete('projects/{project}/tasks/{task}', [TaskController::class, 'destroy'])
        ->name('tasks.destroy');

    /*
    |--------------------------------------------------------------------------
    | SUBTASKS
    |--------------------------------------------------------------------------
    */

    Route::post('tasks/{task}/subtasks', [SubtaskController::class, 'store'])
        ->name('tasks.subtasks.store');

    Route::put('tasks/{task}/subtasks/{subtask}', [SubtaskController::class, 'update'])
        ->name('tasks.subtasks.update');

    Route::delete('tasks/{task}/subtasks/{subtask}', [SubtaskController::class, 'destroy'])
        ->name('tasks.subtasks.destroy');

    /*
    |--------------------------------------------------------------------------
    | SUBTASK ATTACHMENTS
    |--------------------------------------------------------------------------
    */

    Route::post('subtasks/{subtask}/attachments', [SubtaskAttachmentController::class, 'store'])
        ->name('subtasks.attachments.store');

    Route::delete('subtask-attachments/{attachment}', [SubtaskAttachmentController::class, 'destroy'])
        ->name('subtasks.attachments.destroy');
});