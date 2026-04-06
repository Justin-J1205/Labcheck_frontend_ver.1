<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffUserController extends Controller
{
    public function index()
    {
        // Only get students, we don't want staff deleting other staff here
        $students = User::where('role', 'student')->get();
        return response()->json($students);
    }

    public function destroy(User $user)
    {

        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();

        // Check if the person clicking 'Delete' is actually a staff member
        if (auth()->user()->role !== 'staff') {
            abort(403, 'Only lab staff can remove users.');
        }

        $user->delete();
        return redirect()->back()->with('success', 'Student removed successfully.');
    }
}
