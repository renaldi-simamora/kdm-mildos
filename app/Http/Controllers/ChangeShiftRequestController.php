<?php

namespace App\Http\Controllers;

use App\Models\ChangeShiftRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChangeShiftRequestController extends Controller
{
    /**
     * Display a listing of change shift requests.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $date = $request->query('date');

        $changeShiftRequests = ChangeShiftRequest::query()
            ->with(['employee', 'delegateEmployee', 'shift'])
            ->when($search, fn ($q) => $q->search($search))
            ->when($status && $status !== 'all', fn ($q) => $q->where('status', $status))
            ->when($date, fn ($q) => $q->whereDate('request_date', $date))
            ->latest('requested_at')
            ->paginate(15)
            ->withQueryString();

        return view('form-requests.change-shift-requests.index', [
            'changeShiftRequests' => $changeShiftRequests,
            'search' => $search,
            'status' => $status,
            'date' => $date,
        ]);
    }

    /**
     * Update the status of a change shift request.
     */
    public function updateStatus(Request $request, ChangeShiftRequest $changeShiftRequest): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:In Review,Approved,Rejected'],
        ]);

        $changeShiftRequest->update([
            'status' => $request->string('status')->value(),
        ]);

        return redirect()->back()->with('success', 'Status pengajuan tukar shift berhasil diperbarui.');
    }

    /**
     * Remove the specified change shift request.
     */
    public function destroy(ChangeShiftRequest $changeShiftRequest): RedirectResponse
    {
        $changeShiftRequest->delete();

        return redirect()->back()->with('success', 'Pengajuan tukar shift berhasil dihapus.');
    }
}
