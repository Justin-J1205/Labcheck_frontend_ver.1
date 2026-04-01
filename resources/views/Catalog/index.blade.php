@extends('Layouts.app')

@section('content')
<div class="container">
    <h2>Chemical Catalog</h2>
    
    <form action="{{ route('catalog.index') }}" method="GET" style="margin-bottom: 20px;">
        <input type="text" name="search" placeholder="Search by name or formula..." value="{{ request('search') }}">
        <button type="submit">Search</button>
    </form>

    <table border="1" width="100%" style="border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>Name</th>
                <th>Formula</th>
                <th>Stock Level</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chemicals as $chemical)
            <tr>
                <td>{{ $chemical->name }}</td>
                <td>{{ $chemical->formula }}</td>
                <td>{{ $chemical->stock->quantity }} {{ $chemical->stock->unit }}</td>
                <td>
                    @if($chemical->stock->is_available)
                        <span style="color: green;">✔ In Stock</span>
                    @else
                        <span style="color: red;">✘ Out of Stock</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection