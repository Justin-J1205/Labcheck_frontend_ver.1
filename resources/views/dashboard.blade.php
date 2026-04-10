@extends('Layouts.app')

@section('content')
    {{-- Main Dashboard container with Alpine.js state for the modal --}}
    <div style="padding: 30px;" x-data="{ showModal: false, showUserModal: false }">

        {{-- Header: Displays greeting --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h1 style="font-size: 28px; font-weight: 800; color: #1e293b; margin: 0;">Dashboard</h1>
                <p style="color: #64748b; margin: 5px 0 0 0;">Welcome back to Labcheck</p>
            </div>

            @if (Auth::user()->role !== 'student')
                <button @click="showModal = true"
                    style="background: #0d9488; color: white; padding: 12px 24px; border-radius: 12px; border: none; font-weight: 700; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(13, 148, 136, 0.2);">
                    + New Announcement
                </button>
            @endif
        </div>

        {{-- Stats Grid: ONLY visible to Staff/Admins --}}
        @if (Auth::user()->role !== 'student')
            <div
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 40px;">
                <div style="background: white; padding: 25px; border-radius: 20px; border: 1px solid #f1f5f9;">
                    <span style="color: #64748b; font-size: 14px; font-weight: 600;">Available Equipment</span>
                    <h2 style="font-size: 32px; margin: 10px 0 0 0; color: #0d9488;">{{ $availableCount }}</h2>
                </div>
                <div style="background: white; padding: 25px; border-radius: 20px; border: 1px solid #f1f5f9;">
                    <span style="color: #64748b; font-size: 14px; font-weight: 600;">Currently In Use</span>
                    <h2 style="font-size: 32px; margin: 10px 0 0 0; color: #ef4444;">{{ $inUseCount }}</h2>
                </div>
            </div>
        @endif

        {{-- Balanced Two-Column Grid for Students --}}
        <div
            style="display: grid; grid-template-columns: {{ Auth::user()->role === 'student' ? '1fr 1fr' : '1fr' }}; gap: 30px; align-items: stretch;">

            {{-- Column 1: Student's Joined Experiments --}}
            @if (Auth::user()->role === 'student')
                <div
                    style="background: white; border-radius: 24px; border: 1px solid #f1f5f9; padding: 30px; display: flex; flex-direction: column;">
                    <h3 style="margin-top: 0; margin-bottom: 20px; color: #1e293b; font-weight: 700;">My Active Experiments
                    </h3>

                    <div style="flex-grow: 1; display: flex; flex-direction: column; gap: 15px;">
                        @forelse(Auth::user()->experiments as $experiment)
                            <div
                                style="background: #f8fafc; padding: 15px; border-radius: 16px; border: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <span
                                        style="font-size: 10px; color: #0d9488; font-weight: 700; text-transform: uppercase;">{{ $experiment->category }}</span>
                                    <h4 style="margin: 2px 0; color: #1e293b; font-size: 16px;">{{ $experiment->title }}
                                    </h4>
                                    <a href="{{ route('experiments.show', $experiment->id) }}"
                                        style="color: #64748b; font-size: 12px; text-decoration: none; font-weight: 600;">View
                                        Procedure →</a>
                                </div>

                                <form action="{{ route('experiments.leave', $experiment->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="background: #fee2e2; border: none; color: #ef4444; padding: 8px 12px; border-radius: 8px; font-size: 10px; font-weight: 800; cursor: pointer;">
                                        LEAVE
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div
                                style="flex-grow: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 2px dashed #e2e8f0; border-radius: 16px; padding: 20px;">
                                <p style="color: #64748b; font-size: 14px; margin-bottom: 10px;">No experiments joined.</p>
                                <a href="{{ route('experiments.index') }}"
                                    style="color: #0d9488; font-weight: 700; text-decoration: none; font-size: 13px;">Browse
                                    Experiments →</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

            {{-- Column 2: Announcements (Matches Height) --}}
            <div
                style="background: white; border-radius: 24px; border: 1px solid #f1f5f9; padding: 30px; display: flex; flex-direction: column;">
                <h3 style="margin-top: 0; margin-bottom: 20px; color: #1e293b; font-weight: 700;">Recent Announcements</h3>

                <div style="flex-grow: 1;">
                    @forelse($announcements as $announcement)
                        <div
                            style="padding: 15px 0; border-bottom: 1px solid #f8fafc; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="margin: 0; color: #334155; font-size: 16px;">{{ $announcement->title }}</h4>
                                <p style="margin: 5px 0 0 0; color: #64748b; font-size: 14px;">{{ $announcement->content }}
                                </p>
                                <small
                                    style="color: #94a3b8; font-size: 11px;">{{ $announcement->created_at->diffForHumans() }}</small>
                            </div>
                            @if (Auth::user()->role !== 'student')
                                <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="background: none; border: none; color: #ef4444; font-weight: 700; cursor: pointer; font-size: 11px;">DELETE</button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <div style="flex-grow: 1; display: flex; align-items: center; justify-content: center;">
                            <p style="color: #94a3b8; text-align: center; font-style: italic;">No announcements yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- THE ANNOUNCEMENT --}}
        <div x-show="showModal" x-cloak
            style="position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5); display: flex; align-items: flex-start; justify-content: center; z-index: 50; padding-top: 200px; overflow-y: auto;">
            <div @click.away="showModal = false"
                style="background: white; width: 100%; max-width: 500px; border-radius: 24px; padding: 40px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
                <h2 style="margin-top: 0; margin-bottom: 25px; color: #1e293b;">Create New Announcement</h2>
                <form action="{{ route('announcements.store') }}" method="POST">
                    @csrf
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
                    <div style="margin-bottom: 20px;">
                        <label
                            style="display: block; font-size: 14px; font-weight: 700; color: #64748b; margin-bottom: 8px;">Title</label>
                        <input type="text" name="title" required
                            style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0;">
                    </div>
                    <div style="margin-bottom: 30px;">
                        <label
                            style="display: block; font-size: 14px; font-weight: 700; color: #64748b; margin-bottom: 8px;">Message</label>
                        <textarea name="content" rows="4" required
                            style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0;"></textarea>
                    </div>
                    <div style="display: flex; gap: 15px;">
                        <button type="button" @click="showModal = false"
                            style="flex: 1; padding: 15px; border-radius: 12px; border: 1px solid #e2e8f0; background: white; font-weight: 700; cursor: pointer;">Cancel</button>
                        <button type="submit"
                            style="flex: 1; padding: 15px; border-radius: 12px; border: none; background: #0d9488; color: white; font-weight: 700; cursor: pointer;">Post</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- USER MANAGEMENT MODAL --}}
        <div x-show="showUserModal" x-cloak
            style="position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5); display: flex; align-items: center; justify-content: center; z-index: 60;">

            <div @click.away="showUserModal = false"
                style="background: white; width: 100%; max-width: 600px; border-radius: 24px; padding: 40px; max-height: 80vh; overflow-y: auto;">

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h2 style="margin: 0; color: #1e293b;">Manage Students</h2>
                    <button @click="showUserModal = false"
                        style="background: none; border: none; font-size: 24px; cursor: pointer;">&times;</button>
                </div>

                <div style="display: flex; flex-direction: column; gap: 15px;">
                    @php $allStudents = \App\Models\User::where('role', 'student')->get(); @endphp

                    @forelse($allStudents as $student)
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f8fafc; border-radius: 16px;">
                            <div>
                                <p style="margin: 0; font-weight: 700; color: #334155;">{{ $student->name }}</p>
                                <p style="margin: 0; font-size: 12px; color: #64748b;">{{ $student->email }}</p>
                            </div>

                            <form action="{{ route('staff.users.destroy', $student->id) }}" method="POST"
                                onsubmit="return confirm('Permanently remove this student?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    style="background: #fee2e2; color: #ef4444; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 12px;">
                                    REMOVE
                                </button>
                            </form>
                        </div>
                    @empty
                        <p style="text-align: center; color: #94a3b8;">No students found in the system.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
