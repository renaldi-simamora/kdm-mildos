@extends('layouts.admin')

@section('title', 'Attendance Reports')

@section('content')

    {{-- BREADCRUMB --}}
    <div class="breadcrumb-card">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="divider">/</span>
        <a href="{{ route('attendances.reports') }}">Reports Attendances</a>
        <span class="divider">/</span>
        <span class="active-crumb">List</span>
    </div>

    {{-- MAIN CARD --}}
    <div class="main-card">

        {{-- HEADER / ACTIONS ROW --}}
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
            <div style="font-size: 15px; font-weight: 700; color: #1e293b;">
                Rekapitulasi Presensi Karyawan
            </div>

            {{-- Search & Month Bar --}}
            <form method="GET" action="{{ route('attendances.reports') }}" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                <input
                    type="month"
                    name="month"
                    class="filter-input"
                    value="{{ $month }}"
                    style="min-width: 160px; height: 38px;"
                >
                <input
                    type="text"
                    name="search"
                    id="report-search"
                    class="filter-input"
                    placeholder="Search"
                    value="{{ $search }}"
                    style="min-width: 240px; height: 38px;"
                >
                <button type="submit" style="
                    height: 38px; width: 42px; border-radius: 8px;
                    background: #FFA800; border: none; cursor: pointer;
                    display: flex; align-items: center; justify-content: center;
                    color: #fff; flex-shrink: 0;
                ">
                    <span data-lucide="search" style="width:16px; height:16px;"></span>
                </button>
                @if ($search || $month !== now()->format('Y-m'))
                    <a href="{{ route('attendances.reports') }}" class="btn-reset-gray" style="height:38px; display:inline-flex; align-items:center;">Reset</a>
                @endif
            </form>
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="data-table" id="reports-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">NO</th>
                        <th>DEPARTEMENT</th>
                        <th>EMPLOYEE</th>
                        <th style="text-align: center;">PRESENT</th>
                        <th style="text-align: center;">LATE</th>
                        <th style="text-align: center;">ABSENT</th>
                        <th style="text-align: center;">EXCUSED</th>
                        <th style="text-align: center;">OVERTIME</th>
                        <th style="width: 70px; text-align: center;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reportData as $index => $row)
                        <tr>
                            <td style="color: #94a3b8; font-size: 13px;">
                                {{ ($employees->currentPage() - 1) * $employees->perPage() + $loop->iteration }}
                            </td>
                            <td style="font-weight: 600; color: #1e293b;">
                                {{ $row['department'] }}
                            </td>
                            <td style="color: #334155; font-weight: 500;">
                                {{ $row['employee']->name }}
                            </td>
                            <td style="text-align: center; font-weight: 600; color: #16a34a;">
                                {{ $row['present'] }}
                            </td>
                            <td style="text-align: center; font-weight: 600; color: #f59e0b;">
                                {{ $row['late'] }}
                            </td>
                            <td style="text-align: center; font-weight: 600; color: #ef4444;">
                                {{ $row['absent'] }}
                            </td>
                            <td style="text-align: center; font-weight: 600; color: #3b82f6;">
                                {{ $row['excused'] }}
                            </td>
                            <td style="text-align: center; font-weight: 600; color: #64748b;">
                                {{ $row['overtime'] }}
                            </td>
                            <td style="text-align: center;">
                                <a
                                    href="{{ route('attendances.index', ['search' => $row['employee']->name]) }}"
                                    class="action-dropdown-btn"
                                    title="Lihat Log Presensi"
                                >
                                    <span data-lucide="more-vertical" style="width: 16px; height: 16px;"></span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; color: #94a3b8; padding: 32px;">
                                No Data Available
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

    </div>

@endsection
