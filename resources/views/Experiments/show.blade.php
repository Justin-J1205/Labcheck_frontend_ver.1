@extends('Layouts.app')

@section('content')
    <div style="max-width: 800px; margin: 40px auto; padding: 0 20px;">
        {{-- Back Link --}}
        <a href="{{ route('experiments.index') }}"
            style="color: #64748b; text-decoration: none; font-size: 14px; font-weight: 600;">
            ← Back to Experiments
        </a>

        {{-- Detail Card --}}
        <div
            style="background: white; border-radius: 24px; padding: 40px; margin-top: 20px; border: 1px solid #f1f5f9; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);">
            <span style="color: #0d9488; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">
                {{ $experiment->category }}
            </span>
            <h1 style="font-size: 32px; margin: 10px 0 20px 0; color: #1e293b;">{{ $experiment->title }}</h1>

            <div style="display: flex; gap: 20px; margin-bottom: 30px;">
                <div style="background: #f8fafc; padding: 12px 20px; border-radius: 12px; border: 1px solid #f1f5f9;">
                    <span style="display: block; font-size: 10px; color: #94a3b8; font-weight: 800;">DIFFICULTY</span>
                    <span style="font-weight: 700; color: #1e293b;">{{ strtoupper($experiment->difficulty) }}</span>
                </div>
                <div style="background: #f8fafc; padding: 12px 20px; border-radius: 12px; border: 1px solid #f1f5f9;">
                    <span style="display: block; font-size: 10px; color: #94a3b8; font-weight: 800;">DURATION</span>
                    <span style="font-weight: 700; color: #1e293b;">{{ $experiment->duration_minutes }} MINS</span>
                </div>
            </div>

            {{-- Requirements Section --}}
            <div
                style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 40px; border-top: 1px solid #f1f5f9; padding-top: 30px;">
                {{-- Equipment List --}}
                <div>
                    <h4
                        style="font-size: 14px; color: #0d9488; font-weight: 800; margin-bottom: 15px; text-transform: uppercase;">
                        🔬 Equipment</h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @forelse($experiment->equipments as $equipment)
                            <li
                                style="font-size: 15px; color: #475569; margin-bottom: 8px; display: flex; justify-content: space-between;">
                                <span>{{ $equipment->name }}</span>
                                <strong style="color: #1e293b;">x{{ $equipment->pivot->quantity_needed }}</strong>
                            </li>
                        @empty
                            <li style="font-size: 14px; color: #94a3b8; font-style: italic;">No specific equipment listed.
                            </li>
                        @endforelse
                    </ul>
                </div>

                {{-- Chemical List --}}
                <div>
                    <h4
                        style="font-size: 14px; color: #0d9488; font-weight: 800; margin-bottom: 15px; text-transform: uppercase;">
                        🧪 Chemicals</h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @forelse($experiment->chemicals as $chemical)
                            <li
                                style="font-size: 15px; color: #475569; margin-bottom: 8px; display: flex; justify-content: space-between;">
                                <span>{{ $chemical->name }}</span>
                                <strong style="color: #1e293b;">{{ $chemical->pivot->amount_needed }}
                                    {{ $chemical->unit }}</strong>
                            </li>
                        @empty
                            <li style="font-size: 14px; color: #94a3b8; font-style: italic;">No chemicals required.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <h3 style="font-size: 18px; margin-bottom: 12px; color: #334155; font-weight: 700;">Detailed Description</h3>
            <p style="line-height: 1.8; color: #475569; white-space: pre-line; font-size: 16px; margin-bottom: 40px;">
                {{ $experiment->description }}
            </p>

            {{-- Student Action Section --}}
            @if (Auth::user()->role === 'student')
                <div style="margin-top: 30px;">
                    @if (Auth::user()->experiments->contains($experiment->id))
                        {{-- Already Joined State --}}
                        <div style="display: flex; gap: 12px; align-items: center;">
                            <div
                                style="flex: 1; padding: 18px; background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; border-radius: 16px; font-weight: 700; text-align: center; font-size: 16px;">
                                ✅ You are enrolled in this experiment
                            </div>

                            <form action="{{ route('experiments.leave', $experiment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    style="padding: 18px 25px; background: #fee2e2; color: #ef4444; border: none; border-radius: 16px; font-weight: 700; cursor: pointer; transition: 0.3s;"
                                    onclick="return confirm('Are you sure you want to leave this experiment?')">
                                    Leave
                                </button>
                            </form>
                        </div>
                    @else
                        {{-- Not Joined State --}}
                        <form action="{{ route('experiments.join', $experiment->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                style="width: 100%; padding: 18px; background: #3b82f6; color: white; border: none; border-radius: 16px; font-weight: 700; font-size: 16px; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 14px 0 rgba(59, 130, 246, 0.39);">
                                🚀 Join Experiment & Add to My Schedule
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection
