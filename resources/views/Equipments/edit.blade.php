@extends('Layouts.app')

@section('content')
    <div style="padding: 40px 20px; max-width: 700px; margin: 0 auto;">
        <a href="{{ route('equipments.index') }}"
            style="text-decoration: none; color: #64748b; font-size: 14px; display: flex; align-items: center; gap: 8px; margin-bottom: 20px;">
            ← Back to Equipment List
        </a>

        <div class="card"
            style="padding: 40px; border-radius: 24px; background: white; border: 1px solid #f1f5f9; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">

            <h2 style="color: #1e293b; margin: 0 0 10px 0; font-size: 24px; font-weight: 700;">Edit Equipment</h2>
            <p style="color: #64748b; margin-bottom: 30px; font-size: 15px;">Update the details for
                <strong>{{ $equipment->name }}</strong>.</p>

            <form action="{{ route('equipments.update', $equipment->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Equipment Name --}}
                <div style="margin-bottom: 20px;">
                    <label
                        style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155; font-size: 14px;">Equipment
                        Name</label>
                    <input type="text" name="name" value="{{ old('name', $equipment->name) }}" required
                        style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 15px;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                    {{-- Status --}}
                    <div>
                        <label
                            style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155; font-size: 14px;">Status</label>
                        <select name="status" required
                            style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; background: white; font-size: 15px;">
                            <option value="available" {{ $equipment->status == 'available' ? 'selected' : '' }}>Available
                            </option>
                            <option value="unavailable" {{ $equipment->status == 'unavailable' ? 'selected' : '' }}>
                                Unavailable</option>
                            <option value="maintenance" {{ $equipment->status == 'maintenance' ? 'selected' : '' }}>
                                Maintenance</option>
                        </select>
                    </div>

                    {{-- Quantity --}}
                    <div>
                        <label
                            style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155; font-size: 14px;">Quantity</label>
                        <input type="number" name="quantity" value="{{ old('quantity', $equipment->quantity) }}" required
                            min="1"
                            style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 15px;">
                    </div>
                </div>

                {{-- Description --}}
                <div style="margin-bottom: 30px;">
                    <label
                        style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155; font-size: 14px;">Description</label>
                    <textarea name="description"
                        style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; min-height: 100px; font-size: 15px; resize: none;">{{ old('description', $equipment->description) }}</textarea>
                </div>

                <div style="display: flex; gap: 15px;">
                    <button type="submit"
                        style="flex: 2; padding: 14px; border-radius: 12px; background: #0d9488; color: white; border: none; font-weight: 700; cursor: pointer; font-size: 16px;">
                        Update Equipment
                    </button>
                    <a href="{{ route('equipments.index') }}"
                        style="flex: 1; text-align: center; padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; background: #f8fafc; text-decoration: none; color: #64748b; font-weight: 600; font-size: 16px;">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
