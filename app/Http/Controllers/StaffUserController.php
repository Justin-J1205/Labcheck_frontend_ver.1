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

        $user->delete();
        return redirect()->back()->with('success', 'Student removed successfully.');
    }
}
