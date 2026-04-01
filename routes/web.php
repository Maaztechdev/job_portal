<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SavedJobController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CategoryController;

// Public Routes
Route::get('/', [JobController::class, 'index'])->name('home');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Messaging Routes
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [MessageController::class, 'sendMessage'])->name('messages.send');
    Route::post('/messages/start/{receiver}', [MessageController::class, 'startConversation'])->name('messages.start');

    // Saved Jobs Routes
    Route::get('/saved-jobs', [SavedJobController::class, 'index'])->name('saved-jobs.index');
    Route::post('/saved-jobs/{job}', [SavedJobController::class, 'store'])->name('saved-jobs.store');
    Route::delete('/saved-jobs/{savedJob}', [SavedJobController::class, 'destroy'])->name('saved-jobs.destroy');

    // Company Routes
    Route::resource('companies', CompanyController::class)->except(['index', 'show']);

    // Category Routes (for admin)
    Route::resource('categories', CategoryController::class)->except(['index', 'show']);

    // Seeker Routes
    Route::middleware('role:seeker')->prefix('seeker')->name('seeker.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'seeker'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('jobs.apply');
    });

    // Employer Routes
    Route::middleware('role:employer')->prefix('employer')->name('employer.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'employer'])->name('dashboard');
        Route::resource('jobs', JobController::class)->except(['index', 'show']);
        Route::get('/jobs/{job}/applicants', [ApplicationController::class, 'viewApplicants'])->name('jobs.applicants');
        Route::post('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.status');
    });

    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
    });
});
