<?php

use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\LecturerController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudyProgramController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome');
})->name('home');

// Guest: login + reset password
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

    Route::get('/lupa-password', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/lupa-password', [PasswordResetController::class, 'sendEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'reset'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');
});

// Auth umum
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/superadmin', [DashboardController::class, 'superadmin'])
        ->middleware('role:superadmin')
        ->name('dashboard.superadmin');

    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
        ->middleware('role:superadmin,admin_academic')
        ->name('dashboard.admin');

    Route::get('/dashboard/dosen', [DashboardController::class, 'lecturer'])
        ->middleware('role:lecturer')
        ->name('dashboard.lecturer');

    Route::get('/dashboard/mahasiswa', [DashboardController::class, 'student'])
        ->middleware('role:student')
        ->name('dashboard.student');
});

// Master data akademik (admin saja)
Route::middleware(['auth', 'role:superadmin,admin_academic'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('faculties', FacultyController::class)->except(['destroy']);
    Route::post('faculties/{faculty}/toggle', [FacultyController::class, 'toggle'])->name('faculties.toggle');

    Route::resource('study-programs', StudyProgramController::class)->except(['destroy']);
    Route::post('study-programs/{study_program}/toggle', [StudyProgramController::class, 'toggle'])->name('study-programs.toggle');

    Route::resource('academic-years', AcademicYearController::class)->except(['destroy']);
    Route::post('academic-years/{academic_year}/toggle', [AcademicYearController::class, 'toggle'])->name('academic-years.toggle');

    Route::resource('semesters', SemesterController::class)->except(['destroy']);
    Route::post('semesters/{semester}/toggle', [SemesterController::class, 'toggle'])->name('semesters.toggle');

    Route::resource('courses', CourseController::class)->except(['destroy']);
    Route::post('courses/{course}/toggle', [CourseController::class, 'toggle'])->name('courses.toggle');

    Route::resource('rooms', RoomController::class)->except(['destroy']);
    Route::post('rooms/{room}/toggle', [RoomController::class, 'toggle'])->name('rooms.toggle');

    Route::resource('students', StudentController::class)->except(['destroy']);
    Route::post('students/{student}/toggle', [StudentController::class, 'toggle'])->name('students.toggle');

    Route::resource('lecturers', LecturerController::class)->except(['destroy']);
    Route::post('lecturers/{lecturer}/toggle', [LecturerController::class, 'toggle'])->name('lecturers.toggle');
});
