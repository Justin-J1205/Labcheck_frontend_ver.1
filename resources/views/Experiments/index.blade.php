@extends('Layouts.app')

@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
    @foreach($experiments as $exp)
    <div class="card" style="border: 1px solid #ddd; padding: 15px; border-radius: 10px;">
        <span style="font-size: 12px; color: #666;">{{ $exp->category }}</span>
        <h3>{{ $exp->title }}</h3>
        <p>Difficulty: <strong>{{ ucfirst($exp->difficulty) }}</strong></p>
        <p>Duration: {{ $exp->duration_minutes }} mins</p>
        <button>View Full Procedure</button>
    </div>
    @endforeach
</div>
@endsection