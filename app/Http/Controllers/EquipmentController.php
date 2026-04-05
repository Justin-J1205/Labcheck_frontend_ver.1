<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::all();
        return view('Equipments.index', compact('equipments'));
    }

    public function create()
    {
        if (Auth::user()->role === 'student') abort(403);
        return view('Equipments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Equipment::create($validated);
        return redirect()->route('equipments.index')->with('success', 'Asset added!');
    }

    public function show($id)
    {
        // This loads the equipment AND the experiments it belongs to
        $equipment = Equipment::with('experiments')->findOrFail($id);
        return view('Equipments.show', compact('equipment'));
    }

    public function edit(Equipment $equipment)
    {
        if (Auth::user()->role === 'student') abort(403);
        return view('Equipments.edit', compact('equipment'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'status' => 'required|string',
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $equipment->update($validated);
        return redirect()->route('equipments.index')->with('success', 'Asset updated!');
    }

    public function destroy(Equipment $equipment)
    {
        if (Auth::user()->role === 'student') abort(403);
        $equipment->delete();
        return redirect()->route('equipments.index')->with('success', 'Asset deleted.');
    }
}
