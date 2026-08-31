<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceRequestController extends Controller
{
    /**
     * Display a listing of attendance requests.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $date = $request->query('date');

        $attendanceRequests = AttendanceRequest::query()
            ->with(['employee'])
            ->when($search, fn ($q) => $q->search($search))
            ->when($status && $status !== 'all', fn ($q) => $q->where('status', $status))
            ->when($date, fn ($q) => $q->whereDate('request_date', $date))
            ->latest('requested_at')
            ->paginate(15)
            ->withQueryString();

        return view('form-requests.attendance-requests.index', [
            'attendanceRequests' => $attendanceRequests,
            'search' => $search,
            'status' => $status,
            'date' => $date,
        ]);
    }

    /**
     * Update the status of an attendance request.
     */
    public function updateStatus(Request $request, AttendanceRequest $attendanceRequest): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:In Review,Approved,Rejected'],
        ]);

        $attendanceRequest->update([
            'status' => $request->string('status')->value(),
        ]);

        return redirect()->back()->with('success', 'Status pengajuan presensi berhasil diperbarui.');
    }

    /**
     * Remove the specified attendance request.
     */
    public function destroy(AttendanceRequest $attendanceRequest): RedirectResponse
    {
        $attendanceRequest->delete();

        return redirect()->back()->with('success', 'Pengajuan presensi berhasil dihapus.');
    }
}
