@extends('layouts.app')

@section('content')
    <style>
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            border: 1px solid #e2e8f0;
        }

        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-teal {
            background: #ccfbf1;
            color: #0d9488;
        }
    </style>

    @if (Auth::user()->role == 'student')

        {{-- Student Dashboard View --}}
        <div style="margin-bottom: 20px;">
            <span class="badge badge-teal">Chemistry</span>
            <span style="margin-left: 10px; color: #64748b;">Biology</span>
        </div>
        <div class="grid">
            <div class="card">
                <div style="height: 120px; background: #f1f5f9; border-radius: 10px; margin-bottom: 15px;"></div>
                <h3 style="margin: 0 0 10px 0;">Titration Analysis</h3>
                <p style="font-size: 14px; color: #64748b;">Difficulty: Medium</p>
                <button
                    style="width: 100%; padding: 10px; border: none; background: #f1f5f9; color: #0d9488; font-weight: bold; border-radius: 8px;">View
                    Full</button>
            </div>
        </div>
    @else
    
        {{-- Admin Dashboard View --}}
        <div class="grid">
            <div class="card" style="border-left: 5px solid #0d9488;">
                <h4 style="margin: 0; color: #64748b;">Equipment Available</h4>
                <h2 style="margin: 10px 0 0 0;">20 Units</h2>
            </div>
            <div class="card" style="border-left: 5px solid #f59e0b;">
                <h4 style="margin: 0; color: #64748b;">In-Use</h4>
                <h2 style="margin: 10px 0 0 0;">5 Units</h2>
            </div>
        </div>
    @endif
@endsection
