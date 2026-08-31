@extends('layouts.admin')

@section('title', 'Attendance Requests')

@section('content')

    {{-- BREADCRUMB --}}
    <div class="breadcrumb-card">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="divider">/</span>
        <a href="{{ route('attendance-requests.index') }}">Attendance Requests</a>
        <span class="divider">/</span>
        <span class="active-crumb">List</span>
    </div>

    {{-- MAIN CARD --}}
    <div class="main-card">

        {{-- FLASH MESSAGES --}}
        @if (session('success'))
            <div class="alert-success" style="margin-bottom: 20px;">
                <span data-lucide="check-circle-2" style="width:16px; height:16px; flex-shrink:0;"></span>
                {{ session('success') }}
            </div>
        @endif

        {{-- FILTER BAR --}}
        <form method="GET" action="{{ route('attendance-requests.index') }}" style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center; margin-bottom: 24px;">
            {{-- Status Filter --}}
            <select name="status" class="filter-select" style="min-width: 160px; height: 38px;">
                <option value="all" {{ empty($status) || $status === 'all' ? 'selected' : '' }}>All Status</option>
                <option value="In Review" {{ $status === 'In Review' ? 'selected' : '' }}>In Review</option>
                <option value="Approved" {{ $status === 'Approved' ? 'selected' : '' }}>Approved</option>
                <option value="Rejected" {{ $status === 'Rejected' ? 'selected' : '' }}>Rejected</option>
            </select>

            {{-- Date Filter --}}
            <input
                type="date"
                name="date"
                class="filter-input"
                placeholder="Choose Dates"
                value="{{ $date }}"
                style="min-width: 170px; height: 38px;"
            >

            {{-- Search Input --}}
            <input
                type="text"
                name="search"
                class="filter-input"
                placeholder="Search"
                value="{{ $search }}"
                style="min-width: 220px; flex: 1; height: 38px;"
            >

            {{-- Buttons --}}
            <button type="submit" class="btn-primary-orange" style="background: #FFA800; height: 38px; padding: 0 20px;">
                Filter
            </button>

            @if ($search || ($status && $status !== 'all') || $date)
                <a href="{{ route('attendance-requests.index') }}" class="btn-reset-gray" style="height: 38px; padding: 0 16px; display: inline-flex; align-items: center;">
                    Reset Filter
                </a>
            @endif
        </form>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="data-table" id="attendance-requests-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">NO</th>
                        <th>EMPLOYEE</th>
                        <th>REQUEST DATE</th>
                        <th>CLOCK IN</th>
                        <th>CLOCK OUT</th>
                        <th>REQUESTED AT</th>
                        <th>STATUS</th>
                        <th style="width: 70px; text-align: center;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendanceRequests as $index => $req)
                        <tr>
                            <td style="color: #94a3b8; font-size: 13px;">
                                {{ ($attendanceRequests->currentPage() - 1) * $attendanceRequests->perPage() + $loop->iteration }}
                            </td>
                            <td style="font-weight: 600; color: #1e293b;">
                                {{ $req->employee?->name ?? '-' }}
                            </td>
                            <td style="color: #475569;">
                                {{ $req->request_date?->format('d M Y') ?? '-' }}
                            </td>
                            <td style="color: #475569;">
                                {{ $req->clock_in ?? '-' }}
                            </td>
                            <td style="color: #475569;">
                                {{ $req->clock_out ?? '-' }}
                            </td>
                            <td style="color: #475569;">
                                {{ $req->requested_at?->format('d M Y, H:i') ?? '-' }}
                            </td>
                            <td>
                                @if ($req->status === 'Approved')
                                    <span style="display: inline-block; background: #22c55e; color: #fff; font-size: 11.5px; font-weight: 700; padding: 4px 14px; border-radius: 6px;">
                                        Approved
                                    </span>
                                @elseif ($req->status === 'Rejected')
                                    <span style="display: inline-block; background: #ef4444; color: #fff; font-size: 11.5px; font-weight: 700; padding: 4px 14px; border-radius: 6px;">
                                        Rejected
                                    </span>
                                @else
                                    <span style="display: inline-block; background: #FFA800; color: #fff; font-size: 11.5px; font-weight: 700; padding: 4px 14px; border-radius: 6px;">
                                        In Review
                                    </span>
                                @endif
                            </td>
                            <td style="text-align: center; position: relative;">
                                <div x-data="{ open: false }" style="display: inline-block; position: relative;">
                                    <button
                                        type="button"
                                        class="action-dropdown-btn"
                                        @click="open = !open"
                                        @click.outside="open = false"
                                    >
                                        <span data-lucide="more-vertical" style="width: 16px; height: 16px;"></span>
                                    </button>

                                    <div
                                        x-show="open"
                                        x-transition
                                        style="
                                            position: absolute; right: 0; top: 100%; z-index: 30;
                                            background: #fff; border: 1px solid #e2e8f0; border-radius: 8px;
                                            box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 140px; padding: 4px 0; text-align: left;
                                        "
                                    >
                                        @if ($req->status !== 'Approved')
                                            <form method="POST" action="{{ route('attendance-requests.update-status', $req) }}" style="display: block;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="Approved">
                                                <button
                                                    type="submit"
                                                    style="width: 100%; padding: 8px 14px; font-size: 13px; color: #16a34a; background: none; border: none; text-align: left; cursor: pointer; display: flex; align-items: center; gap: 6px;"
                                                    onmouseover="this.style.background='#f0fdf4'"
                                                    onmouseout="this.style.background='none'"
                                                >
                                                    <span data-lucide="check" style="width: 14px; height: 14px;"></span>
                                                    Approve
                                                </button>
                                            </form>
                                        @endif

                                        @if ($req->status !== 'Rejected')
                                            <form method="POST" action="{{ route('attendance-requests.update-status', $req) }}" style="display: block;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="Rejected">
                                                <button
                                                    type="submit"
                                                    style="width: 100%; padding: 8px 14px; font-size: 13px; color: #dc2626; background: none; border: none; text-align: left; cursor: pointer; display: flex; align-items: center; gap: 6px;"
                                                    onmouseover="this.style.background='#fef2f2'"
                                                    onmouseout="this.style.background='none'"
                                                >
                                                    <span data-lucide="x" style="width: 14px; height: 14px;"></span>
                                                    Reject
                                                </button>
                                            </form>
                                        @endif

                                        <form method="POST" action="{{ route('attendance-requests.destroy', $req) }}" style="display: block;" onsubmit="return confirm('Hapus pengajuan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                style="width: 100%; padding: 8px 14px; font-size: 13px; color: #ef4444; background: none; border: none; text-align: left; cursor: pointer; display: flex; align-items: center; gap: 6px;"
                                                onmouseover="this.style.background='#fef2f2'"
                                                onmouseout="this.style.background='none'"
                                            >
                                                <span data-lucide="trash-2" style="width: 14px; height: 14px;"></span>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: #94a3b8; padding: 32px;">
                                No Data Available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if ($attendanceRequests->hasPages())
            <div style="margin-top: 24px; display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: #64748b;">
                <div>
                    Menampilkan {{ $attendanceRequests->firstItem() }} sampai {{ $attendanceRequests->lastItem() }} dari {{ $attendanceRequests->total() }} data
                </div>
                <div>
                    {{ $attendanceRequests->links() }}
                </div>
            </div>
        @endif

    </div>

@endsection
