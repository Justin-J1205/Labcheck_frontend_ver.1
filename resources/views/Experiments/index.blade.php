@extends('Layouts.app')

@section('content')
    <div style="padding: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2 class="text-4xl font-black text-gray-900 tracking-tight leading-tight">Experiments</h2>
            @if (Auth::user()->role !== 'student')
                <a href="{{ route('experiments.create') }}"
                    style="background: #0d9488; color: white; padding: 12px 20px; border-radius: 12px; text-decoration: none; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(13, 148, 136, 0.2);">
                    + Add New
                </a>
            @endif
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px;">
            @forelse($experiments as $experiment)
                <div style="background: white; border-radius: 24px; border: 1px solid #f1f5f9; padding: 25px; position: relative; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);"
                    onmouseover="this.style.transform='translateY(-4px)'; this.style.box_shadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.box_shadow='0 4px 6px -1px rgba(0, 0, 0, 0.05)';">

                    <a href="{{ route('experiments.show', $experiment->id) }}"
                        style="text-decoration: none; color: inherit;">
                        <div
                            style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                            <span
                                style="background: #f1f5f9; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">
                                {{ $experiment->category }}
                            </span>
                            {{-- Difficulty Badge --}}
                            <span
                                style="font-size: 10px; font-weight: 700; color: {{ $experiment->difficulty === 'hard' ? '#ef4444' : ($experiment->difficulty === 'medium' ? '#f59e0b' : '#10b981') }}; text-transform: uppercase;">
                                ● {{ $experiment->difficulty }}
                            </span>
                        </div>

                        <h3 style="margin: 0 0 10px 0; font-size: 20px; color: #1e293b; font-weight: 700;">
                            {{ $experiment->title }}</h3>

                        <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                            {{ Str::limit($experiment->description, 85) }}
                        </p>

                        {{-- Resource Stats --}}
                        <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                            <div style="display: flex; align-items: center; gap: 5px; color: #94a3b8; font-size: 12px;">
                                🧪 <strong>{{ $experiment->chemicals->count() }}</strong> Chemicals
                            </div>
                            <div style="display: flex; align-items: center; gap: 5px; color: #94a3b8; font-size: 12px;">
                                🔬 <strong>{{ $experiment->equipments->count() }}</strong> Tools
                            </div>
                        </div>
                    </a>

                    <div
                        style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f8fafc; padding-top: 15px;">
                        <span
                            style="font-size: 12px; font-weight: 600; color: #64748b; display: flex; align-items: center; gap: 4px;">
                            ⏱ {{ $experiment->duration_minutes }} mins
                        </span>

                        @if (Auth::user()->role !== 'student')
                            <form action="{{ route('experiments.destroy', $experiment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this experiment?')"
                                    style="background: #fee2e2; border: none; color: #ef4444; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer; transition: background 0.2s;"
                                    onmouseover="this.style.background='#fecaca'"
                                    onmouseout="this.style.background='#fee2e2'">
                                    DELETE
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div
                    style="grid-column: 1 / -1; text-align: center; padding: 60px; background: #f8fafc; border-radius: 24px; border: 2px dashed #e2e8f0;">
                    <p style="color: #64748b; font-size: 16px;">No experiments found in the laboratory catalog yet.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
