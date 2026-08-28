<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $selectedStatus = $request->input('status');
        $selectedDepartment = $request->input('department');

        $query = Employee::query()
            ->search($search)
            ->filterStatus($selectedStatus)
            ->filterDepartment($selectedDepartment)
            ->orderBy('id', 'asc');

        $employees = $query->paginate(15)->withQueryString();

        $departments = Employee::whereNotNull('department')
            ->where('department', '!=', '')
            ->distinct()
            ->pluck('department')
            ->sort()
            ->values();

        $statuses = Employee::whereNotNull('status')
            ->where('status', '!=', '')
            ->distinct()
            ->pluck('status')
            ->sort()
            ->values();

        return view('employees.index', compact(
            'employees',
            'departments',
            'statuses',
            'selectedStatus',
            'selectedDepartment',
            'search'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_code' => ['nullable', 'string', 'max:50', 'unique:employees,employee_code'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        if (empty($validated['employee_code'])) {
            $latestId = Employee::max('id') ?? 0;
            $validated['employee_code'] = 'MLD'.str_pad((string) ($latestId + 1), 4, '0', STR_PAD_LEFT);
        }

        if (empty($validated['location'])) {
            $validated['location'] = 'Mildos Gading Serpong';
        }

        Employee::create($validated);

        return redirect()->route('employees.index')->with('success', 'Employee berhasil ditambahkan.');
    }
}
