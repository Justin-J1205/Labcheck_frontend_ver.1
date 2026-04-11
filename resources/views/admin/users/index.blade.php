@extends('Layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
        <div class="space-y-8">

            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-4xl font-black text-gray-900 tracking-tight leading-tight">Users Management</h2>
                    <p class="text-lg text-gray-500 mt-2 font-medium">Manage all system users.</p>
                </div>
                <a href="{{ route('admin.users.create') }}"
                    class="px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-lg font-bold transition-colors">
                    + Add User
                </a>
            </div>

            {{-- Users Table --}}
            <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-900 uppercase text-sm tracking-wider border-b border-gray-100 bg-white">
                            <th class="px-8 py-6 font-bold text-teal-800">Name</th>
                            <th class="px-8 py-6 font-bold text-teal-800">Email</th>
                            <th class="px-8 py-6 font-bold text-center text-teal-800">Role</th>
                            <th class="px-8 py-6 font-bold text-right text-teal-800">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($users as $user)
                            <tr class="hover:bg-blue-50/40 transition-colors">
                                <td class="px-8 py-5 font-semibold text-gray-800">
                                    {{ $user->full_name }}
                                </td>
                                <td class="px-8 py-5 text-gray-600">
                                    {{ $user->email }}
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold
                                        @if ($user->role === 'admin') bg-red-100 text-red-800
                                        @elseif($user->role === 'staff') bg-blue-100 text-blue-800
                                        @else bg-green-100 text-green-800 @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex gap-2 justify-end items-center">
                                        @if (auth()->user()->role === 'admin' || auth()->id() === $user->id)
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="p-2 text-orange-500 hover:text-orange-700 transition-colors duration-200"
                                                title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            @if (Auth::id() !== $user->id)
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 text-gray-400 hover:text-red-600 transition-colors duration-200"
                                                        title="Delete">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="text-xs text-gray-400 italic">Admin Only</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-10 text-center text-gray-400 italic">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
