@extends('Layouts.app')

@section('content')
    <style>
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
            text-decoration: none;
        }

        .badge-teal {
            background: #ccfbf1;
            color: #0d9488;
        }

        .badge-gray {
            background: #f1f5f9;
            color: #64748b;
        }
        
        .btn-view {
            display: block;
            width: 100%;
            padding: 12px;
            text-align: center;
            text-decoration: none;
            background: #f1f5f9;
            color: #0d9488;
            font-weight: bold;
            border-radius: 8px;
            transition: background 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-view:hover {
            background: #e2e8f0;
        }

        .action-btn {
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: bold;
            display: inline-block;
            transition: opacity 0.2s;
        }

        .btn-primary { background: #0d9488; color: white; }
        .btn-outline { border: 1px solid #0d9488; color: #0d9488; }
        .action-btn:hover { opacity: 0.8; }
    </style>

    {{-- Main Header --}}
    <div style="margin-bottom: 30px;">
        <p style="color: #64748b; margin: 0;">Here is what's happening in the lab today.</p>
    </div>

    @if (Auth::user()->role == 'student')
        {{-- STUDENT VIEW --}}
        <div style="margin-bottom: 20px;">
            <a href="{{ url('/experiments') }}" class="badge badge-teal">All Experiments</a>
            <a href="{{ url('/experiments?cat=chemistry') }}" class="badge badge-gray" style="margin-left: 10px;">Chemistry</a>
            <a href="{{ url('/experiments?cat=biology') }}" class="badge badge-gray" style="margin-left: 10px;">Biology</a>
        </div>

        <div class="grid">
            @forelse($experiments as $experiment)
                <div class="card">
                    <div style="height: 120px; background: #f8fafc; border-radius: 10px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center;">
                        <span style="font-size: 40px;">🔬</span>
                    </div>
                    <span class="badge badge-teal" style="margin-bottom: 10px;">{{ $experiment->category }}</span>
                    <h3 style="margin: 5px 0 10px 0; color: #334155;">{{ $experiment->title }}</h3>
                    <p style="font-size: 14px; color: #64748b; margin-bottom: 15px;">
                        Difficulty: <strong>{{ ucfirst($experiment->difficulty) }}</strong><br>
                        Duration: {{ $experiment->duration_minutes }} mins
                    </p>
                    <a href="{{ url('/experiments/'.$experiment->id) }}" class="btn-view">View Procedure</a>
                </div>
            @empty
                <p style="color: #64748b;">No experiments found.</p>
            @endforelse
        </div>

    @else
        {{-- ADMIN/STAFF VIEW --}}
        <div class="grid">
            <div class="card" style="border-left: 5px solid #0d9488;">
                <h4 style="margin: 0; color: #64748b; font-size: 14px;">Equipment Available</h4>
                <h2 style="margin: 10px 0 0 0; font-size: 32px; color: #0d9488;">{{ $availableCount }} Units</h2>
            </div>
            
            <div class="card" style="border-left: 5px solid #f59e0b;">
                <h4 style="margin: 0; color: #64748b; font-size: 14px;">In-Use / Maintenance</h4>
                <h2 style="margin: 10px 0 0 0; font-size: 32px; color: #f59e0b;">{{ $inUseCount }} Units</h2>
            </div>

            <div class="card" style="border-left: 5px solid #3b82f6;">
                <h4 style="margin: 0; color: #64748b; font-size: 14px;">Total Registered Users</h4>
                <h2 style="margin: 10px 0 0 0; font-size: 32px; color: #3b82f6;">{{ \App\Models\User::count() }}</h2>
            </div>
        </div>

        <div style="margin-top: 40px;">
            <h3 style="color: #334155;">Quick Actions</h3>
            <div style="display: flex; gap: 15px; margin-top: 15px;">
                <a href="{{ url('/inventory-control') }}" class="action-btn btn-primary">Update Stock</a>
                <a href="{{ url('/equipment-management') }}" class="action-btn btn-outline">Manage Equipment</a>
            </div>
        </div>
    @endif
@endsection