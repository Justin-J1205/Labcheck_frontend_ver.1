<?php

namespace App\Http\Controllers;

use App\Models\Experiment;
use App\Models\Equipment;
use App\Models\Chemical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperimentController extends Controller
{
    /**
     * Display a listing of experiments.
     */
    public function index()
    {
        $experiments = Experiment::with(['chemicals', 'equipments'])->get();
        return view('Experiments.index', compact('experiments'));
    }

    /**
     * Show the form for creating a new experiment.
     */
    public function create()
    {
        if (Auth::user()->role === 'student') abort(403);

        $equipments = Equipment::all();
        $chemicals = Chemical::all();

        return view('Experiments.create', compact('equipments', 'chemicals'));
    }

    /**
     * Store a newly created experiment in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role === 'student') abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'duration_minutes' => 'required|integer',
        ]);

        // 1. Create the Experiment
        $experiment = Experiment::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'duration_minutes' => $request->duration_minutes,
        ]);

        // 2. Equipment Loop 
        if ($request->has('equipments')) {
            foreach ($request->equipments as $id) {
                $experiment->equipments()->attach($id);
                // Equipment table has 'quantity' column
                \App\Models\Equipment::where('id', $id)->decrement('quantity', 1);
            }
        }

        // 3. Chemical Loop
        if ($request->has('chemicals')) {
            foreach ($request->chemicals as $index => $id) {
                $amountUsed = $request->chemical_amounts[$index] ?? 0;

                // Attach to pivot table
                $experiment->chemicals()->attach($id, ['amount_needed' => $amountUsed]);

                \App\Models\Chemical::where('id', $id)->decrement('amount', $amountUsed);
            }
        }

        return redirect()->route('experiments.index')->with('success', 'Experiment created! Inventory counts updated.');
    }

    /**
     * Display the specified experiment.
     */
    public function show($id)
    {
        $experiment = Experiment::with(['chemicals', 'equipments'])->findOrFail($id);
        return view('Experiments.show', compact('experiment'));
    }

    /**
     * Remove the specified experiment from storage.
     */
    public function destroy(Experiment $experiment)
    {
        if (Auth::user()->role === 'student') abort(403);

        // ONLY return equipment to the inventory count
        foreach ($experiment->equipments as $equipment) {
            $equipment->increment('quantity', 1);
        }

        $experiment->delete();

        return redirect()->route('experiments.index')->with('success', 'Experiment deleted. Equipment has been restocked.');
    }
}
