@extends('Layouts.app')

@section('content')
    <div style="padding: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2 style="font-weight: 700; color: #1e293b;">Laboratory Catalog</h2>
            @if (Auth::user()->role !== 'student')
                <a href="{{ route('experiments.create') }}"
                    style="background: #0d9488; color: white; padding: 12px 20px; border-radius: 12px; text-decoration: none; font-weight: 600;">+
                    Add New</a>
            @endif
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px;">
            @forelse($experiments as $experiment)
                <div
                    style="background: white; border-radius: 20px; border: 1px solid #f1f5f9; padding: 25px; position: relative;">
                    <a href="{{ route('experiments.show', $experiment->id) }}" style="text-decoration: none; color: inherit;">
                        <span
                            style="background: #f1f5f9; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; color: #64748b;">{{ $experiment->category }}</span>
                        <h3 style="margin: 15px 0 10px 0; font-size: 18px;">{{ $experiment->title }}</h3>
                        <p style="color: #64748b; font-size: 14px; margin-bottom: 20px;">
                            {{ Str::limit($experiment->description, 70) }}</p>
                    </a>

                    <div
                        style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f8fafc; pt: 15px;">
                        <span style="font-size: 12px; color: #94a3b8;">⏱ {{ $experiment->duration_minutes }} mins</span>

                        @if (Auth::user()->role !== 'student')
                            <form action="{{ route('experiments.destroy', $experiment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this?')"
                                    style="background: none; border: none; color: #dc2626; font-size: 12px; font-weight: 700; cursor: pointer;">DELETE</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p>No experiments found.</p>
            @endforelse
        </div>
    </div>
@endsection
