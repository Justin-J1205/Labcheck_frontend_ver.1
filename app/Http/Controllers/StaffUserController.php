<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StaffUserController extends Controller
{
    /**
     * Remove a student from the system (Staff/Admin only)
     */
    public function destroy(User $user)
    {
        if (Auth::user()->role !== 'staff' && Auth::user()->role !== 'admin') {
            abort(403, 'Only lab staff can remove users.');
        }

        $user->delete();
        return redirect()->back()->with('success', 'Student removed successfully.');
    }
}
