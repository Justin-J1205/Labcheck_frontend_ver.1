<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Fetch counts for stat cards
        $availableCount = Equipment::where('is_available', true)->count();
        $inUseCount = Equipment::where('is_available', false)->count();

        // 2. Fetch recent announcements
        $announcements = Announcement::latest()->get();

        // 3. Fetch Student's joined experiments
        $myExperiments = collect();
        if ($user && $user->role === 'student') {
            $myExperiments = $user->experiments;
        }

        // 4. Send all data to the dashboard view in ONE return
        return view('dashboard', compact(
            'availableCount',
            'inUseCount',
            'announcements',
            'myExperiments'
        ));
    }
}
