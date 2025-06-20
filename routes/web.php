<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\NiveauController;
use App\Http\Controllers\ExerciceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserExerciseAttemptController;

Route::get('/', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
// Route::middleware(['admin'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    //User Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    // ✅ Niveaux Routes
    Route::get('/niveaux', [NiveauController::class, 'index'])->name('niveaux.index');
    Route::get('/niveaux/create', [NiveauController::class, 'create'])->name('niveaux.create');
    Route::post('/niveaux', [NiveauController::class, 'store'])->name('niveaux.store');
    Route::get('/niveaux/{niveau}/edit', [NiveauController::class, 'edit'])->name('niveaux.edit');
    Route::put('/niveaux/{niveau}', [NiveauController::class, 'update'])->name('niveaux.update');
    Route::delete('/niveaux/{niveau}', [NiveauController::class, 'destroy'])->name('niveaux.destroy');

    // Route exercices
    Route::get('/exercices', [ExerciceController::class, 'index'])->name('exercices.index');
    Route::get('/exercices/create', [ExerciceController::class, 'create'])->name('exercices.create');
    Route::post('/exercices', [ExerciceController::class, 'store'])->name('exercices.store');
    Route::get('/exercices/niveau', [ExerciceController::class, 'byNiveau'])->name('exercices.byNiveau');
    Route::get('/exercices/{exercice}', [ExerciceController::class, 'show'])->name('exercices.show');
    Route::get('/exercices/{exercice}/edit', [ExerciceController::class, 'edit'])->name('exercices.edit');
    Route::put('/exercices/{exercice}', [ExerciceController::class, 'update'])->name('exercices.update');
    Route::delete('/exercices/{exercice}', [ExerciceController::class, 'destroy'])->name('exercices.destroy');
    // Route pour les tentatives d'exercice
    Route::get('/user-exercise-attempts', [UserExerciseAttemptController::class, 'index'])->name('userExerciseAttempts.index');         // List all
    Route::get('/user-exercise-attempts/create', [UserExerciseAttemptController::class, 'create'])->name('userExerciseAttempts.create'); // Show form to create
    Route::post('/user-exercise-attempts', [UserExerciseAttemptController::class, 'store'])->name('userExerciseAttempts.store');         // Save new
    Route::get('/user-exercise-attempts/{id}', [UserExerciseAttemptController::class, 'show'])->name('userExerciseAttempts.show');       // Show one
    Route::get('/user-exercise-attempts/{id}/edit', [UserExerciseAttemptController::class, 'edit'])->name('userExerciseAttempts.edit');  // Show form to edit
    Route::put('/user-exercise-attempts/{id}', [UserExerciseAttemptController::class, 'update'])->name('userExerciseAttempts.update');   // Update
    Route::delete('/user-exercise-attempts/{id}', [UserExerciseAttemptController::class, 'destroy'])->name('userExerciseAttempts.destroy'); // Delete
// });
// Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login'])->name('login.post');



// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Route::get('/', function () {
//     return view('welcome');
// });
