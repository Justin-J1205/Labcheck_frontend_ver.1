<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Equipment;
use App\Models\Chemical;
use App\Models\Experiment;

// --- 1. HOME & AUTH ---
Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login', function () {
    return view('Authentication.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }
    return back()->withErrors(['email' => 'Invalid credentials.']);
});

// Register
Route::get('/register', function () {
    return view('Authentication.register');
})->name('register');

Route::post('/register', function (Request $request) {
    $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'date_of_birth' => 'required|date',
        'role' => 'required|in:student,admin,staff',
        'password' => 'required|min:8|confirmed',
    ]);

    $user = User::create([
        'full_name' => $request->full_name,
        'email' => $request->email,
        'date_of_birth' => $request->date_of_birth,
        'role' => $request->role,
        'password' => Hash::make($request->password),
    ]);

    Auth::login($user);
    return redirect('/dashboard');
});

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');


// --- 2. PROTECTED DASHBOARD & FEATURES ---
Route::middleware(['auth'])->group(function () {

    // Main Dashboard (The page in your screenshot)
    Route::get('/dashboard', function () {
        $availableCount = Equipment::where('status', 'available')->count();
        $inUseCount = Equipment::whereIn('status', ['maintenance', 'occupied'])->count();
        $experiments = Experiment::all();
        
        return view('dashboard', compact('availableCount', 'inUseCount', 'experiments'));
    })->name('dashboard');

    // Experiments Page
    Route::get('/experiments', function () {
        $experiments = Experiment::all();
        return view('experiments.index', compact('experiments'));
    })->name('experiments.index');

    // Catalog (Chemicals View)
    Route::get('/catalog', function (Request $request) {
        $query = Chemical::query()->with('stock');
        
        // Search functionality for the top-right search bar
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('formula', 'like', '%' . $request->search . '%');
        }

        $chemicals = $query->get();
        return view('catalog.index', compact('chemicals'));
    })->name('catalog.index');

    // --- STAFF ONLY FEATURES ---
    Route::get('/equipment-management', function () {
        if (Auth::user()->role === 'student') abort(403);
        $equipment = Equipment::all();
        return view('staff.equipment', compact('equipment'));
    });

    Route::get('/inventory-control', function () {
        if (Auth::user()->role === 'student') abort(403);
        $chemicals = Chemical::with('stock')->get();
        return view('staff.inventory', compact('chemicals'));
    });

    Route::get('/settings', function () {
        return view('settings');
    });
});