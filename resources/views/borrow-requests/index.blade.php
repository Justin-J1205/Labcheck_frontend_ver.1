@extends('Layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
        <div class="space-y-8">

            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-4xl font-black text-gray-900 tracking-tight leading-tight">Borrow Requests</h2>
                    <p class="text-lg text-gray-500 mt-2 font-medium">Review and manage material borrow requests from students.</p>
                </div>
            </div>

            {{-- Requests Table --}}
            <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-900 uppercase text-sm tracking-wider border-b border-gray-100 bg-white">
                            <th class="px-8 py-6 font-bold text-teal-800">Student</th>
                            <th class="px-8 py-6 font-bold text-teal-800">Material</th>
                            <th class="px-8 py-6 font-bold text-center text-teal-800">Qty</th>
                            <th class="px-8 py-6 font-bold text-center text-teal-800">Status</th>
                            <th class="px-8 py-6 font-bold text-right text-teal-800">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($requests as $request)
                            <tr class="hover:bg-blue-50/40 transition-colors">
                                <td class="px-8 py-5 font-semibold text-gray-800">
                                    {{ $request->user->full_name }}
                                </td>
                                <td class="px-8 py-5 text-gray-600">
                                    @if ($request->material_type === 'chemical')
                                        <span class="inline-flex items-center gap-2">
                                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                            {{ $request->chemical?->name ?? 'Deleted' }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2">
                                            <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                                            {{ $request->equipment?->name ?? 'Deleted' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-center text-gray-600 font-bold">
                                    {{ $request->quantity }}
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @if ($request->status === 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif ($request->status === 'approved')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                                            Approved
                                        </span>
                                    @elseif ($request->status === 'rejected')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-gray-100 text-gray-800">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    @if ($request->status === 'pending')
                                        <div class="flex gap-2 justify-end items-center">
                                            <form action="{{ route('borrow-requests.approve', $request->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="p-2 text-green-600 hover:text-green-800 transition-colors duration-200"
                                                    title="Approve">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                            </form>

                                            <button type="button"
                                                class="p-2 text-red-600 hover:text-red-800 transition-colors duration-200"
                                                title="Reject"
                                                @click="open = true; rejectId = {{ $request->id }}"
                                                x-data="{ open: false, rejectId: null }">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-10 text-center text-gray-400 italic">
                                    No borrow requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
