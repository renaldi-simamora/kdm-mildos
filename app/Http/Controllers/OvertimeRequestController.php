<?php

namespace App\Http\Controllers;

use App\Models\OvertimeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OvertimeRequestController extends Controller
{
    /**
     * Display a listing of overtime requests.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $date = $request->query('date');

        $overtimeRequests = OvertimeRequest::query()
            ->with(['employee'])
            ->when($search, fn ($q) => $q->search($search))
            ->when($status && $status !== 'all', fn ($q) => $q->where('status', $status))
            ->when($date, fn ($q) => $q->whereDate('request_date', $date))
            ->latest('requested_at')
            ->paginate(15)
            ->withQueryString();

        return view('form-requests.overtime-requests.index', [
            'overtimeRequests' => $overtimeRequests,
            'search' => $search,
            'status' => $status,
            'date' => $date,
        ]);
    }

    /**
     * Update the status of an overtime request.
     */
    public function updateStatus(Request $request, OvertimeRequest $overtimeRequest): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:In Review,Approved,Rejected'],
        ]);

        $overtimeRequest->update([
            'status' => $request->string('status')->value(),
        ]);

        return redirect()->back()->with('success', 'Status pengajuan lembur berhasil diperbarui.');
    }

    /**
     * Remove the specified overtime request.
     */
    public function destroy(OvertimeRequest $overtimeRequest): RedirectResponse
    {
        $overtimeRequest->delete();

        return redirect()->back()->with('success', 'Pengajuan lembur berhasil dihapus.');
    }
}
