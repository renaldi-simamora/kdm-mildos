@extends('layouts.admin')

@section('title', 'Employees')

@section('content')

    {{-- BREADCRUMB CARD --}}
    <div class="breadcrumb-card">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="divider">/</span>
        <a href="{{ route('employees.index') }}">Employees</a>
        <span class="divider">/</span>
        <span class="active-crumb">List</span>
    </div>

    @if (session('success'))
        <div class="alert-success">
            <span data-lucide="check-circle" style="width: 18px; height: 18px;"></span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- MAIN CARD --}}
    <div class="main-card" x-data="{ createModalOpen: false }">

        {{-- TOP ACTION BUTTON --}}
        <div style="margin-bottom: 20px;">
            <button type="button" class="btn-primary-orange" @click="createModalOpen = true">
                <span data-lucide="plus" style="width: 16px; height: 16px;"></span>
                <span>Create Employee</span>
            </button>
        </div>

        {{-- FILTER BAR --}}
        <form method="GET" action="{{ route('employees.index') }}" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 20px;">
            
            {{-- Status Filter --}}
            <div>
                <select name="status" class="filter-select">
                    <option value="">All Statuses</option>
                    @foreach ($statuses as $st)
                        <option value="{{ $st }}" {{ $selectedStatus === $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Department Filter --}}
            <div>
                <select name="department" class="filter-select">
                    <option value="">All Departements</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept }}" {{ $selectedDepartment === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Search Input --}}
            <div style="flex: 1; min-width: 200px;">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search" class="filter-input" style="width: 100%;">
            </div>

            {{-- Reset & Submit Buttons --}}
            <a href="{{ route('employees.index') }}" class="btn-reset-gray">
                Reset Filter
            </a>
            
            <button type="submit" class="btn-primary-orange" style="padding: 8px 24px;">
                Filter
            </button>
        </form>

        {{-- DATA TABLE --}}
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">NO</th>
                        <th>EMPLOYEE CODE</th>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>JOB TITLE</th>
                        <th>LOCATION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $index => $employee)
                        <tr>
                            <td style="font-weight: 500; color: #64748b;">
                                {{ $employees->firstItem() + $index }}
                            </td>
                            <td style="font-weight: 600; color: #1e293b;">
                                {{ $employee->employee_code }}
                            </td>
                            <td style="font-weight: 600; color: #0f172a;">
                                {{ $employee->name }}
                            </td>
                            <td style="color: #64748b;">
                                {{ $employee->email ?? '-' }}
                            </td>
                            <td style="color: #475569;">
                                {{ $employee->job_title ?? '-' }}
                            </td>
                            <td style="color: #475569;">
                                {{ $employee->location ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                    <span data-lucide="inbox" style="width: 36px; height: 36px; stroke-width: 1.5;"></span>
                                    <span>Tidak ada data employee yang ditemukan.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if ($employees->hasPages())
            <div style="margin-top: 24px; display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: #64748b;">
                <div>
                    Menampilkan {{ $employees->firstItem() }} sampai {{ $employees->lastItem() }} dari {{ $employees->total() }} data
                </div>
                <div>
                    {{ $employees->links() }}
                </div>
            </div>
        @endif

        {{-- CREATE EMPLOYEE MODAL --}}
        <div class="modal-backdrop" x-show="createModalOpen" x-transition style="display: none;">
            <div class="modal-content" @click.outside="createModalOpen = false">
                <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                    <div style="font-size: 16px; font-weight: 800; color: #0f172a;">Create New Employee</div>
                    <button type="button" @click="createModalOpen = false" style="background: none; border: none; cursor: pointer; color: #94a3b8;">
                        <span data-lucide="x" style="width: 18px; height: 18px;"></span>
                    </button>
                </div>

                <form method="POST" action="{{ route('employees.store') }}" style="padding: 24px;">
                    @csrf

                    <div style="display: flex; flex-direction: column; gap: 14px;">
                        <div>
                            <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 4px;">Employee Code (Optional)</label>
                            <input type="text" name="employee_code" placeholder="e.g. MLD0014 (Auto generated if empty)" class="filter-input" style="width: 100%;">
                        </div>

                        <div>
                            <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 4px;">Full Name *</label>
                            <input type="text" name="name" required placeholder="Employee full name" class="filter-input" style="width: 100%;">
                        </div>

                        <div>
                            <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 4px;">Email Address</label>
                            <input type="email" name="email" placeholder="e.g. employee@mildos.com" class="filter-input" style="width: 100%;">
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 4px;">Job Title</label>
                                <input type="text" name="job_title" placeholder="e.g. HRD / Staff" class="filter-input" style="width: 100%;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 4px;">Departement</label>
                                <input type="text" name="department" placeholder="e.g. MILDOS RETAIL" class="filter-input" style="width: 100%;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 4px;">Location</label>
                                <input type="text" name="location" value="Mildos Gading Serpong" class="filter-input" style="width: 100%;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 4px;">Status *</label>
                                <select name="status" class="filter-select" style="width: 100%;">
                                    <option value="Active" selected>Active</option>
                                    <option value="Internship">Internship</option>
                                    <option value="Part Time">Part Time</option>
                                    <option value="Resigned">Resigned</option>
                                    <option value="Blacklisted">Blacklisted</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 24px; display: flex; justify-content: flex-end; gap: 10px;">
                        <button type="button" @click="createModalOpen = false" class="btn-reset-gray">
                            Cancel
                        </button>
                        <button type="submit" class="btn-primary-orange">
                            Save Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection
