<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Announcement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Fetch counts for your stat cards
        $availableCount = Equipment::where('is_available', true)->count();
        $inUseCount = Equipment::where('is_available', false)->count();

        // 2. Fetch recent announcements
        $announcements = Announcement::latest()->get();

        // 3. Send all data to your dashboard view
        return view('dashboard', compact(
            'availableCount',
            'inUseCount',
            'announcements'
        ));
    }
}
