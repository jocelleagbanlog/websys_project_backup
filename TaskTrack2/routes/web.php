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

// Redirect root to dashboard (will be protected by auth)
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('projects', ProjectController::class)->only(['create','store','show']);

    Route::post('projects/{project}/members', [ProjectMemberController::class, 'store'])
        ->name('projects.members.store');

    Route::post('projects/{project}/tasks', [TaskController::class, 'store'])
        ->name('projects.tasks.store');
    Route::put('projects/{project}/tasks/{task}', [TaskController::class, 'update'])
        ->name('projects.tasks.update');

    Route::post('tasks/{task}/subtasks', [SubtaskController::class, 'store'])
        ->name('tasks.subtasks.store');
    Route::put('tasks/{task}/subtasks/{subtask}', [SubtaskController::class, 'update'])
        ->name('tasks.subtasks.update');

    Route::post('subtasks/{subtask}/attachments', [SubtaskAttachmentController::class, 'store'])
        ->name('subtasks.attachments.store');
});

// IMPORTANT: remove this line – we are not using routes/auth.php anymore
// require __DIR__.'/auth.php';
