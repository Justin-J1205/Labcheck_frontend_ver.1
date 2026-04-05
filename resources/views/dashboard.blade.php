@extends('Layouts.app')

@section('content')
    {{-- Main Dashboard container with Alpine.js state for the modal --}}
    <div style="padding: 30px;" x-data="{ showModal: false }">

        {{-- Header: Displays greeting and the announcement trigger for staff --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h1 style="font-size: 28px; font-weight: 800; color: #1e293b; margin: 0;">Dashboard</h1>
                <p style="color: #64748b; margin: 5px 0 0 0;">Welcome back to Labcheck</p>
            </div>

            @if (Auth::user()->role !== 'student')
                {{-- Staff-only button to open the Alpine modal --}}
                <button @click="showModal = true"
                    style="background: #0d9488; color: white; padding: 12px 24px; border-radius: 12px; border: none; font-weight: 700; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(13, 148, 136, 0.2);">
                    + New Announcement
                </button>
            @endif
        </div>

        {{-- Stats Grid: Summarizes the current state of the Equipment inventory --}}
        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 40px;">
            {{-- Shows items that are ready for checkout --}}
            <div style="background: white; padding: 25px; border-radius: 20px; border: 1px solid #f1f5f9;">
                <span style="color: #64748b; font-size: 14px; font-weight: 600;">Available Equipment</span>
                <h2 style="font-size: 32px; margin: 10px 0 0 0; color: #0d9488;">{{ $availableCount }}</h2>
            </div>
            {{-- Shows items currently borrowed or in maintenance --}}
            <div style="background: white; padding: 25px; border-radius: 20px; border: 1px solid #f1f5f9;">
                <span style="color: #64748b; font-size: 14px; font-weight: 600;">Currently In Use</span>
                <h2 style="font-size: 32px; margin: 10px 0 0 0; color: #ef4444;">{{ $inUseCount }}</h2>
            </div>
        </div>

        {{-- Announcements List: Fetches the latest updates from the staff --}}
        <div style="background: white; border-radius: 24px; border: 1px solid #f1f5f9; padding: 30px;">
            <h3 style="margin-top: 0; margin-bottom: 20px; color: #1e293b;">Recent Announcements</h3>
            @forelse($announcements as $announcement)
                <div
                    style="padding: 20px; border-bottom: 1px solid #f8fafc; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h4 style="margin: 0; color: #334155;">{{ $announcement->title }}</h4>
                        <p style="margin: 5px 0 0 0; color: #64748b; font-size: 14px;">{{ $announcement->content }}</p>
                    </div>
                    {{-- Only staff can delete existing announcements --}}
                    @if (Auth::user()->role !== 'student')
                        <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                style="background: none; border: none; color: #ef4444; font-weight: 700; cursor: pointer; font-size: 12px;">DELETE</button>
                        </form>
                    @endif
                </div>
            @empty
                <p style="color: #94a3b8; text-align: center; padding: 20px;">No announcements yet.</p>
            @endforelse
        </div>

        {{-- THE ANNOUNCEMENT MODAL: Hidden by default via Alpine --}}
        <div x-show="showModal" x-cloak
            style="position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5); display: flex; align-items: center; justify-content: center; z-index: 50;">

            <div @click.away="showModal = false"
                style="background: white; width: 100%; max-width: 500px; border-radius: 24px; padding: 40px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
                <h2 style="margin-top: 0; margin-bottom: 25px; color: #1e293b;">Create New Announcement</h2>

                <form action="{{ route('announcements.store') }}" method="POST">
                    @csrf
                    {{-- Sets who can view this specific update --}}
                    <div style="margin-bottom: 20px;">
                        <label
                            style="display: block; font-size: 14px; font-weight: 700; color: #64748b; margin-bottom: 8px;">Target
                            Audience</label>
                        <select name="target"
                            style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0;">
                            <option value="all">Everyone</option>
                            <option value="student">Students Only</option>
                            <option value="staff">Staff Only</option>
                        </select>
                    </div>

                    {{-- Title of the update --}}
                    <div style="margin-bottom: 20px;">
                        <label
                            style="display: block; font-size: 14px; font-weight: 700; color: #64748b; margin-bottom: 8px;">Title</label>
                        <input type="text" name="title" required
                            style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0;">
                    </div>

                    {{-- The body of the announcement --}}
                    <div style="margin-bottom: 30px;">
                        <label
                            style="display: block; font-size: 14px; font-weight: 700; color: #64748b; margin-bottom: 8px;">Message</label>
                        <textarea name="content" rows="4" required
                            style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0;"></textarea>
                    </div>

                    <div style="display: flex; gap: 15px;">
                        <button type="button" @click="showModal = false"
                            style="flex: 1; padding: 15px; border-radius: 12px; border: 1px solid #e2e8f0; background: white; font-weight: 700; cursor: pointer;">
                            Cancel
                        </button>
                        <button type="submit"
                            style="flex: 1; padding: 15px; border-radius: 12px; border: none; background: #0d9488; color: white; font-weight: 700; cursor: pointer;">
                            Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
