<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceRequestController;
use App\Http\Controllers\ChangeShiftRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FaceEnrollmentController;
use App\Http\Controllers\OffTimeController;
use App\Http\Controllers\OffTimeRequestController;
use App\Http\Controllers\OffTimeTypeController;
use App\Http\Controllers\OvertimeRequestController;
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

    // Off Time Types (Categories)
    Route::get('/off-time-types', [OffTimeTypeController::class, 'index'])
        ->name('off-time-types.index');
    Route::post('/off-time-types', [OffTimeTypeController::class, 'store'])
        ->name('off-time-types.store');
    Route::put('/off-time-types/{offTimeType}', [OffTimeTypeController::class, 'update'])
        ->name('off-time-types.update');
    Route::delete('/off-time-types/{offTimeType}', [OffTimeTypeController::class, 'destroy'])
        ->name('off-time-types.destroy');
    Route::patch('/off-time-types/{offTimeType}/toggle-status', [OffTimeTypeController::class, 'toggleStatus'])
        ->name('off-time-types.toggle-status');

    // Off Times
    Route::get('/off-times', [OffTimeController::class, 'index'])
        ->name('off-times.index');
    Route::get('/off-times/create', [OffTimeController::class, 'create'])
        ->name('off-times.create');
    Route::post('/off-times', [OffTimeController::class, 'store'])
        ->name('off-times.store');
    Route::patch('/off-times/{offTime}/status', [OffTimeController::class, 'updateStatus'])
        ->name('off-times.update-status');
    Route::delete('/off-times/{offTime}', [OffTimeController::class, 'destroy'])
        ->name('off-times.destroy');

    // Attendances
    Route::get('/attendances', [AttendanceController::class, 'index'])
        ->name('attendances.index');
    Route::post('/attendances', [AttendanceController::class, 'store'])
        ->name('attendances.store');
    Route::put('/attendances/{attendance}', [AttendanceController::class, 'update'])
        ->name('attendances.update');
    Route::delete('/attendances/{attendance}', [AttendanceController::class, 'destroy'])
        ->name('attendances.destroy');

    // Attendance Reports
    Route::get('/reports/attendances', [AttendanceController::class, 'reports'])
        ->name('attendances.reports');

    // Form Requests: Off Time Requests
    Route::get('/off-time-requests', [OffTimeRequestController::class, 'index'])
        ->name('off-time-requests.index');
    Route::patch('/off-time-requests/{offTimeRequest}/status', [OffTimeRequestController::class, 'updateStatus'])
        ->name('off-time-requests.update-status');
    Route::delete('/off-time-requests/{offTimeRequest}', [OffTimeRequestController::class, 'destroy'])
        ->name('off-time-requests.destroy');

    // Form Requests: Attendance Requests
    Route::get('/attendance-requests', [AttendanceRequestController::class, 'index'])
        ->name('attendance-requests.index');
    Route::patch('/attendance-requests/{attendanceRequest}/status', [AttendanceRequestController::class, 'updateStatus'])
        ->name('attendance-requests.update-status');
    Route::delete('/attendance-requests/{attendanceRequest}', [AttendanceRequestController::class, 'destroy'])
        ->name('attendance-requests.destroy');

    // Form Requests: Change Shift Requests
    Route::get('/change-shift-requests', [ChangeShiftRequestController::class, 'index'])
        ->name('change-shift-requests.index');
    Route::patch('/change-shift-requests/{changeShiftRequest}/status', [ChangeShiftRequestController::class, 'updateStatus'])
        ->name('change-shift-requests.update-status');
    Route::delete('/change-shift-requests/{changeShiftRequest}', [ChangeShiftRequestController::class, 'destroy'])
        ->name('change-shift-requests.destroy');

    // Form Requests: Overtime Requests
    Route::get('/overtime-requests', [OvertimeRequestController::class, 'index'])
        ->name('overtime-requests.index');
    Route::patch('/overtime-requests/{overtimeRequest}/status', [OvertimeRequestController::class, 'updateStatus'])
        ->name('overtime-requests.update-status');
    Route::delete('/overtime-requests/{overtimeRequest}', [OvertimeRequestController::class, 'destroy'])
        ->name('overtime-requests.destroy');
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
