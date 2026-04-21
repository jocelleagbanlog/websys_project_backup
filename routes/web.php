<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;


Route::get('/', function () {
    return redirect()->route('login');
});

/* REGISTER */
Route::get('/register',[UserController::class,'showRegister'])->name('register');
Route::post('/register',[UserController::class,'register'])->name('register.save');

/* LOGIN */
Route::get('/login',[UserController::class,'showLogin'])->name('login');
Route::post('/login',[UserController::class,'login'])->name('login.check');

/* LOGOUT */
Route::get('/logout',[UserController::class,'logout'])->name('logout');

/* TASKS */
Route::get('/tasks',[TaskController::class,'index'])->name('tasks.index');
Route::get('/tasks/create',[TaskController::class,'create'])->name('tasks.create');
Route::post('/tasks/store',[TaskController::class,'store'])->name('tasks.store');
Route::get('/tasks/edit/{id}',[TaskController::class,'edit'])->name('tasks.edit');
Route::post('/tasks/update/{id}',[TaskController::class,'update'])->name('tasks.update');
Route::get('/tasks/delete/{id}',[TaskController::class,'destroy'])->name('tasks.delete');

Route::get('/categories',[CategoryController::class,'index'])->name('categories.index');
Route::get('/categories/create',[CategoryController::class,'create'])->name('categories.create');
Route::post('/categories/store',[CategoryController::class,'store'])->name('categories.store');
Route::get('/categories/edit/{id}',[CategoryController::class,'edit'])->name('categories.edit');
Route::post('/categories/update/{id}',[CategoryController::class,'update'])->name('categories.update');
Route::get('/categories/delete/{id}',[CategoryController::class,'destroy'])->name('categories.delete');

Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\UserController;
// use App\Http\Controllers\TaskController;

// Route::get('/', function () {
//     return view('welcome');
// });

// /* REGISTER */

// Route::get('/register',[UserController::class,'showRegister'])->name('register');

// Route::post('/register',[UserController::class,'register'])->name('register.save');


// /* LOGIN */

// Route::get('/login',[UserController::class,'showLogin'])->name('login');

// Route::post('/login',[UserController::class,'login'])->name('login.check');


// /* LOGOUT */

// Route::get('/logout',[UserController::class,'logout'])->name('logout');


// /* TASKS */

// Route::get('/tasks',[TaskController::class,'index'])->name('tasks.index');

// Route::get('/tasks/create',[TaskController::class,'create'])->name('tasks.create');

// Route::post('/tasks/store',[TaskController::class,'store'])->name('tasks.store');

// Route::get('/tasks/edit/{id}',[TaskController::class,'edit'])->name('tasks.edit');

// Route::post('/tasks/update/{id}',[TaskController::class,'update'])->name('tasks.update');

// Route::get('/tasks/delete/{id}', [TaskController::class,'destroy'])->name('tasks.delete');
