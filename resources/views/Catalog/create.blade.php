@extends('Layouts.app')

@section('content')
    <div style="padding: 30px; max-width: 800px;">
        <h1 style="font-size: 24px; font-weight: 800; color: #1e293b; margin-bottom: 20px;">Add New Chemical</h1>

        <form action="{{ route('catalog.store') }}" method="POST"
            style="background: white; padding: 30px; border-radius: 20px; border: 1px solid #f1f5f9;">
            @csrf
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Chemical Name</label>
                <input type="text" name="name" required
                    style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Formula</label>
                <input type="text" name="formula"
                    style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">In-Stock Amount</label>
                <input type="number" name="amount"
                    style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0;">
            </div>

            <div class="space-y-2">
                <label for="description" class="block text-sm font-bold text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all outline-none"
                    placeholder="e.g., Highly flammable, store in a cool dry place."></textarea>
            </div>

            <button type="submit"
                style="background: #0d9488; color: white; padding: 12px 25px; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">
                Save to Catalog
            </button>
        </form>
    </div>
@endsection
