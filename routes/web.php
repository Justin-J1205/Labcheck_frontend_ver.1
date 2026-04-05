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
});
