@extends('Layouts.app')

@section('content')
    {{-- Main wrapper with UIC styling --}}
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

        <div class="space-y-8" x-data="{
            activeDescription: 'Select an item from the catalog below to see its description.',
            activeName: 'Description'
        }">

            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-4xl font-black text-gray-900 tracking-tight leading-tight">Chemical Catalog</h2>
                    <p class="text-lg text-gray-500 mt-2 font-medium">Manage and track all laboratory chemical stocks.</p>
                </div>
            </div>

            {{-- Dynamic Description Card --}}
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-blue-50 transition-all duration-300">
                <div class="flex items-start space-x-4">
                    <div class="bg-blue-50 p-4 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0116 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-gray-900 font-bold text-xl mb-1" x-text="activeName"></h3>
                        <p class="text-gray-600 text-base leading-relaxed" x-text="activeDescription"></p>
                    </div>
                </div>
            </div>

            {{-- Catalog Table --}}
            <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-900 uppercase text-sm tracking-wider border-b border-gray-100 bg-white">
                            <th class="px-8 py-6 font-bold text-teal-800">Name</th>
                            <th class="px-8 py-6 font-bold text-teal-800">Formula</th>
                            <th class="px-8 py-6 font-bold text-center text-teal-800">In-Stock</th>
                            <th class="px-8 py-6 font-bold text-center text-teal-800">Available</th>
                            <th class="px-8 py-6 font-bold text-right text-teal-800">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($chemicals as $chemical)
                            {{-- Row updates Alpine state; addslashes prevents JS errors from quotes in names/descriptions --}}
                            <tr class="hover:bg-blue-50/40 transition-colors cursor-pointer"
                                @click="activeName = '{{ addslashes($chemical->name) }}'; 
                                       activeDescription = '{{ addslashes($chemical->safety_info ?? 'No safety information provided.') }}'">

                                <td class="px-8 py-5 font-semibold text-gray-800">{{ $chemical->name }}</td>
                                <td class="px-8 py-5 text-gray-600 font-mono text-sm tracking-tight">
                                    {{ $chemical->formula ?? 'N/A' }}
                                </td>

                                <td class="px-8 py-5 text-center text-gray-600 font-bold">
                                    {{ $chemical->amount ?? 0 }}
                                </td>

                                <td class="px-8 py-5 text-center">
                                    @if (auth()->user()->role === 'staff')
                                        {{-- Toggle Availability --}}
                                        <form action="{{ route('catalog.toggle', $chemical->id) }}" method="POST"
                                            @click.stop>
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" title="Toggle Availability"
                                                class="transition-transform active:scale-90">
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full text-white font-bold text-sm shadow-md {{ $chemical->is_available ? 'bg-green-500 shadow-green-200' : 'bg-red-500 shadow-red-200' }}">
                                                    {{ $chemical->is_available ? '✓' : '✕' }}
                                                </span>
                                            </button>
                                        </form>
                                    @else
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 {{ $chemical->is_available ? 'bg-green-500' : 'bg-red-500' }} rounded-full text-white font-bold text-sm">
                                            {{ $chemical->is_available ? '✓' : '✕' }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-8 py-5 text-right">
                                    @if (auth()->user()->role === 'staff')
                                        {{-- Delete Form --}}
                                        <div class="inline-block">
                                            {{-- @click.stop prevents the row click from firing when deleting --}}
                                            <form action="{{ route('catalog.destroy', $chemical->id) }}" method="POST"
                                                @click.stop
                                                onsubmit="return confirm('Are you sure you want to delete {{ $chemical->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-gray-400 hover:text-red-600 transition-colors duration-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-10 text-center text-gray-400 italic">
                                    No chemicals found in the catalog.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Floating Action Button for Staff --}}
    @if (auth()->user()->role === 'staff')
        <a href="{{ route('catalog.create') }}"
            class="fixed bottom-8 right-8 z-50 inline-flex items-center justify-center p-4 bg-teal-600 hover:bg-teal-700 text-white rounded-full shadow-2xl transition-all duration-300 transform hover:scale-110 active:scale-95 group">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span
                class="absolute right-full mr-4 bg-gray-900 text-white text-xs px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap shadow-xl">
                Add New Chemical
            </span>
        </a>
    @endif
@endsection
