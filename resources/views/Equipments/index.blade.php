@extends('Layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h2 class="text-4xl font-black text-gray-900 tracking-tight leading-tight">Laboratory Equipment</h2>
                <p class="text-lg text-gray-500 mt-2 font-medium">Manage and track all lab assets and hardware.</p>
            </div>

            @if (Auth::user()->role !== 'student')

                <a href="{{ route('equipments.create') }}"
                    class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-xl no-underline font-semibold transition-all transform hover:scale-105 active:scale-95 shadow-lg shadow-teal-100 text-center">
                    + Add Equipment
                </a>
            @endif
        </div>

        {{-- Equipment Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($equipments as $item)
                <div
                    class="bg-white rounded-[20px] border border-slate-100 p-6 shadow-sm hover:shadow-md transition-shadow relative flex flex-col justify-between">

                    <div>
                        <span
                            class="inline-block bg-slate-100 px-3 py-1 rounded-lg text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-4">
                            {{ $item->category ?? 'Hardware' }}
                        </span>

                        <a href="{{ route('equipments.show', $item->id) }}" class="group no-underline">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-teal-600 transition-colors">
                                {{ $item->name }}
                            </h3>
                        </a>

                        <p class="text-slate-500 text-sm leading-relaxed mb-6">
                            {{ Str::limit($item->description ?? 'No specific details provided for this asset.', 70) }}
                        </p>
                    </div>

                    {{-- Footer with Status and Actions --}}
                    <div class="flex items-center justify-between mt-6 border-t border-slate-50 pt-4">
                        <div class="flex items-center text-slate-400 text-xs font-medium">
                            <span class="mr-2">Qty: {{ $item->quantity ?? 1 }}</span>
                            <span class="mx-2">•</span>
                            <span
                                class="uppercase font-bold {{ strtolower($item->status ?? 'available') === 'available' ? 'text-teal-600' : 'text-orange-500' }}">
                                {{ $item->status ?? 'Available' }}
                            </span>
                        </div>

                        @if (Auth::user()->role !== 'student')
                            <div class="flex gap-4 items-center">
                                <a href="{{ route('equipments.edit', $item->id) }}"
                                    class="bg-transparent border-none text-orange-500 text-xs font-bold cursor-pointer hover:text-orange-700 transition-colors uppercase tracking-widest no-underline">
                                    EDIT
                                </a>
                                <form action="{{ route('equipments.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Remove this equipment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-transparent border-none text-red-500 text-xs font-bold cursor-pointer hover:text-red-700 transition-colors uppercase tracking-widest">
                                        DELETE
                                    </button>
                                </form>
                            </div>
                        @else
                            @if ($item->is_available && $item->quantity > 0)
                                <a href="{{ route('borrow-requests.create', ['type' => 'equipment', 'id' => $item->id]) }}"
                                    class="bg-transparent border-none text-teal-600 text-xs font-bold cursor-pointer hover:text-teal-700 transition-colors uppercase tracking-widest no-underline">
                                    REQUEST
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full py-20 text-center bg-gray-50 rounded-[20px] border-2 border-dashed border-gray-200">
                    <p class="text-gray-400 font-medium text-lg italic">No equipment found yet.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
