<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display all users (Admin only)
     */
    public function index()
    {
        if (Auth::user()->role !== 'staff' && Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized');
        }

        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        if (Auth::user()->role !== 'staff' && Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'staff' && Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'date_of_birth' => 'required|date',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:student,staff,admin'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    /**
     * Show the form for editing a user
     */
    public function edit(User $user)
    {
        if (Auth::user()->role !== 'staff' && Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized');
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update a user
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->role !== 'staff' && Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'date_of_birth' => 'required|date',
            'role' => 'required|in:student,staff,admin',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Delete a user
     */
    public function destroy(User $user)
    {
        if (Auth::user()->role !== 'staff' && Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized');
        }

        // Prevent deleting self
        if (Auth::id() === $user->id) {
            return back()->with('error', 'You cannot delete yourself!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}
