@extends('Layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
        <div class="space-y-8">

            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-4xl font-black text-gray-900 tracking-tight leading-tight">My Requests</h2>
                    <p class="text-lg text-gray-500 mt-2 font-medium">View your material borrow request history.</p>
                </div>
            </div>

            {{-- Requests Table --}}
            <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-900 uppercase text-sm tracking-wider border-b border-gray-100 bg-white">
                            <th class="px-8 py-6 font-bold text-teal-800">Material</th>
                            <th class="px-8 py-6 font-bold text-center text-teal-800">Qty</th>
                            <th class="px-8 py-6 font-bold text-center text-teal-800">Status</th>
                            <th class="px-8 py-6 font-bold text-teal-800">Date</th>
                            <th class="px-8 py-6 font-bold text-right text-teal-800">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($requests as $request)
                            <tr class="hover:bg-blue-50/40 transition-colors">
                                <td class="px-8 py-5 font-semibold text-gray-800">
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
                                    @elseif ($request->status === 'returned')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-gray-100 text-gray-800">
                                            Returned
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-gray-100 text-gray-800">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-gray-600 text-sm">
                                    {{ $request->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-8 py-5 text-right">
                                    @if ($request->status === 'approved')
                                        <form action="{{ route('borrow-requests.return', $request->id) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Return this material?');">
                                            @csrf
                                            <button type="submit"
                                                class="p-2 px-4 text-sm text-blue-600 hover:text-blue-800 transition-colors duration-200 font-bold">
                                                Return
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-10 text-center text-gray-400 italic">
                                    No requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
