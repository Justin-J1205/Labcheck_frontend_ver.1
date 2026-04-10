@extends('Layouts.app')

@section('content')
    <div style="padding: 30px; max-width: 800px; margin: 0 auto;">
        <h1 style="font-size: 28px; font-weight: 800; color: #1e293b; margin-bottom: 10px;">Edit Chemical</h1>

        {{-- This link returns the user to the main chemical catalog --}}
        <a href="{{ route('catalog.index') }}"
            style="text-decoration: none; color: #64748b; font-size: 14px; display: flex; align-items: center; gap: 8px; margin-bottom: 25px; font-weight: 600;">
            ← Back to Catalog
        </a>

        <form action="{{ route('catalog.update', $chemical->id) }}" method="POST"
            style="background: white; padding: 40px; border-radius: 24px; border: 1px solid #f1f5f9; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);">
            @csrf
            @method('PUT')

            {{-- Chemical Name --}}
            <div style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #334155; font-size: 14px;">
                    Chemical Name
                </label>
                <input type="text" name="name" required value="{{ $chemical->name }}"
                    style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 15px; outline-color: #0d9488;">
            </div>

            {{-- Formula --}}
            <div style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #334155; font-size: 14px;">
                    Formula
                </label>
                <input type="text" name="formula" required value="{{ $chemical->formula }}"
                    style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 15px; outline-color: #0d9488;">
            </div>

            {{-- Amount --}}
            <div style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #334155; font-size: 14px;">
                    Amount
                </label>
                <input type="number" name="amount" required value="{{ $chemical->amount }}" min="0"
                    style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 15px; outline-color: #0d9488;">
            </div>

            {{-- Safety Info --}}
            <div style="margin-bottom: 32px;">
                <label for="safety_info"
                    style="display: block; margin-bottom: 8px; font-weight: 700; color: #334155; font-size: 14px;">
                    Description & Safety Info
                </label>

                <textarea name="safety_info" id="safety_info" rows="3"
                    style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 15px; outline-color: #0d9488; resize: none;">{{ $chemical->safety_info }}</textarea>
            </div>

            {{-- Submit Button --}}
            <button type="submit"
                style="background: #0d9488; color: white; width: 100%; padding: 16px; border: none; border-radius: 14px; font-weight: 700; cursor: pointer; font-size: 16px; transition: background 0.2s;"
                onmouseover="this.style.background='#0f766e'" onmouseout="this.style.background='#0d9488'">
                Update Chemical
            </button>
        </form>
    </div>
@endsection
