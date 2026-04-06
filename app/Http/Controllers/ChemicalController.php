<?php

namespace App\Http\Controllers;

use App\Models\Chemical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChemicalController extends Controller
{
    /**
     * Display the catalog list for everyone.
     */
    public function index()
    {
        $chemicals = Chemical::all();
        return view('Catalog.index', compact('chemicals'));
    }

    /**
     * Show the form to add a new chemical (Staff Only).
     */
    public function create()
    {
        if (Auth::user()->role !== 'staff') abort(403);
        return view('Catalog.create');
    }

    /**
     * Save the new chemical (Staff Only).
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'staff') abort(403);

        $validated = $request->validate([
            'name' => 'required|string',
            'formula' => 'required|string',
            'amount' => 'required|numeric',
            'safety_info' => 'nullable|string',
        ]);

        Chemical::create($validated);

        return redirect()->route('catalog.index')->with('success', 'Chemical added!');
    }

    /**
     * Show the Edit Form.
     */
    public function edit(Chemical $catalog)
    {
        if (Auth::user()->role !== 'staff') abort(403);
        return view('Catalog.edit', ['chemical' => $catalog]);
    }

    /**
     * Update the Chemical details.
     */
    public function update(Request $request, Chemical $catalog)
    {
        if (Auth::user()->role !== 'staff') abort(403);

        $validated = $request->validate([
            'name' => 'required|string',
            'formula' => 'required|string',
            'amount' => 'required|numeric',
            'safety_info' => 'nullable|string',
        ]);

        $catalog->update($validated);

        return redirect()->route('catalog.index')->with('success', 'Chemical updated!');
    }

    /**
     * Updates Status
     */
    public function toggleStatus(Chemical $catalog)
    {
        if (Auth::user()->role !== 'staff') abort(403);

        $catalog->update([
            'is_available' => !$catalog->is_available
        ]);

        return back()->with('success', 'Status updated!');
    }

    /**
     * Removes a Chemical
     */
    public function destroy(Chemical $catalog)
    {
        if (Auth::user()->role !== 'staff') abort(403);

        $catalog->delete();

        return redirect()->route('catalog.index')->with('success', 'Chemical removed.');
    }
}
