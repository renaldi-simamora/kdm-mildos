<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FaceEnrollmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShiftController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Employees
    Route::get('/employees', [EmployeeController::class, 'index'])
        ->name('employees.index');
    Route::post('/employees', [EmployeeController::class, 'store'])
        ->name('employees.store');

    // Face Enrollments
    Route::get('/face-enrollments', [FaceEnrollmentController::class, 'index'])
        ->name('face-enrollments.index');
    Route::patch('/face-enrollments/{enrollment}/status', [FaceEnrollmentController::class, 'updateStatus'])
        ->name('face-enrollments.update-status');

    // Shifts
    Route::get('/shifts', [ShiftController::class, 'index'])
        ->name('shifts.index');
    Route::post('/shifts', [ShiftController::class, 'store'])
        ->name('shifts.store');
    Route::put('/shifts/{shift}', [ShiftController::class, 'update'])
        ->name('shifts.update');
    Route::delete('/shifts/{shift}', [ShiftController::class, 'destroy'])
        ->name('shifts.destroy');
    Route::patch('/shifts/{shift}/status', [ShiftController::class, 'updateStatus'])
        ->name('shifts.update-status');
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
