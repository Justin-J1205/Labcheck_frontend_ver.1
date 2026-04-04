<?php

namespace App\Http\Controllers;

use App\Models\Chemical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChemicalController extends Controller
{
    // Display the catalog list
    public function index()
    {
        $chemicals = Chemical::all();
        return view('Catalog.index', compact('chemicals'));
    }

    // Show the form to add a new chemical
    public function create()
    {
        return view('Catalog.create');
    }

    // Save the new chemical to the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'formula' => 'required',
            'amount' => 'required|numeric',
        ]);

        Chemical::create($request->all());

        return redirect()->route('catalog.index')->with('success', 'Chemical added successfully!');
    }
    public function toggleStatus(Chemical $chemical)
    {
        // Prevent students from performing this action
        if (auth()->user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        $chemical->update([
            'is_available' => !$chemical->is_available
        ]);

        return back()->with('success', 'Status updated!');
    }
    public function destroy(Chemical $chemical)
    {
        // Security check: Only staff can delete
        if (auth()->user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        $chemical->delete();

        return redirect()->route('catalog.index')->with('success', 'Chemical removed from catalog.');
    }
}
