<?php

namespace App\Http\Controllers;

use App\Models\FaceEnrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaceEnrollmentController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $query = FaceEnrollment::query()
            ->search($search)
            ->orderBy('id', 'asc');

        $enrollments = $query->paginate(15)->withQueryString();

        return view('face-enrollments.index', compact('enrollments', 'search'));
    }

    public function updateStatus(Request $request, FaceEnrollment $enrollment): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:Pending,Approved,Rejected'],
        ]);

        $enrollment->update([
            'status' => $validated['status'],
        ]);

        return redirect()->route('face-enrollments.index')
            ->with('success', "Status pendaftaran wajah {$enrollment->employee_name} berhasil diperbarui menjadi {$validated['status']}.");
    }
}
