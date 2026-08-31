@extends('layouts.admin')

@section('title', 'Create Off Time')

@section('content')

    {{-- BREADCRUMB --}}
    <div class="breadcrumb-card">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="divider">/</span>
        <a href="{{ route('off-times.index') }}">Off Times</a>
        <span class="divider">/</span>
        <span class="active-crumb">Create</span>
    </div>

    {{-- MAIN CARD --}}
    <div class="main-card" style="max-width: 960px; margin: 0 auto;">

        {{-- FLASH & ERROR MESSAGES --}}
        @if ($errors->any())
            <div style="padding: 14px 18px; background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; border-radius: 8px; margin-bottom: 24px; font-size: 13.5px;">
                <div style="font-weight: 700; margin-bottom: 6px;">Terdapat kesalahan pengisian form:</div>
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('off-times.store') }}">
            @csrf

            {{-- Employee --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">
                    Employee <span style="color: #ef4444;">*</span>
                </label>
                <select
                    name="employee_id"
                    id="employee_id"
                    class="filter-select"
                    style="width: 100%; height: 42px;"
                    required
                >
                    <option value="" disabled {{ old('employee_id') ? '' : 'selected' }}>Choose Employee</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }} ({{ $employee->employee_code ?? 'EMP' }}) - {{ $employee->department ?? '-' }}
                        </option>
                    @endforeach
                </select>
                @error('employee_id')
                    <span style="color: #ef4444; font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Locations --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">
                    Locations
                </label>
                <input
                    type="text"
                    name="location"
                    id="location"
                    class="filter-input"
                    placeholder="Choose Locations"
                    value="{{ old('location') }}"
                    style="width: 100%; height: 42px;"
                >
                @error('location')
                    <span style="color: #ef4444; font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Off Time Category --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">
                    Off Time Category <span style="color: #ef4444;">*</span>
                </label>
                <select
                    name="off_time_category_id"
                    id="off_time_category_id"
                    class="filter-select"
                    style="width: 100%; height: 42px;"
                    required
                >
                    <option value="" disabled {{ old('off_time_category_id') ? '' : 'selected' }}>Choose Off Time Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('off_time_category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }} (Max: {{ $category->max_off_times }} / {{ $category->interval_type }})
                        </option>
                    @endforeach
                </select>
                @error('off_time_category_id')
                    <span style="color: #ef4444; font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Recurrence Type --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">
                    Recurrence Type <span style="color: #ef4444;">*</span>
                </label>
                <select
                    name="recurrence_type"
                    id="recurrence_type"
                    class="filter-select"
                    style="width: 100%; height: 42px;"
                    required
                >
                    <option value="" disabled {{ old('recurrence_type') ? '' : 'selected' }}>Choose Recurrence Type</option>
                    <option value="None" {{ old('recurrence_type', 'None') === 'None' ? 'selected' : '' }}>None</option>
                    <option value="Daily" {{ old('recurrence_type') === 'Daily' ? 'selected' : '' }}>Daily</option>
                    <option value="Weekly" {{ old('recurrence_type') === 'Weekly' ? 'selected' : '' }}>Weekly</option>
                    <option value="Monthly" {{ old('recurrence_type') === 'Monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="Yearly" {{ old('recurrence_type') === 'Yearly' ? 'selected' : '' }}>Yearly</option>
                </select>
                @error('recurrence_type')
                    <span style="color: #ef4444; font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Start Date --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">
                    Start Date <span style="color: #ef4444;">*</span>
                </label>
                <input
                    type="date"
                    name="start_date"
                    id="start_date"
                    class="filter-input"
                    value="{{ old('start_date', now()->format('Y-m-d')) }}"
                    style="width: 100%; height: 42px;"
                    required
                >
                @error('start_date')
                    <span style="color: #ef4444; font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span>
                @enderror
            </div>

            {{-- End Date --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">
                    End Date
                </label>
                <input
                    type="date"
                    name="end_date"
                    id="end_date"
                    class="filter-input"
                    value="{{ old('end_date') }}"
                    style="width: 100%; height: 42px;"
                >
                @error('end_date')
                    <span style="color: #ef4444; font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Reason --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">
                    Reason
                </label>
                <textarea
                    name="reason"
                    id="reason"
                    rows="3"
                    class="filter-input"
                    placeholder="e.g Personal Leave"
                    style="width: 100%; height: auto; padding: 12px 14px;"
                >{{ old('reason') }}</textarea>
                @error('reason')
                    <span style="color: #ef4444; font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Status --}}
            <div style="margin-bottom: 30px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">
                    Status <span style="color: #ef4444;">*</span>
                </label>
                <select
                    name="status"
                    id="status"
                    class="filter-select"
                    style="width: 100%; height: 42px;"
                    required
                >
                    <option value="Draft" {{ old('status', 'Draft') === 'Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Pending" {{ old('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Approved" {{ old('status') === 'Approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Rejected" {{ old('status') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                @error('status')
                    <span style="color: #ef4444; font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Buttons --}}
            <div style="display: flex; justify-content: flex-end; align-items: center; gap: 10px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                <a href="{{ route('off-times.index') }}" class="btn-reset-gray" style="padding: 10px 24px; text-decoration: none;">
                    Back
                </a>
                <button type="submit" class="btn-primary-orange" style="background: #FFA800; padding: 10px 28px;">
                    Submit
                </button>
            </div>

        </form>

    </div>

@endsection
