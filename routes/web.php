<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ExperimentController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChemicalController;
use App\Http\Controllers\StaffUserController;
use App\Http\Controllers\BorrowRequestController;
use App\Http\Controllers\AdminUserController;

// --- 1. PUBLIC ROUTES ---
Route::get('/', fn() => view('welcome'));
Route::get('/login', fn() => view('Authentication.login'))->name('login');
Route::get('/register', fn() => view('Authentication.register'))->name('register');

// Authentication Logic
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- 2. PROTECTED ROUTES (AUTH) ---
Route::middleware(['auth'])->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ANNOUNCEMENTS

    Route::resource('announcements', AnnouncementController::class)->only(['store', 'destroy']);

    // EQUIPMENTS

    Route::resource('equipments', EquipmentController::class);

    // EXPERIMENTS

    Route::resource('experiments', ExperimentController::class);

    // CHEMICAL CATALOG

    Route::resource('catalog', ChemicalController::class);
    Route::patch('/catalog/{chemical}/toggle', [ChemicalController::class, 'toggleStatus'])->name('catalog.toggle');

    // BORROW REQUESTS (STUDENT: Request Material, ADMIN: Approve/Reject)
    Route::get('/borrow-requests', [BorrowRequestController::class, 'index'])->name('borrow-requests.index');
    Route::get('/borrow-requests/create', [BorrowRequestController::class, 'create'])->name('borrow-requests.create');
    Route::post('/borrow-requests', [BorrowRequestController::class, 'store'])->name('borrow-requests.store');
    Route::post('/borrow-requests/{borrowRequest}/approve', [BorrowRequestController::class, 'approve'])->name('borrow-requests.approve');
    Route::post('/borrow-requests/{borrowRequest}/reject', [BorrowRequestController::class, 'reject'])->name('borrow-requests.reject');
    Route::post('/borrow-requests/{borrowRequest}/return', [BorrowRequestController::class, 'return'])->name('borrow-requests.return');
    Route::get('/borrow-requests/history', [BorrowRequestController::class, 'history'])->name('borrow-requests.history');

    // ADMIN USERS MANAGEMENT
    Route::resource('admin/users', AdminUserController::class)->except(['show'])->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy'
    ]);

    // STUDENT JOIN AND LEAVE
    Route::post('/experiments/{experiment}/join', [ExperimentController::class, 'join'])->name('experiments.join');
    Route::delete('/experiments/{experiment}/leave', [ExperimentController::class, 'leave'])->name('experiments.leave');

    // REMOVES STUDENTS (STAFF/ADMIN ONLY)
    Route::delete('/staff/users/{user}', [StaffUserController::class, 'destroy'])->name('staff.users.destroy');
});
