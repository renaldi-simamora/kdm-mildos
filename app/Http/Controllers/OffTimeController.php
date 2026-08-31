<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOffTimeRequest;
use App\Models\Employee;
use App\Models\OffTime;
use App\Models\OffTimeType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OffTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $offTimes = OffTime::query()
            ->with(['employee', 'offTimeType', 'approver'])
            ->search($search)
            ->filterStatus($status)
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('off-times.index', [
            'offTimes' => $offTimes,
            'search' => $search,
            'status' => $status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $employees = Employee::query()
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'employee_code', 'location', 'department']);

        $categories = OffTimeType::query()
            ->active()
            ->orderBy('name', 'asc')
            ->get();

        $locations = Employee::query()
            ->whereNotNull('location')
            ->distinct()
            ->pluck('location');

        return view('off-times.create', [
            'employees' => $employees,
            'categories' => $categories,
            'locations' => $locations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOffTimeRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['off_time_type_id'] = $data['off_time_category_id'];
        unset($data['off_time_category_id']);

        if (empty($data['location']) && ! empty($data['employee_id'])) {
            $emp = Employee::find($data['employee_id']);
            $data['location'] = $emp?->location;
        }

        if (in_array($data['status'], ['Approved', 'Rejected'])) {
            $data['approver_id'] = auth()->id();
        }

        OffTime::create($data);

        return redirect()->route('off-times.index')
            ->with('success', 'Pengajuan Off Time berhasil disimpan.');
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, OffTime $offTime): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:Draft,Pending,Approved,Rejected'],
        ]);

        $offTime->update([
            'status' => $request->string('status')->value(),
            'approver_id' => auth()->id(),
        ]);

        return redirect()->route('off-times.index')
            ->with('success', 'Status Off Time berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OffTime $offTime): RedirectResponse
    {
        $offTime->delete();

        return redirect()->route('off-times.index')
            ->with('success', 'Data Off Time berhasil dihapus.');
    }
}
