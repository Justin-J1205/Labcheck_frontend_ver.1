@extends('Layouts.app')

@section('content')
<div style="padding: 40px 20px; max-width: 700px; margin: 0 auto;">
    {{-- Back Link --}}
    <a href="{{ route('experiments.index') }}" style="text-decoration: none; color: #64748b; font-size: 14px; display: flex; align-items: center; gap: 8px; margin-bottom: 20px;">
        ← Back to Experiments
    </a>

    <div class="card" style="padding: 40px; border-radius: 24px; background: white; border: 1px solid #f1f5f9; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #1e293b; margin: 0 0 10px 0; font-size: 24px; font-weight: 700;">Create New Experiment</h2>
        <p style="color: #64748b; margin-bottom: 30px; font-size: 15px;">Fill in the details to add a new procedure to the laboratory catalog.</p>
        
        <form action="{{ route('experiments.store') }}" method="POST">
            @csrf
            
            {{-- Title Field --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155; font-size: 14px;">Experiment Title</label>
                <input type="text" name="title" required placeholder="e.g. Volumetric Analysis" 
                    style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 15px;">
            </div>

            {{-- Category Field --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155; font-size: 14px;">Category</label>
                <input type="text" name="category" required placeholder="e.g. Organic Chemistry" 
                    style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 15px;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                {{-- Difficulty Enum --}}
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155; font-size: 14px;">Difficulty Level</label>
                    <select name="difficulty" required style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; background: white; font-size: 15px;">
                        <option value="easy">Easy</option>
                        <option value="medium" selected>Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>

                {{-- Duration Minutes --}}
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155; font-size: 14px;">Duration (Mins)</label>
                    <input type="number" name="duration_minutes" required placeholder="e.g. 60" min="1"
                        style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 15px;">
                </div>
            </div>

            {{-- Description Field --}}
            <div style="margin-bottom: 30px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155; font-size: 14px;">Instructions / Description</label>
                <textarea name="description" rows="6" required placeholder="Provide step-by-step instructions..." 
                    style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 15px; resize: none;"></textarea>
            </div>

            {{-- Action Buttons --}}
            <div style="display: flex; gap: 15px;">
                <button type="submit" 
                    style="flex: 2; padding: 14px; border-radius: 12px; background: #0d9488; color: white; border: none; font-weight: 700; cursor: pointer; font-size: 16px; transition: background 0.2s;">
                    Create Experiment
                </button>
                <a href="{{ route('experiments.index') }}" 
                    style="flex: 1; text-align: center; padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; background: #f8fafc; text-decoration: none; color: #64748b; font-weight: 600; font-size: 16px;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection