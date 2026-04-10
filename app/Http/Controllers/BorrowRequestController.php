<?php

namespace App\Http\Controllers;

use App\Models\BorrowRequest;
use App\Models\Chemical;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowRequestController extends Controller
{
    /**
     * Display all borrow requests (Admin only)
     */
    public function index()
    {
        // Only staff can view all requests
        if (Auth::user()->role === 'student') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized');
        }

        $requests = BorrowRequest::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('borrow-requests.index', compact('requests'));
    }

    /**
     * Create a borrow request (Student)
     */
    public function create(Request $request)
    {
        $materialType = $request->query('type');
        $materialId = $request->query('id');

        if ($materialType === 'chemical') {
            $material = Chemical::findOrFail($materialId);
        } elseif ($materialType === 'equipment') {
            $material = Equipment::findOrFail($materialId);
        } else {
            return back()->with('error', 'Invalid material type');
        }

        return view('borrow-requests.create', compact('material', 'materialType', 'materialId'));
    }

    /**
     * Store a borrow request
     */
    public function store(Request $request)
    {
        $request->validate([
            'material_type' => 'required|in:chemical,equipment',
            'material_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'due_date' => 'required|date|after:today'
        ]);

        // Check if material exists and is available
        if ($request->material_type === 'chemical') {
            $material = Chemical::findOrFail($request->material_id);
            if (!$material->is_available) {
                return back()->with('error', 'This chemical is not available');
            }
            if ($material->amount < $request->quantity) {
                return back()->with('error', 'Insufficient quantity available');
            }
        } else {
            $material = Equipment::findOrFail($request->material_id);
            if (!$material->is_available) {
                return back()->with('error', 'This equipment is not available');
            }
            if ($material->quantity < $request->quantity) {
                return back()->with('error', 'Insufficient quantity available');
            }
        }

        // Create the borrow request
        BorrowRequest::create([
            'user_id' => Auth::id(),
            'material_type' => $request->material_type,
            'material_id' => $request->material_id,
            'quantity' => $request->quantity,
            'due_date' => $request->due_date,
        ]);

        $redirectRoute = $request->material_type === 'chemical' ? 'catalog.index' : 'equipments.index';
        return redirect()->route($redirectRoute)->with('success', 'Borrow request submitted successfully');
    }

    /**
     * Approve a borrow request (Staff/Admin only)
     */
    public function approve(BorrowRequest $borrowRequest)
    {
        if (Auth::user()->role !== 'staff' && Auth::user()->role !== 'admin') {
            return back()->with('error', 'Unauthorized');
        }

        // Update the request status
        $borrowRequest->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // Deduct from available quantity
        if ($borrowRequest->material_type === 'chemical') {
            $chemical = Chemical::find($borrowRequest->material_id);
            if ($chemical) {
                $chemical->amount -= $borrowRequest->quantity;
                if ($chemical->amount <= 0) {
                    $chemical->is_available = false;
                }
                $chemical->save();
            }
        } else {
            $equipment = Equipment::find($borrowRequest->material_id);
            if ($equipment) {
                $equipment->quantity -= $borrowRequest->quantity;
                if ($equipment->quantity <= 0) {
                    $equipment->is_available = false;
                }
                $equipment->save();
            }
        }

        return back()->with('success', 'Borrow request approved');
    }

    /**
     * Reject a borrow request (Staff/Admin only)
     */
    public function reject(Request $request, BorrowRequest $borrowRequest)
    {
        if (Auth::user()->role !== 'staff' && Auth::user()->role !== 'admin') {
            return back()->with('error', 'Unauthorized');
        }

        $request->validate([
            'reason' => 'nullable|string',
        ]);

        $borrowRequest->update([
            'status' => 'rejected',
            'reason' => $request->reason,
        ]);

        return back()->with('success', 'Borrow request rejected');
    }

    /**
     * Return borrowed materials (Student)
     */
    public function return(BorrowRequest $borrowRequest)
    {
        if (Auth::id() !== $borrowRequest->user_id && Auth::user()->role === 'student') {
            return back()->with('error', 'Unauthorized');
        }

        // Return the materials to inventory
        if ($borrowRequest->material_type === 'chemical') {
            $chemical = Chemical::find($borrowRequest->material_id);
            if ($chemical) {
                $chemical->amount += $borrowRequest->quantity;
                $chemical->is_available = true;
                $chemical->save();
            }
        } else {
            $equipment = Equipment::find($borrowRequest->material_id);
            if ($equipment) {
                $equipment->quantity += $borrowRequest->quantity;
                $equipment->is_available = true;
                $equipment->save();
            }
        }

        $borrowRequest->update([
            'status' => 'returned',
            'returned_at' => now(),
        ]);

        return back()->with('success', 'Materials returned successfully');
    }

    /**
     * View student's borrow history
     */
    public function history()
    {
        $requests = BorrowRequest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Mark overdue items
        foreach ($requests as $request) {
            if ($request->status === 'approved' && $request->due_date && now()->isAfter($request->due_date)) {
                $request->update(['is_overdue' => true]);
            }
        }

        return view('borrow-requests.history', compact('requests'));
    }

    /**
     * Check overdue borrow requests for display
     */
    public static function getOverdueCount()
    {
        return BorrowRequest::where('status', 'approved')
            ->where('is_overdue', true)
            ->where('user_id', Auth::id())
            ->count();
    }
}
