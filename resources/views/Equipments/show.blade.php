@extends('Layouts.app')

@section('content')
    <div style="max-width: 800px; margin: 40px auto; padding: 0 20px;">
        {{-- FIXED: Changed 'equipment.index' to 'equipments.index' --}}
        <a href="{{ route('equipments.index') }}"
            style="color: #64748b; text-decoration: none; font-size: 14px; font-weight: 600;">
            ← Back to Equipment List
        </a>

        <div
            style="background: white; border-radius: 24px; padding: 40px; margin-top: 20px; border: 1px solid #f1f5f9; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);">
            <span style="color: #0d9488; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">
                Asset Inventory
            </span>
            <h1 style="font-size: 32px; margin: 10px 0 20px 0; color: #1e293b;">{{ $equipment->name }}</h1>

            <div style="display: flex; gap: 20px; margin-bottom: 30px;">
                {{-- Status Box --}}
                <div style="background: #f8fafc; padding: 12px 20px; border-radius: 12px; border: 1px solid #f1f5f9;">
                    <span style="display: block; font-size: 10px; color: #94a3b8; font-weight: 800;">STATUS</span>
                    <span style="font-weight: 700; color: #1e293b;">{{ strtoupper($equipment->status) }}</span>
                </div>
                {{-- Stock Box --}}
                <div style="background: #f8fafc; padding: 12px 20px; border-radius: 12px; border: 1px solid #f1f5f9;">
                    <span style="display: block; font-size: 10px; color: #94a3b8; font-weight: 800;">STOCK</span>
                    <span style="font-weight: 700; color: #1e293b;">{{ $equipment->quantity }} UNITS</span>
                </div>
            </div>

            <h3 style="font-size: 18px; margin-bottom: 12px; color: #334155; font-weight: 700;">Equipment Description</h3>
            <p style="line-height: 1.8; color: #475569; white-space: pre-line; font-size: 16px; margin-bottom: 30px;">
                {{ $equipment->description ?? 'No description provided.' }}
            </p>

            {{-- Linked Experiments --}}
            <div style="border-top: 1px solid #f1f5f9; padding-top: 30px; margin-top: 10px;">
                <h3 style="font-size: 18px; margin-bottom: 15px; color: #334155; font-weight: 700;">Linked Experiments</h3>
                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                    @forelse($equipment->experiments as $experiment)
                        <a href="{{ route('experiments.show', $experiment->id) }}"
                            style="background: #f1f5f9; color: #475569; padding: 8px 16px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; border: 1px solid #e2e8f0;">
                            🧪 {{ $experiment->title }}
                        </a>
                    @empty
                        <p style="color: #94a3b8; font-size: 14px; font-style: italic;">This tool is not currently linked to
                            any experiments.</p>
                    @endforelse
                </div>
            </div>

            {{-- Edit Button --}}
            @if (Auth::user()->role !== 'student')
                <div style="margin-top: 40px;">
                    <a href="{{ route('equipments.edit', $equipment->id) }}"
                        style="display: block; text-align: center; padding: 18px; background: #0d9488; color: white; text-decoration: none; border-radius: 16px; font-weight: 700; font-size: 16px; transition: 0.3s; box-shadow: 0 4px 12px rgba(13, 148, 136, 0.2);">
                        📝 Edit Details
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
