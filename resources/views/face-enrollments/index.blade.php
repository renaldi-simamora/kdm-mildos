@extends('layouts.admin')

@section('title', 'Employee Face Enrollments')

@section('content')

    {{-- BREADCRUMB CARD --}}
    <div class="breadcrumb-card">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="divider">/</span>
        <a href="{{ route('face-enrollments.index') }}">Employee Face Enrollments</a>
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
    <div class="main-card">

        {{-- TOP BAR WITH SEARCH ON THE RIGHT --}}
        <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
            <form method="GET" action="{{ route('face-enrollments.index') }}" style="display: flex; align-items: center;">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search }}" 
                    placeholder="Search" 
                    class="filter-input" 
                    style="border-top-right-radius: 0; border-bottom-right-radius: 0; border-right: none; width: 220px;"
                >
                <button 
                    type="submit" 
                    class="btn-primary-orange" 
                    style="border-top-left-radius: 0; border-bottom-left-radius: 0; height: 38px; padding: 0 14px;"
                    title="Search"
                >
                    <span data-lucide="search" style="width: 16px; height: 16px;"></span>
                </button>
            </form>
        </div>

        {{-- DATA TABLE --}}
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">NO</th>
                        <th>DEPARTEMENT</th>
                        <th>EMPLOYEE</th>
                        <th>STATUS</th>
                        <th style="width: 80px; text-align: center;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($enrollments as $index => $item)
                        <tr x-data="{ openAction: false }">
                            <td style="font-weight: 500; color: #64748b;">
                                {{ $enrollments->firstItem() + $index }}
                            </td>
                            <td style="font-weight: 600; color: #334155; text-transform: uppercase;">
                                {{ $item->department }}
                            </td>
                            <td style="font-weight: 600; color: #0f172a;">
                                {{ $item->employee_name }}
                            </td>
                            <td>
                                @if (strtolower($item->status) === 'pending')
                                    <span class="badge-pending">Pending</span>
                                @elseif (strtolower($item->status) === 'approved')
                                    <span class="badge-approved">Approved</span>
                                @else
                                    <span class="badge-rejected">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td style="text-align: center; position: relative;">
                                <div style="display: inline-block; position: relative;">
                                    <button 
                                        type="button" 
                                        class="action-dropdown-btn" 
                                        @click="openAction = !openAction"
                                        @click.outside="openAction = false"
                                    >
                                        <span data-lucide="more-vertical" style="width: 16px; height: 16px;"></span>
                                    </button>

                                    {{-- ACTION DROPDOWN MENU --}}
                                    <div 
                                        x-show="openAction" 
                                        x-transition 
                                        style="position: absolute; right: 0; top: 100%; z-index: 30; min-width: 160px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 4px 0; text-align: left; display: none;"
                                    >
                                        <form method="POST" action="{{ route('face-enrollments.update-status', $item) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Approved">
                                            <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 8px 14px; font-size: 12.5px; color: #16a34a; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='none'">
                                                <span data-lucide="check" style="width: 14px; height: 14px;"></span>
                                                Set Approved
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('face-enrollments.update-status', $item) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Pending">
                                            <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 8px 14px; font-size: 12.5px; color: #d97706; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='none'">
                                                <span data-lucide="clock" style="width: 14px; height: 14px;"></span>
                                                Set Pending
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('face-enrollments.update-status', $item) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Rejected">
                                            <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 8px 14px; font-size: 12.5px; color: #dc2626; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='none'">
                                                <span data-lucide="x" style="width: 14px; height: 14px;"></span>
                                                Set Rejected
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                    <span data-lucide="inbox" style="width: 36px; height: 36px; stroke-width: 1.5;"></span>
                                    <span>Tidak ada data pendaftaran wajah yang ditemukan.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if ($enrollments->hasPages())
            <div style="margin-top: 24px; display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: #64748b;">
                <div>
                    Menampilkan {{ $enrollments->firstItem() }} sampai {{ $enrollments->lastItem() }} dari {{ $enrollments->total() }} data
                </div>
                <div>
                    {{ $enrollments->links() }}
                </div>
            </div>
        @endif

    </div>

@endsection
