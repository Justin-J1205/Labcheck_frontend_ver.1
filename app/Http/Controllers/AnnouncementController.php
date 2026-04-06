<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * Store a newly created announcement in storage.
     */
    public function store(Request $request)
    {
        // 1. Security Check: Only Staff can post
        if (Auth::user()->role === 'student') {
            abort(403, 'Students cannot post announcements.');
        }

        // 2. Validation
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target' => 'required|in:all,student,staff',
        ]);

        // 3. Create with current User ID
        Announcement::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'target' => $validated['target'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Announcement posted successfully!');
    }

    /**
     * Remove the specified announcement from storage.
     */
    public function destroy(Announcement $announcement)
    {
        // Security check: Only staff can delete
        if (Auth::user()->role === 'student') {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $announcement->delete();

        return redirect()->back()->with('success', 'Announcement deleted!');
    }
}
