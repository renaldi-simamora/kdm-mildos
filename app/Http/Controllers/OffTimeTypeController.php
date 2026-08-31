<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOffTimeTypeRequest;
use App\Http\Requests\UpdateOffTimeTypeRequest;
use App\Models\OffTimeType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OffTimeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $offTimeTypes = OffTimeType::query()
            ->search($search)
            ->orderBy('id', 'asc')
            ->paginate(15)
            ->withQueryString();

        return view('off-time-types.index', [
            'offTimeTypes' => $offTimeTypes,
            'search' => $search,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOffTimeTypeRequest $request): RedirectResponse
    {
        OffTimeType::create($request->validated());

        return redirect()->route('off-time-types.index')
            ->with('success', 'Kategori Off Time berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOffTimeTypeRequest $request, OffTimeType $offTimeType): RedirectResponse
    {
        $offTimeType->update($request->validated());

        return redirect()->route('off-time-types.index')
            ->with('success', 'Kategori Off Time berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OffTimeType $offTimeType): RedirectResponse
    {
        $offTimeType->delete();

        return redirect()->route('off-time-types.index')
            ->with('success', 'Kategori Off Time berhasil dihapus.');
    }

    /**
     * Toggle status between Active and Inactive.
     */
    public function toggleStatus(OffTimeType $offTimeType): RedirectResponse
    {
        $newStatus = $offTimeType->status === 'Active' ? 'Inactive' : 'Active';
        $offTimeType->update(['status' => $newStatus]);

        return redirect()->route('off-time-types.index')
            ->with('success', "Status kategori berhasil diubah menjadi {$newStatus}.");
    }
}
