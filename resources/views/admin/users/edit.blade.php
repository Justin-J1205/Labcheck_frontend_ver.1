@extends('Layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-6 lg:px-8 py-10">
        <div class="space-y-8">

            {{-- Header Section --}}
            <div>
                <h2 class="text-4xl font-black text-gray-900 tracking-tight leading-tight">Edit User</h2>
                <p class="text-lg text-gray-500 mt-2 font-medium">Update user information.</p>
            </div>

            {{-- Form Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-blue-50 p-8">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Full Name --}}
                    <div>
                        <label for="full_name" class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                        <input type="text"
                            id="full_name"
                            name="full_name"
                            value="{{ old('full_name', $user->full_name) }}"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-teal-500 transition-colors @error('full_name') border-red-500 @enderror"
                            placeholder="John Doe"
                            required>
                        @error('full_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                        <input type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-teal-500 transition-colors @error('email') border-red-500 @enderror"
                            placeholder="john@example.com"
                            required>
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Date of Birth --}}
                    <div>
                        <label for="date_of_birth" class="block text-sm font-bold text-gray-700 mb-2">Date of Birth</label>
                        <input type="date"
                            id="date_of_birth"
                            name="date_of_birth"
                            value="{{ old('date_of_birth', $user->date_of_birth->format('Y-m-d')) }}"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-teal-500 transition-colors @error('date_of_birth') border-red-500 @enderror"
                            required>
                        @error('date_of_birth')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div>
                        <label for="role" class="block text-sm font-bold text-gray-700 mb-2">Role</label>
                        <select id="role"
                            name="role"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-teal-500 transition-colors @error('role') border-red-500 @enderror"
                            required>
                            <option value="student" @selected(old('role', $user->role) === 'student')>Student</option>
                            <option value="staff" @selected(old('role', $user->role) === 'staff')>Staff</option>
                            <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                        </select>
                        @error('role')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password Section --}}
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-sm font-bold text-gray-700 mb-4">Change Password (Optional)</h3>
                        <p class="text-sm text-gray-500 mb-4">Leave blank to keep the current password.</p>

                        {{-- New Password --}}
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">New Password</label>
                            <input type="password"
                                id="password"
                                name="password"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-teal-500 transition-colors @error('password') border-red-500 @enderror"
                                placeholder="Leave blank to keep current password">
                            @error('password')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Confirm Password</label>
                            <input type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-teal-500 transition-colors"
                                placeholder="Confirm new password">
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-3 pt-6">
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-lg font-bold transition-colors">
                            Update User
                        </button>
                        <a href="{{ route('admin.users.index') }}"
                            class="flex-1 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-bold text-center transition-colors">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
