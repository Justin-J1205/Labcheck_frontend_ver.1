<?php

namespace App\Http\Controllers;

use App\Models\Experiment;
use App\Models\Equipment;
use App\Models\Chemical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExperimentController extends Controller
{
    /**
     * For Students
     */
    public function join(Experiment $experiment)
    {
        $experiment->users()->syncWithoutDetaching([Auth::id()]);

        return redirect()->back()->with('success', 'You have joined the experiment!');
    }

    public function leave(Experiment $experiment)
    {
        $experiment->users()->detach(Auth::id());

        return redirect()->back()->with('success', 'Left the experiment.');
    }
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
            'chemicals' => 'nullable|array',
            'chemical_amounts' => 'nullable|array',
            'equipments' => 'nullable|array',
            'equipment_quantities' => 'nullable|array',
        ]);

        return DB::transaction(function () use ($request) {
            $experiment = Experiment::create([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'duration_minutes' => $request->duration_minutes,
            ]);

            // Equipment Loop
            if ($request->has('equipments')) {
                foreach ($request->equipments as $id) {
                    $qtyUsed = $request->equipment_quantities[$id] ?? 1;
                    $experiment->equipments()->attach($id, ['quantity_needed' => $qtyUsed]);
                    Equipment::where('id', $id)->decrement('quantity', $qtyUsed);
                }
            }

            // Chemical Loop
            if ($request->has('chemicals')) {
                foreach ($request->chemicals as $id) {
                    $amountUsed = $request->chemical_amounts[$id] ?? 0;
                    if ($amountUsed > 0) {
                        $experiment->chemicals()->attach($id, ['amount_needed' => $amountUsed]);
                        Chemical::where('id', $id)->decrement('amount', $amountUsed);
                    }
                }
            }

            return redirect()->route('experiments.index')->with('success', 'Experiment created!');
        });
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

        return DB::transaction(function () use ($experiment) {
            foreach ($experiment->equipments as $equipment) {
                $equipment->increment('quantity', 1);
            }
            $experiment->delete();
            return redirect()->route('experiments.index')->with('success', 'Experiment deleted.');
        });
    }
}
