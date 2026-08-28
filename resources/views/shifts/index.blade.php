@extends('layouts.admin')

@section('title', 'Shift Management')

@section('content')

    {{-- BREADCRUMB --}}
    <div class="breadcrumb-card">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="divider">/</span>
        <span class="active-crumb">Shifts</span>
    </div>

    {{-- MAIN CARD --}}
    <div class="main-card" x-data="shiftManager()">

        {{-- FLASH MESSAGES --}}
        @if (session('success'))
            <div class="alert-success" style="margin-bottom: 20px;">
                <span data-lucide="check-circle-2" style="width:16px; height:16px; flex-shrink:0;"></span>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="padding: 12px 16px; background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; border-radius: 8px; margin-bottom: 16px; font-size: 13.5px;">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- HEADER ROW --}}
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">

            {{-- Create Button --}}
            <button
                class="btn-primary-orange"
                type="button"
                id="btn-create-shift"
                @click="openCreate()"
            >
                <span data-lucide="plus" style="width:15px; height:15px;"></span>
                Create Shift
            </button>

            {{-- Search --}}
            <form method="GET" action="{{ route('shifts.index') }}" style="display: flex; gap: 8px; align-items: center;">
                <input
                    type="text"
                    name="search"
                    id="shift-search"
                    class="filter-input"
                    placeholder="Search..."
                    value="{{ $search }}"
                    style="min-width: 240px;"
                >
                <button type="submit" style="
                    height: 38px; width: 42px; border-radius: 8px;
                    background: #e59b20; border: none; cursor: pointer;
                    display: flex; align-items: center; justify-content: center;
                    color: #fff; flex-shrink: 0;
                ">
                    <span data-lucide="search" style="width:16px; height:16px;"></span>
                </button>
                @if ($search)
                    <a href="{{ route('shifts.index') }}" class="btn-reset-gray" style="height:38px; display:inline-flex; align-items:center;">Reset</a>
                @endif
            </form>

        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="data-table" id="shifts-table">
                <thead>
                    <tr>
                        <th style="width:48px;">NO</th>
                        <th>DEPARTEMENT</th>
                        <th>NAME</th>
                        <th>START TIME</th>
                        <th>END TIME</th>
                        <th>EARLY TOLERANCE MINUTES</th>
                        <th>LATE TOLERANCE MINUTES</th>
                        <th>STATUS</th>
                        <th style="text-align:center;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shifts as $index => $shift)
                        <tr>
                            <td style="color:#94a3b8; font-size:13px;">
                                {{ ($shifts->currentPage() - 1) * $shifts->perPage() + $loop->iteration }}
                            </td>
                            <td style="font-weight:600; color:#0f172a;">{{ $shift->department }}</td>
                            <td>{{ $shift->name }}</td>
                            <td>{{ $shift->start_time }}</td>
                            <td>{{ $shift->end_time }}</td>
                            <td>{{ $shift->early_tolerance_minutes }}</td>
                            <td>{{ $shift->late_tolerance_minutes }}</td>
                            <td>
                                @if ($shift->status === 'Active')
                                    <span class="badge-approved" id="badge-status-{{ $shift->id }}">Active</span>
                                @else
                                    <span style="display:inline-block; background:#94a3b8; color:#fff; font-size:11.5px; font-weight:700; padding:4px 12px; border-radius:6px;" id="badge-status-{{ $shift->id }}">Inactive</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                <div style="position:relative;" x-data="{ open: false }">
                                    <button
                                        class="action-dropdown-btn"
                                        type="button"
                                        @click="open = !open"
                                        @click.outside="open = false"
                                        :id="'action-btn-' + {{ $shift->id }}"
                                        aria-label="Actions for {{ $shift->name }}"
                                    >
                                        ⋮
                                    </button>

                                    <div
                                        x-show="open"
                                        x-transition
                                        style="
                                            position: absolute; right: 0; top: 100%; margin-top: 4px;
                                            background: #fff; border: 1px solid #e2e8f0;
                                            border-radius: 8px; padding: 4px; z-index: 30;
                                            min-width: 160px; box-shadow: 0 4px 12px rgba(0,0,0,.08);
                                        "
                                    >
                                        {{-- View --}}
                                        <button
                                            type="button"
                                            class="action-menu-item"
                                            @click="open = false; openView({{ json_encode($shift) }})"
                                            id="view-btn-{{ $shift->id }}"
                                        >
                                            <span data-lucide="eye" style="width:14px; height:14px;"></span>
                                            View
                                        </button>

                                        {{-- Edit --}}
                                        <button
                                            type="button"
                                            class="action-menu-item"
                                            @click="open = false; openEdit({{ json_encode($shift) }})"
                                            id="edit-btn-{{ $shift->id }}"
                                        >
                                            <span data-lucide="pencil" style="width:14px; height:14px;"></span>
                                            Edit
                                        </button>

                                        {{-- Change Status --}}
                                        <form
                                            method="POST"
                                            action="{{ route('shifts.update-status', $shift) }}"
                                            style="display:block;"
                                        >
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                type="submit"
                                                class="action-menu-item"
                                                id="status-btn-{{ $shift->id }}"
                                            >
                                                <span data-lucide="toggle-left" style="width:14px; height:14px;"></span>
                                                Change Status
                                            </button>
                                        </form>

                                        <div style="border-top: 1px solid #f1f5f9; margin: 4px 0;"></div>

                                        {{-- Delete --}}
                                        <button
                                            type="button"
                                            class="action-menu-item"
                                            style="color: #ef4444;"
                                            @click="open = false; openDelete({{ $shift->id }}, '{{ addslashes($shift->name) }}')"
                                            id="delete-btn-{{ $shift->id }}"
                                        >
                                            <span data-lucide="trash-2" style="width:14px; height:14px;"></span>
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align:center; padding:48px 16px; color:#94a3b8;">
                                <div style="display:flex; flex-direction:column; align-items:center; gap:10px;">
                                    <span data-lucide="clock-x" style="width:40px; height:40px; stroke-width:1.5;"></span>
                                    <span style="font-size:14px;">
                                        @if ($search)
                                            Tidak ada shift yang cocok dengan pencarian "{{ $search }}".
                                        @else
                                            Belum ada data shift. Klik <strong>Create Shift</strong> untuk menambahkan.
                                        @endif
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if ($shifts->hasPages())
            <div style="margin-top:20px; display:flex; justify-content:space-between; align-items:center; font-size:13px; color:#64748b; flex-wrap:wrap; gap:8px;">
                <div>
                    Menampilkan {{ $shifts->firstItem() }}–{{ $shifts->lastItem() }} dari {{ $shifts->total() }} shift
                </div>
                <div>
                    {{ $shifts->links() }}
                </div>
            </div>
        @endif

        {{-- ══════════════════════════════ --}}
        {{-- MODAL: CREATE SHIFT --}}
        {{-- ══════════════════════════════ --}}
        <div x-show="showCreate" class="modal-backdrop" style="display:none;" @click.self="showCreate = false">
            <div class="modal-content" style="max-width:540px;" @click.stop>
                <div style="padding:20px 24px 16px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
                    <div>
                        <h3 style="font-size:16px; font-weight:700; color:#0f172a;">Tambah Shift Baru</h3>
                        <p style="font-size:13px; color:#64748b; margin-top:2px;">Isi data shift yang ingin ditambahkan.</p>
                    </div>
                    <button type="button" @click="showCreate = false" style="background:none; border:none; cursor:pointer; color:#94a3b8; padding:4px;">
                        <span data-lucide="x" style="width:18px; height:18px;"></span>
                    </button>
                </div>

                <form method="POST" action="{{ route('shifts.store') }}" style="padding:20px 24px 24px;" id="form-create-shift">
                    @csrf
                    <div class="form-grid">

                        {{-- Department --}}
                        <div class="form-group full-width">
                            <label class="form-label">Department <span style="color:#ef4444">*</span></label>
                            <select name="department" id="create-department" class="filter-select" style="width:100%;" required>
                                <option value="">— Pilih Department —</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept }}" {{ old('department') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                @endforeach
                            </select>
                            @error('department')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Shift Name --}}
                        <div class="form-group full-width">
                            <label class="form-label">Nama Shift <span style="color:#ef4444">*</span></label>
                            <input
                                type="text"
                                name="name"
                                id="create-name"
                                class="filter-input"
                                style="width:100%;"
                                placeholder="Contoh: Office Senin - Jumat"
                                value="{{ old('name') }}"
                                required
                                maxlength="150"
                            >
                            @error('name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Start Time --}}
                        <div class="form-group">
                            <label class="form-label">Start Time <span style="color:#ef4444">*</span></label>
                            <input
                                type="time"
                                name="start_time"
                                id="create-start-time"
                                class="filter-input"
                                style="width:100%;"
                                value="{{ old('start_time') }}"
                                required
                            >
                            @error('start_time')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- End Time --}}
                        <div class="form-group">
                            <label class="form-label">End Time <span style="color:#ef4444">*</span></label>
                            <input
                                type="time"
                                name="end_time"
                                id="create-end-time"
                                class="filter-input"
                                style="width:100%;"
                                value="{{ old('end_time') }}"
                                required
                            >
                            @error('end_time')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Early Tolerance --}}
                        <div class="form-group">
                            <label class="form-label">Early Tolerance (menit)</label>
                            <input
                                type="number"
                                name="early_tolerance_minutes"
                                id="create-early-tolerance"
                                class="filter-input"
                                style="width:100%;"
                                min="0"
                                value="{{ old('early_tolerance_minutes', 0) }}"
                                required
                            >
                            @error('early_tolerance_minutes')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Late Tolerance --}}
                        <div class="form-group">
                            <label class="form-label">Late Tolerance (menit)</label>
                            <input
                                type="number"
                                name="late_tolerance_minutes"
                                id="create-late-tolerance"
                                class="filter-input"
                                style="width:100%;"
                                min="0"
                                value="{{ old('late_tolerance_minutes', 15) }}"
                                required
                            >
                            @error('late_tolerance_minutes')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="form-group full-width">
                            <label class="form-label">Status</label>
                            <select name="status" id="create-status" class="filter-select" style="width:100%;" required>
                                <option value="Active" {{ old('status', 'Active') === 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:20px; padding-top:16px; border-top:1px solid #f1f5f9;">
                        <button type="button" @click="showCreate = false" class="btn-reset-gray">Batal</button>
                        <button type="submit" class="btn-primary-orange" id="submit-create-shift">
                            <span data-lucide="save" style="width:14px; height:14px;"></span>
                            Simpan Shift
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ══════════════════════════════ --}}
        {{-- MODAL: EDIT SHIFT --}}
        {{-- ══════════════════════════════ --}}
        <div x-show="showEdit" class="modal-backdrop" style="display:none;" @click.self="showEdit = false">
            <div class="modal-content" style="max-width:540px;" @click.stop>
                <div style="padding:20px 24px 16px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
                    <div>
                        <h3 style="font-size:16px; font-weight:700; color:#0f172a;">Edit Shift</h3>
                        <p style="font-size:13px; color:#64748b; margin-top:2px;">Perbarui data shift.</p>
                    </div>
                    <button type="button" @click="showEdit = false" style="background:none; border:none; cursor:pointer; color:#94a3b8; padding:4px;">
                        <span data-lucide="x" style="width:18px; height:18px;"></span>
                    </button>
                </div>

                <form method="POST" :action="`/shifts/${editShift.id}`" style="padding:20px 24px 24px;" id="form-edit-shift">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">

                        {{-- Department --}}
                        <div class="form-group full-width">
                            <label class="form-label">Department <span style="color:#ef4444">*</span></label>
                            <select name="department" id="edit-department" class="filter-select" style="width:100%;" x-model="editShift.department" required>
                                <option value="">— Pilih Department —</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept }}">{{ $dept }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Shift Name --}}
                        <div class="form-group full-width">
                            <label class="form-label">Nama Shift <span style="color:#ef4444">*</span></label>
                            <input
                                type="text"
                                name="name"
                                id="edit-name"
                                class="filter-input"
                                style="width:100%;"
                                x-model="editShift.name"
                                required
                                maxlength="150"
                            >
                        </div>

                        {{-- Start Time --}}
                        <div class="form-group">
                            <label class="form-label">Start Time <span style="color:#ef4444">*</span></label>
                            <input
                                type="time"
                                name="start_time"
                                id="edit-start-time"
                                class="filter-input"
                                style="width:100%;"
                                x-model="editShift.start_time"
                                required
                            >
                        </div>

                        {{-- End Time --}}
                        <div class="form-group">
                            <label class="form-label">End Time <span style="color:#ef4444">*</span></label>
                            <input
                                type="time"
                                name="end_time"
                                id="edit-end-time"
                                class="filter-input"
                                style="width:100%;"
                                x-model="editShift.end_time"
                                required
                            >
                        </div>

                        {{-- Early Tolerance --}}
                        <div class="form-group">
                            <label class="form-label">Early Tolerance (menit)</label>
                            <input
                                type="number"
                                name="early_tolerance_minutes"
                                id="edit-early-tolerance"
                                class="filter-input"
                                style="width:100%;"
                                min="0"
                                x-model="editShift.early_tolerance_minutes"
                                required
                            >
                        </div>

                        {{-- Late Tolerance --}}
                        <div class="form-group">
                            <label class="form-label">Late Tolerance (menit)</label>
                            <input
                                type="number"
                                name="late_tolerance_minutes"
                                id="edit-late-tolerance"
                                class="filter-input"
                                style="width:100%;"
                                min="0"
                                x-model="editShift.late_tolerance_minutes"
                                required
                            >
                        </div>

                        {{-- Status --}}
                        <div class="form-group full-width">
                            <label class="form-label">Status</label>
                            <select name="status" id="edit-status" class="filter-select" style="width:100%;" x-model="editShift.status" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:20px; padding-top:16px; border-top:1px solid #f1f5f9;">
                        <button type="button" @click="showEdit = false" class="btn-reset-gray">Batal</button>
                        <button type="submit" class="btn-primary-orange" id="submit-edit-shift">
                            <span data-lucide="save" style="width:14px; height:14px;"></span>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ══════════════════════════════ --}}
        {{-- MODAL: VIEW SHIFT --}}
        {{-- ══════════════════════════════ --}}
        <div x-show="showView" class="modal-backdrop" style="display:none;" @click.self="showView = false">
            <div class="modal-content" style="max-width:480px;" @click.stop>
                <div style="padding:20px 24px 16px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
                    <h3 style="font-size:16px; font-weight:700; color:#0f172a;">Detail Shift</h3>
                    <button type="button" @click="showView = false" style="background:none; border:none; cursor:pointer; color:#94a3b8; padding:4px;">
                        <span data-lucide="x" style="width:18px; height:18px;"></span>
                    </button>
                </div>
                <div style="padding:20px 24px 24px;">
                    <dl style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                        <div>
                            <dt style="font-size:11.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px;">Department</dt>
                            <dd style="font-weight:600; color:#0f172a;" x-text="viewShift.department"></dd>
                        </div>
                        <div>
                            <dt style="font-size:11.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px;">Status</dt>
                            <dd>
                                <span
                                    :class="viewShift.status === 'Active' ? 'badge-approved' : ''"
                                    :style="viewShift.status !== 'Active' ? 'display:inline-block; background:#94a3b8; color:#fff; font-size:11.5px; font-weight:700; padding:4px 12px; border-radius:6px;' : ''"
                                    x-text="viewShift.status"
                                ></span>
                            </dd>
                        </div>
                        <div style="grid-column:1/-1;">
                            <dt style="font-size:11.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px;">Nama Shift</dt>
                            <dd style="font-weight:600; color:#0f172a;" x-text="viewShift.name"></dd>
                        </div>
                        <div>
                            <dt style="font-size:11.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px;">Start Time</dt>
                            <dd x-text="viewShift.start_time"></dd>
                        </div>
                        <div>
                            <dt style="font-size:11.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px;">End Time</dt>
                            <dd x-text="viewShift.end_time"></dd>
                        </div>
                        <div>
                            <dt style="font-size:11.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px;">Early Tolerance</dt>
                            <dd x-text="viewShift.early_tolerance_minutes + ' menit'"></dd>
                        </div>
                        <div>
                            <dt style="font-size:11.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px;">Late Tolerance</dt>
                            <dd x-text="viewShift.late_tolerance_minutes + ' menit'"></dd>
                        </div>
                    </dl>
                    <div style="margin-top:20px; padding-top:16px; border-top:1px solid #f1f5f9; text-align:right;">
                        <button type="button" @click="showView = false" class="btn-reset-gray">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════ --}}
        {{-- MODAL: DELETE CONFIRM --}}
        {{-- ══════════════════════════════ --}}
        <div x-show="showDelete" class="modal-backdrop" style="display:none;" @click.self="showDelete = false">
            <div class="modal-content" style="max-width:420px;" @click.stop>
                <div style="padding:24px 24px 20px; text-align:center;">
                    <div style="width:52px; height:52px; border-radius:50%; background:#fef2f2; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                        <span data-lucide="trash-2" style="width:24px; height:24px; color:#ef4444;"></span>
                    </div>
                    <h3 style="font-size:16px; font-weight:700; color:#0f172a; margin-bottom:8px;">Hapus Shift?</h3>
                    <p style="font-size:13.5px; color:#64748b;">
                        Anda akan menghapus shift <strong x-text="deleteShiftName" style="color:#0f172a;"></strong>. Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div style="padding:0 24px 24px; display:flex; gap:10px; justify-content:center;">
                    <button type="button" @click="showDelete = false" class="btn-reset-gray">Batal</button>
                    <form method="POST" :action="`/shifts/${deleteShiftId}`" id="form-delete-shift">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="
                            display:inline-flex; align-items:center; gap:6px;
                            background:#ef4444; color:#fff; font-size:13.5px; font-weight:700;
                            padding:9px 18px; border-radius:8px; border:none; cursor:pointer;
                            transition:all .15s ease;
                        ">
                            <span data-lucide="trash-2" style="width:14px; height:14px;"></span>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('styles')
<style>
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group.full-width { grid-column: 1 / -1; }

    .form-label {
        font-size: 12.5px;
        font-weight: 600;
        color: #374151;
    }

    .form-error {
        font-size: 12px;
        color: #ef4444;
        margin-top: 2px;
    }

    .action-menu-item {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        padding: 8px 12px;
        background: none;
        border: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        color: #374151;
        cursor: pointer;
        text-align: left;
        transition: background .1s ease;
    }

    .action-menu-item:hover {
        background: #f8fafc;
    }
</style>
@endpush

@push('scripts')
<script>
    function shiftManager() {
        return {
            showCreate: {{ $errors->any() && !old('_method') ? 'true' : 'false' }},
            showEdit: false,
            showView: false,
            showDelete: false,
            editShift: {},
            viewShift: {},
            deleteShiftId: null,
            deleteShiftName: '',

            openCreate() {
                this.showCreate = true;
                this.$nextTick(() => {
                    if (window.lucide) lucide.createIcons();
                });
            },

            openEdit(shift) {
                // Format time for <input type="time"> (HH:MM)
                this.editShift = {
                    ...shift,
                    start_time: shift.start_time ? shift.start_time.substring(0, 5) : '',
                    end_time: shift.end_time ? shift.end_time.substring(0, 5) : '',
                };
                this.showEdit = true;
                this.$nextTick(() => {
                    if (window.lucide) lucide.createIcons();
                });
            },

            openView(shift) {
                this.viewShift = shift;
                this.showView = true;
                this.$nextTick(() => {
                    if (window.lucide) lucide.createIcons();
                });
            },

            openDelete(id, name) {
                this.deleteShiftId = id;
                this.deleteShiftName = name;
                this.showDelete = true;
                this.$nextTick(() => {
                    if (window.lucide) lucide.createIcons();
                });
            },
        };
    }
</script>
@endpush
