@extends('layouts.admin')

@section('title', 'Attendance Logs')

@section('content')

    {{-- BREADCRUMB --}}
    <div class="breadcrumb-card">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="divider">/</span>
        <a href="{{ route('attendances.index') }}">Attendances</a>
        <span class="divider">/</span>
        <span class="active-crumb">List</span>
    </div>

    {{-- SUMMARY METRIC CARDS --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        {{-- On Time --}}
        <div style="background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: relative; overflow: hidden;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: #ecfdf5; color: #16a34a; display: flex; align-items: center; justify-content: center;">
                    <span data-lucide="check" style="width: 18px; height: 18px;"></span>
                </div>
                <div style="font-size: 22px; font-weight: 800; color: #0f172a;">
                    {{ number_format($metricCounts['on_time']) }}
                </div>
            </div>
            <div style="font-size: 13px; font-weight: 600; color: #64748b;">On Time</div>
            <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: #22c55e;"></div>
        </div>

        {{-- Late --}}
        <div style="background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: relative; overflow: hidden;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: #fffbeb; color: #f59e0b; display: flex; align-items: center; justify-content: center;">
                    <span data-lucide="alert-triangle" style="width: 18px; height: 18px;"></span>
                </div>
                <div style="font-size: 22px; font-weight: 800; color: #0f172a;">
                    {{ number_format($metricCounts['late']) }}
                </div>
            </div>
            <div style="font-size: 13px; font-weight: 600; color: #64748b;">Late</div>
            <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: #f59e0b;"></div>
        </div>

        {{-- Absent --}}
        <div style="background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: relative; overflow: hidden;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: #fef2f2; color: #ef4444; display: flex; align-items: center; justify-content: center;">
                    <span data-lucide="calendar-x-2" style="width: 18px; height: 18px;"></span>
                </div>
                <div style="font-size: 22px; font-weight: 800; color: #0f172a;">
                    {{ number_format($metricCounts['absent']) }}
                </div>
            </div>
            <div style="font-size: 13px; font-weight: 600; color: #64748b;">Absent</div>
            <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: #ef4444;"></div>
        </div>

        {{-- Excused --}}
        <div style="background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: relative; overflow: hidden;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center;">
                    <span data-lucide="info" style="width: 18px; height: 18px;"></span>
                </div>
                <div style="font-size: 22px; font-weight: 800; color: #0f172a;">
                    {{ number_format($metricCounts['excused']) }}
                </div>
            </div>
            <div style="font-size: 13px; font-weight: 600; color: #64748b;">Excused</div>
            <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: #3b82f6;"></div>
        </div>

        {{-- Off Day --}}
        <div style="background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: relative; overflow: hidden;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: #f8fafc; color: #64748b; display: flex; align-items: center; justify-content: center;">
                    <span data-lucide="clock" style="width: 18px; height: 18px;"></span>
                </div>
                <div style="font-size: 22px; font-weight: 800; color: #0f172a;">
                    {{ number_format($metricCounts['off_day']) }}
                </div>
            </div>
            <div style="font-size: 13px; font-weight: 600; color: #64748b;">Off Day</div>
            <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: #94a3b8;"></div>
        </div>

        {{-- Pending --}}
        <div style="background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); position: relative; overflow: hidden;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: #fffbeb; color: #FFA800; display: flex; align-items: center; justify-content: center;">
                    <span data-lucide="clock-4" style="width: 18px; height: 18px;"></span>
                </div>
                <div style="font-size: 22px; font-weight: 800; color: #0f172a;">
                    {{ number_format($metricCounts['pending']) }}
                </div>
            </div>
            <div style="font-size: 13px; font-weight: 600; color: #64748b;">Pending</div>
            <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: #FFA800;"></div>
        </div>
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
        <form method="GET" action="{{ route('attendances.index') }}" style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center; margin-bottom: 24px;">
            {{-- Status Filter --}}
            <select name="status" class="filter-select" style="min-width: 160px; height: 38px;">
                <option value="all" {{ empty($status) || $status === 'all' ? 'selected' : '' }}>All Status</option>
                <option value="Present" {{ $status === 'Present' ? 'selected' : '' }}>Present / On Time</option>
                <option value="Late" {{ $status === 'Late' ? 'selected' : '' }}>Late</option>
                <option value="Absent" {{ $status === 'Absent' ? 'selected' : '' }}>Absent</option>
                <option value="Excused" {{ $status === 'Excused' ? 'selected' : '' }}>Excused</option>
                <option value="Off Day" {{ $status === 'Off Day' ? 'selected' : '' }}>Off Day</option>
                <option value="Pending" {{ $status === 'Pending' ? 'selected' : '' }}>Pending</option>
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

            {{-- Search Keyword --}}
            <input
                type="text"
                name="search"
                class="filter-input"
                placeholder="Search"
                value="{{ $search }}"
                style="min-width: 220px; flex: 1; height: 38px;"
            >

            {{-- Location Filter --}}
            <select name="location" class="filter-select" style="min-width: 180px; height: 38px;">
                <option value="all" {{ empty($location) || $location === 'all' ? 'selected' : '' }}>Location</option>
                @foreach ($locations as $loc)
                    <option value="{{ $loc }}" {{ $location === $loc ? 'selected' : '' }}>{{ $loc }}</option>
                @endforeach
            </select>

            {{-- Filter & Reset Buttons --}}
            <button type="submit" class="btn-primary-orange" style="background: #FFA800; height: 38px; padding: 0 20px;">
                Filter
            </button>

            @if ($search || ($status && $status !== 'all') || ($location && $location !== 'all') || $date)
                <a href="{{ route('attendances.index') }}" class="btn-reset-gray" style="height: 38px; padding: 0 16px; display: inline-flex; align-items: center;">
                    Reset Filter
                </a>
            @endif
        </form>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="data-table" id="attendances-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">NO</th>
                        <th>EMPLOYEE</th>
                        <th>DATE</th>
                        <th>LOCATION</th>
                        <th>SHIFT</th>
                        <th>CLOCK IN</th>
                        <th>CLOCK OUT</th>
                        <th>STATUS</th>
                        <th style="width: 70px; text-align: center;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $index => $att)
                        <tr>
                            <td style="color: #94a3b8; font-size: 13px;">
                                {{ ($attendances->currentPage() - 1) * $attendances->perPage() + $loop->iteration }}
                            </td>
                            <td style="font-weight: 600; color: #1e293b;">
                                {{ $att->employee?->name ?? $att->employee_name ?? 'N/A' }}
                            </td>
                            <td style="color: #475569;">
                                {{ $att->date?->format('d F Y') ?? '-' }}
                            </td>
                            <td style="color: #475569;">
                                {{ $att->location ?? $att->employee?->location ?? '-' }}
                            </td>
                            <td style="color: #475569;">
                                {{ $att->shift ?? 'Retail : Siang' }}
                            </td>
                            <td style="color: #475569;">
                                @if ($att->clock_in)
                                    {{ $att->clock_in->format('d M Y, H:i:s') }}
                                @elseif ($att->check_in_time)
                                    {{ $att->date?->format('d M Y') }}, {{ $att->check_in_time }}
                                @else
                                    -
                                @endif
                            </td>
                            <td style="color: #475569;">
                                @if ($att->clock_out)
                                    {{ $att->clock_out->format('d M Y, H:i:s') }}
                                @elseif ($att->check_out_time)
                                    {{ $att->date?->format('d M Y') }}, {{ $att->check_out_time }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusName = $att->status;
                                @endphp
                                @if (in_array($statusName, ['Present', 'On Time', 'on_time']))
                                    <span style="display: inline-block; background: #22c55e; color: #fff; font-size: 11.5px; font-weight: 700; padding: 4px 14px; border-radius: 6px;">
                                        Present
                                    </span>
                                @elseif (in_array($statusName, ['Late', 'late']))
                                    <span style="display: inline-block; background: #f59e0b; color: #fff; font-size: 11.5px; font-weight: 700; padding: 4px 14px; border-radius: 6px;">
                                        Late
                                    </span>
                                @elseif (in_array($statusName, ['Absent', 'absent']))
                                    <span style="display: inline-block; background: #ef4444; color: #fff; font-size: 11.5px; font-weight: 700; padding: 4px 14px; border-radius: 6px;">
                                        Absent
                                    </span>
                                @elseif (in_array($statusName, ['Excused', 'excused']))
                                    <span style="display: inline-block; background: #3b82f6; color: #fff; font-size: 11.5px; font-weight: 700; padding: 4px 14px; border-radius: 6px;">
                                        Excused
                                    </span>
                                @elseif (in_array($statusName, ['Off Day', 'off_day']))
                                    <span style="display: inline-block; background: #94a3b8; color: #fff; font-size: 11.5px; font-weight: 700; padding: 4px 14px; border-radius: 6px;">
                                        Off Day
                                    </span>
                                @else
                                    <span style="display: inline-block; background: #FFA800; color: #fff; font-size: 11.5px; font-weight: 700; padding: 4px 14px; border-radius: 6px;">
                                        Pending
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
                                        <form method="POST" action="{{ route('attendances.destroy', $att) }}" style="display: block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data presensi ini?');">
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
        @if ($attendances->hasPages())
            <div style="margin-top: 24px; display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: #64748b;">
                <div>
                    Menampilkan {{ $attendances->firstItem() }} sampai {{ $attendances->lastItem() }} dari {{ $attendances->total() }} data
                </div>
                <div>
                    {{ $attendances->links() }}
                </div>
            </div>
        @endif

    </div>

@endsection
