@extends('Layouts.app')

@section('content')
    <div class="space-y-8">
        {{-- 1. HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Laboratory Equipment</h2>
                <p class="text-base text-gray-500 mt-1">Manage and track all UIC lab assets and hardware.</p>
            </div>
            {{-- ADD NEW BUTTON --}}
            @if (Auth::user()->role !== 'student')
                <a href="{{ route('equipment.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-lg transition-colors">
                    <span class="mr-2">+</span> Add Equipment
                </a>
            @endif
        </div>

        {{-- 2. CARD GRID (Matching the Experiment Style) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($equipments as $item)
                <div
                    class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        {{-- Badge/Category Style --}}
                        <span
                            class="inline-block px-3 py-1 bg-gray-100 text-gray-500 text-xs font-bold rounded-full mb-4 uppercase tracking-widest">
                            {{ $item->model_type ?? 'Hardware' }}
                        </span>

                        {{-- Item Name --}}
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $item->name }}</h3>

                        {{-- Description --}}
                        <p class="text-gray-400 text-sm leading-relaxed mb-4">
                            {{ $item->description ?? 'No specific details provided for this asset.' }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between mt-6 border-t border-gray-50 pt-4">
                        {{-- Status/Quantity Info --}}
                        <div class="flex items-center text-gray-400 text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 11v.01" />
                            </svg>
                            <span>Qty: {{ $item->quantity ?? 1 }}</span>
                            <span class="mx-2">•</span>
                            <span
                                class="{{ $item->status === 'available' ? 'text-teal-600' : 'text-orange-500' }} font-bold uppercase text-xs">
                                {{ $item->status }}
                            </span>
                        </div>

                        {{-- Delete Action --}}
                        @if (Auth::user()->role !== 'student')
                            <form action="{{ route('equipment.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Remove this equipment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-500 hover:text-red-700 font-bold text-xs uppercase tracking-widest">
                                    DELETE
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                    <p class="text-gray-400 font-medium text-lg">No equipment found in the database.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
