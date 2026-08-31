<?php

namespace App\Http\Controllers;

use App\Models\OffTimeRequest;
use App\Models\OffTimeType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OffTimeRequestController extends Controller
{
    /**
     * Display a listing of off time requests.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $category = $request->query('category');
        $date = $request->query('date');

        $categories = OffTimeType::orderBy('name')->get();

        $offTimeRequests = OffTimeRequest::query()
            ->with(['employee', 'offTimeType'])
            ->when($search, fn ($q) => $q->search($search))
            ->when($status && $status !== 'all', fn ($q) => $q->where('status', $status))
            ->when($category && $category !== 'all', fn ($q) => $q->where('off_time_type_id', $category))
            ->when($date, fn ($q) => $q->whereDate('start_date', '<=', $date)->where(function ($sub) use ($date) {
                $sub->whereDate('end_date', '>=', $date)->orWhereNull('end_date');
            }))
            ->latest('requested_at')
            ->paginate(15)
            ->withQueryString();

        return view('form-requests.off-time-requests.index', [
            'offTimeRequests' => $offTimeRequests,
            'categories' => $categories,
            'search' => $search,
            'status' => $status,
            'category' => $category,
            'date' => $date,
        ]);
    }

    /**
     * Update the status of an off time request.
     */
    public function updateStatus(Request $request, OffTimeRequest $offTimeRequest): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:In Review,Approved,Rejected'],
        ]);

        $offTimeRequest->update([
            'status' => $request->string('status')->value(),
        ]);

        return redirect()->back()->with('success', 'Status pengajuan Off Time berhasil diperbarui.');
    }

    /**
     * Remove the specified off time request.
     */
    public function destroy(OffTimeRequest $offTimeRequest): RedirectResponse
    {
        $offTimeRequest->delete();

        return redirect()->back()->with('success', 'Pengajuan Off Time berhasil dihapus.');
    }
}
