<?php
// Basic web routes (place these into your Laravel project's routes/web.php)
use App\Http\Controllers\AdvanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LabourController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MaterialTypeController;
use App\Http\Controllers\LabourTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Add these with your other auth routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('projects', ProjectController::class);
    Route::resource('materials', MaterialController::class);
    Route::resource('materialtypes', MaterialTypeController::class);
    Route::resource('labourtypes', LabourTypeController::class);
    
    Route::resource('labours', LabourController::class)->names([
        'show' => 'labours.view'
    ]);
    Route::delete('labours/attachments/{attachment}', [LabourController::class, 'destroyAttachment'])->name('labours.attachments.destroy');
    Route::resource('advances', AdvanceController::class);

    Route::get('reports/summary', [ReportController::class, 'projectSummary'])->name('reports.summary');
    Route::get('reports/material-wise', [ReportController::class, 'materialWise'])->name('reports.materialWise');
    Route::get('reports/daily', [ReportController::class, 'daily'])->name('reports.daily');
    Route::get('reports/advance-vs-expense', [ReportController::class, 'advanceVsExpense'])->name('reports.advanceVsExpense');
    Route::get('attachments', [ReportController::class, 'attachments'])->name('reports.attachments');
    
    // Profile routes
    Route::get('/profile', [AuthController::class, 'view'])->name('profile.view');
    Route::get('/profile/edit', [AuthController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [AuthController::class, 'update'])->name('profile.update');
    
    // User management routes (admin only)
    Route::middleware(['admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
});
