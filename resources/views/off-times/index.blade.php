@extends('layouts.admin')

@section('title', 'Off Times')

@section('content')

    {{-- BREADCRUMB --}}
    <div class="breadcrumb-card">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="divider">/</span>
        <a href="{{ route('off-times.index') }}">Off Times</a>
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

        {{-- HEADER / ACTIONS ROW --}}
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
            <a
                href="{{ route('off-times.create') }}"
                class="btn-primary-orange"
                id="btn-create-off-time"
                style="background: #FFA800;"
            >
                <span data-lucide="plus" style="width:15px; height:15px;"></span>
                Create Off Time
            </a>

            {{-- Search Bar --}}
            <form method="GET" action="{{ route('off-times.index') }}" style="display: flex; gap: 8px; align-items: center;">
                <input
                    type="text"
                    name="search"
                    id="off-time-search"
                    class="filter-input"
                    placeholder="Search"
                    value="{{ $search }}"
                    style="min-width: 240px;"
                >
                <button type="submit" style="
                    height: 38px; width: 42px; border-radius: 8px;
                    background: #FFA800; border: none; cursor: pointer;
                    display: flex; align-items: center; justify-content: center;
                    color: #fff; flex-shrink: 0;
                ">
                    <span data-lucide="search" style="width:16px; height:16px;"></span>
                </button>
                @if ($search)
                    <a href="{{ route('off-times.index') }}" class="btn-reset-gray" style="height:38px; display:inline-flex; align-items:center;">Reset</a>
                @endif
            </form>
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="data-table" id="off-times-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">NO</th>
                        <th>EMPLOYEE</th>
                        <th>APPROVER</th>
                        <th>OFF TIME CATEGORY</th>
                        <th>START DATE</th>
                        <th>END DATE</th>
                        <th>REPEAT</th>
                        <th>STATUS</th>
                        <th style="width: 70px; text-align: center;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($offTimes as $index => $offTime)
                        <tr>
                            <td style="color: #94a3b8; font-size: 13px;">
                                {{ ($offTimes->currentPage() - 1) * $offTimes->perPage() + $loop->iteration }}
                            </td>
                            <td style="font-weight: 600; color: #1e293b;">
                                {{ $offTime->employee?->name ?? 'N/A' }}
                            </td>
                            <td style="color: #475569;">
                                {{ $offTime->approver?->name ?? '-' }}
                            </td>
                            <td style="color: #475569;">
                                {{ $offTime->offTimeType?->name ?? '-' }}
                            </td>
                            <td style="color: #475569;">
                                {{ $offTime->start_date?->format('d M Y') ?? '-' }}
                            </td>
                            <td style="color: #475569;">
                                {{ $offTime->end_date?->format('d M Y') ?? '-' }}
                            </td>
                            <td style="color: #475569;">
                                {{ $offTime->recurrence_type ?? 'None' }}
                            </td>
                            <td>
                                @if ($offTime->status === 'Approved')
                                    <span style="display: inline-block; background: #22c55e; color: #fff; font-size: 11.5px; font-weight: 700; padding: 4px 14px; border-radius: 6px;">
                                        Approved
                                    </span>
                                @elseif ($offTime->status === 'Pending')
                                    <span style="display: inline-block; background: #FFA800; color: #fff; font-size: 11.5px; font-weight: 700; padding: 4px 14px; border-radius: 6px;">
                                        Pending
                                    </span>
                                @elseif ($offTime->status === 'Rejected')
                                    <span style="display: inline-block; background: #ef4444; color: #fff; font-size: 11.5px; font-weight: 700; padding: 4px 14px; border-radius: 6px;">
                                        Rejected
                                    </span>
                                @else
                                    <span style="display: inline-block; background: #94a3b8; color: #fff; font-size: 11.5px; font-weight: 700; padding: 4px 14px; border-radius: 6px;">
                                        Draft
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
                                        @if ($offTime->status !== 'Approved')
                                            <form method="POST" action="{{ route('off-times.update-status', $offTime) }}" style="display: block;">
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

                                        @if ($offTime->status !== 'Rejected')
                                            <form method="POST" action="{{ route('off-times.update-status', $offTime) }}" style="display: block;">
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

                                        <form method="POST" action="{{ route('off-times.destroy', $offTime) }}" style="display: block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                            <td colspan="9" style="text-align: center; color: #94a3b8; padding: 32px;">
                                No Data Available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if ($offTimes->hasPages())
            <div style="margin-top: 24px; display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: #64748b;">
                <div>
                    Menampilkan {{ $offTimes->firstItem() }} sampai {{ $offTimes->lastItem() }} dari {{ $offTimes->total() }} data
                </div>
                <div>
                    {{ $offTimes->links() }}
                </div>
            </div>
        @endif

    </div>

@endsection
