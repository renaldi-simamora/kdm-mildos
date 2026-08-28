<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Shift;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShiftController extends Controller
{
    /**
     * Display the shift management list.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $shifts = Shift::query()
            ->search($search)
            ->orderBy('department')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        // Dynamic departments from employees table — no hardcoding
        $departments = Employee::query()
            ->whereNotNull('department')
            ->distinct()
            ->orderBy('department')
            ->pluck('department');

        return view('shifts.index', [
            'shifts' => $shifts,
            'departments' => $departments,
            'search' => $search,
        ]);
    }

    /**
     * Store a new shift.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'department' => ['required', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:150'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
            'early_tolerance_minutes' => ['required', 'integer', 'min:0'],
            'late_tolerance_minutes' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:Active,Inactive'],
        ]);

        Shift::create($validated);

        return redirect()->route('shifts.index')
            ->with('success', 'Shift berhasil ditambahkan.');
    }

    /**
     * Update an existing shift.
     */
    public function update(Request $request, Shift $shift): RedirectResponse
    {
        $validated = $request->validate([
            'department' => ['required', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:150'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
            'early_tolerance_minutes' => ['required', 'integer', 'min:0'],
            'late_tolerance_minutes' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:Active,Inactive'],
        ]);

        $shift->update($validated);

        return redirect()->route('shifts.index')
            ->with('success', 'Shift berhasil diperbarui.');
    }

    /**
     * Delete a shift.
     */
    public function destroy(Shift $shift): RedirectResponse
    {
        $shift->delete();

        return redirect()->route('shifts.index')
            ->with('success', 'Shift berhasil dihapus.');
    }

    /**
     * Toggle shift status between Active and Inactive.
     */
    public function updateStatus(Shift $shift): RedirectResponse
    {
        $shift->update([
            'status' => $shift->status === 'Active' ? 'Inactive' : 'Active',
        ]);

        return redirect()->route('shifts.index')
            ->with('success', 'Status shift berhasil diperbarui.');
    }
}
