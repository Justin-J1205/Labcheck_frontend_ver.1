@extends('Layouts.app')

@section('content')
    <div style="padding: 30px; max-width: 800px; margin: 0 auto;">
        <h1 style="font-size: 28px; font-weight: 800; color: #1e293b; margin-bottom: 10px;">Request Material</h1>

        <a href="{{ $materialType === 'chemical' ? route('catalog.index') : route('equipments.index') }}"
            style="text-decoration: none; color: #64748b; font-size: 14px; display: flex; align-items: center; gap: 8px; margin-bottom: 25px; font-weight: 600;">
            ← Back to {{ $materialType === 'chemical' ? 'Catalog' : 'Equipment' }}
        </a>

        <form action="{{ route('borrow-requests.store') }}" method="POST"
            style="background: white; padding: 40px; border-radius: 24px; border: 1px solid #f1f5f9; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);">
            @csrf

            <input type="hidden" name="material_type" value="{{ $materialType }}">
            <input type="hidden" name="material_id" value="{{ $materialId }}">

            {{-- Material Info --}}
            <div style="margin-bottom: 32px; padding: 20px; background: #f0f9ff; border-radius: 12px; border: 1px solid #bfdbfe;">
                <p style="margin: 0 0 8px 0; color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: 700;">
                    Material: {{ ucfirst($materialType) }}
                </p>
                <h3 style="margin: 0; color: #1e293b; font-size: 20px; font-weight: 700;">
                    {{ $material->name }}
                </h3>
                @if ($materialType === 'chemical')
                    <p style="margin: 8px 0 0 0; color: #475569; font-size: 14px;">
                        Formula: <strong>{{ $material->formula }}</strong>
                    </p>
                    <p style="margin: 4px 0 0 0; color: #475569; font-size: 14px;">
                        Available Quantity: <strong>{{ $material->amount }}</strong>
                    </p>
                @else
                    <p style="margin: 8px 0 0 0; color: #475569; font-size: 14px;">
                        Available Quantity: <strong>{{ $material->quantity }}</strong>
                    </p>
                @endif
            </div>

            {{-- Quantity Requested --}}
            <div style="margin-bottom: 32px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #334155; font-size: 14px;">
                    Quantity Requested
                </label>
                <input type="number" name="quantity" required min="1"
                    max="{{ $materialType === 'chemical' ? $material->amount : $material->quantity }}"
                    placeholder="Enter quantity"
                    style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 15px; outline-color: #0d9488;">
                <p style="margin: 8px 0 0 0; color: #64748b; font-size: 12px;">
                    Maximum available: {{ $materialType === 'chemical' ? $material->amount : $material->quantity }}
                </p>
            </div>

            {{-- Due Date --}}
            <div style="margin-bottom: 32px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #334155; font-size: 14px;">
                    Expected Return Date (Due Date)
                </label>
                <input type="date" name="due_date" required
                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                    style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 15px; outline-color: #0d9488;">
                <p style="margin: 8px 0 0 0; color: #64748b; font-size: 12px;">
                    Please specify when you plan to return the material
                </p>
            </div>

            {{-- Submit Button --}}
            <div style="display: flex; gap: 15px;">
                <a href="{{ $materialType === 'chemical' ? route('catalog.index') : route('equipments.index') }}"
                    style="flex: 1; padding: 15px; border-radius: 12px; border: 1px solid #e2e8f0; background: white; font-weight: 700; cursor: pointer; text-decoration: none; text-align: center; color: #334155;">
                    Cancel
                </a>
                <button type="submit"
                    style="flex: 1; padding: 15px; border-radius: 12px; border: none; background: #0d9488; color: white; font-weight: 700; cursor: pointer; font-size: 16px; transition: background 0.2s;"
                    onmouseover="this.style.background='#0f766e'" onmouseout="this.style.background='#0d9488'">
                    Submit Request
                </button>
            </div>
        </form>
    </div>
@endsection
