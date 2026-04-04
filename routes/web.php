<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Equipment;
use App\Http\Controllers\ChemicalController;
use App\Models\Chemical;
use App\Models\Experiment;
use App\Models\Announcement;



// --- 1. AUTHENTICATION ---
Route::get('/', fn() => view('welcome'));
Route::get('/login', fn() => view('Authentication.login'))->name('login');
Route::post('/login', function (Request $request) {
    $credentials = $request->validate(['email' => 'required|email', 'password' => 'required']);
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }
    return back()->withErrors(['email' => 'Invalid credentials.']);
});
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// --- 2. PROTECTED ROUTES ---
Route::middleware(['auth'])->group(function () {

    // DASHBOARD
    Route::get('/dashboard', function () {
        $availableCount = Equipment::where('status', 'available')->count();
        $inUseCount = Equipment::whereIn('status', ['maintenance', 'occupied'])->count();
        $experiments = Experiment::all();
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        $schedules = DB::table('schedules')->where('user_id', Auth::id())->get();

        return view('dashboard', compact('availableCount', 'inUseCount', 'experiments', 'announcements', 'schedules'));
    })->name('dashboard');

    // ANNOUNCEMENTS
    Route::post('/announcements', function (Request $request) {
        $request->validate(['title' => 'required', 'content' => 'required', 'target' => 'required']);
        Announcement::create(['title' => $request->title, 'content' => $request->content, 'target' => $request->target, 'user_id' => Auth::id()]);
        return redirect()->back();
    })->name('announcements.store');

    Route::delete('/announcements/{announcement}', function (Announcement $announcement) {
        if (Auth::user()->role === 'student') abort(403);
        $announcement->delete();
        return redirect()->back();
    })->name('announcements.destroy');

    // EXPERIMENTS
    Route::get('/experiments', fn() => view('experiments.index', ['experiments' => Experiment::all()]))->name('experiments.index');
    Route::get('/experiments/create', fn() => Auth::user()->role === 'student' ? abort(403) : view('experiments.create'))->name('experiments.create');
    Route::get('/experiments/{experiment}', fn(Experiment $experiment) => view('experiments.show', compact('experiment')))->name('experiments.show');

    Route::post('/experiments', function (Request $request) {
        if (Auth::user()->role === 'student') abort(403);
        $validated = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'difficulty' => 'required',
            'duration_minutes' => 'required|integer',
            'description' => 'required'
        ]);
        Experiment::create($validated);
        return redirect()->route('experiments.index');
    })->name('experiments.store');

    Route::delete('/experiments/{experiment}', function (Experiment $experiment) {
        if (Auth::user()->role === 'student') abort(403);
        $experiment->delete();
        return redirect()->route('experiments.index');
    })->name('experiments.destroy');

    Route::post('/experiments/{experiment}/join', function (Experiment $experiment) {
        if (Auth::user()->role !== 'student') return back();
        DB::table('schedules')->insert([
            'user_id' => Auth::id(),
            'title' => '🔬 ' . $experiment->title,
            'description' => $experiment->category,
            'scheduled_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return redirect()->route('dashboard');
    })->name('experiments.join');
    // EQUIPMENTS

    Route::get('/equipment/create', function () {
        return view('Equipments.create'); // Make sure this folder/file exists!
    })->name('equipment.create');
    Route::patch('/catalog/{chemical}/toggle', [ChemicalController::class, 'toggle'])->name('catalog.toggle');
    Route::get('/equipment', function () {
        $equipments = Equipment::all(); // Added the 's'
        return view('Equipments.index', compact('equipments')); // Added the 's'
    })->name('equipment.index');

    // CATALOG
    Route::patch('/catalog/{chemical}/toggle', [ChemicalController::class, 'toggleStatus'])->name('catalog.toggle');
    Route::get('/catalog', [ChemicalController::class, 'index'])->name('catalog.index');
    Route::get('/catalog/create', [ChemicalController::class, 'create'])->name('catalog.create');
    Route::post('/catalog/store', [ChemicalController::class, 'store'])->name('catalog.store');
    Route::delete('/catalog/{chemical}', [ChemicalController::class, 'destroy'])->name('catalog.destroy');
});
