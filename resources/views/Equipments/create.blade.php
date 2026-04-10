@extends('Layouts.app')

@section('content')
    <div style="padding: 40px 20px; max-width: 700px; margin: 0 auto;">

        <a href="{{ route('equipments.index') }}"
            style="text-decoration: none; color: #64748b; font-size: 14px; display: flex; align-items: center; gap: 8px; margin-bottom: 20px;">
            ← Back to Equipment List
        </a>

        <div class="card"
            style="padding: 40px; border-radius: 24px; background: white; border: 1px solid #f1f5f9; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">

            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                <h2 style="color: #1e293b; margin: 0; font-size: 24px; font-weight: 700;">Add New Equipment</h2>
            </div>

            <p style="color: #64748b; margin-bottom: 30px; font-size: 15px;">Manage and track all laboratory equipment
                assets.</p>

            <form action="{{ route('equipments.store') }}" method="POST">
                @csrf

                {{-- Equipment Name --}}
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155; font-size: 14px;">
                        Equipment Name
                    </label>
                    <input type="text" name="name" required placeholder="e.g. Digital Microscope"
                        value="{{ old('name') }}"
                        style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 15px;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                    {{-- Status Dropdown --}}
                    <div>
                        <label
                            style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155; font-size: 14px;">
                            Initial Status
                        </label>
                        <select name="status" required
                            style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; background: white; font-size: 15px;">
                            <option value="available" selected>Available</option>
                            <option value="unavailable">Unavailable</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>

                    {{-- Quantity --}}
                    <div>
                        <label
                            style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155; font-size: 14px;">
                            Quantity
                        </label>
                        <input type="number" name="quantity" required placeholder="1" min="1"
                            value="{{ old('quantity', 1) }}"
                            style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 15px;">
                    </div>
                </div>

                {{-- Description --}}
                <div style="margin-bottom: 30px;">
                    <label
                        style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155; font-size: 14px;">Description</label>
                    <textarea name="description" placeholder="Add specific details for this asset..."
                        style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; min-height: 100px; font-size: 15px; resize: none;">{{ old('description') }}</textarea>
                </div>

                {{-- Available Checkbox --}}
                <div style="margin-bottom: 30px;">
                    <label style="display: flex; align-items: center; gap: 10px; font-weight: 600; color: #334155; font-size: 14px; cursor: pointer;">
                        <input type="checkbox" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }}
                            style="width: 18px; height: 18px; cursor: pointer;">
                        Available for borrowing
                    </label>
                </div>

                {{-- Form Actions --}}
                <div style="display: flex; gap: 15px;">
                    <button type="submit"
                        style="flex: 2; padding: 14px; border-radius: 12px; background: #0d9488; color: white; border: none; font-weight: 700; cursor: pointer; font-size: 16px; transition: opacity 0.2s;"
                        onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        Save Equipment
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
