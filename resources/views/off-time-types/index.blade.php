@extends('layouts.admin')

@section('title', 'Off Time Types')

@section('content')

    {{-- BREADCRUMB --}}
    <div class="breadcrumb-card">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="divider">/</span>
        <a href="{{ route('off-time-types.index') }}">Off Time Types</a>
        <span class="divider">/</span>
        <span class="active-crumb">List</span>
    </div>

    {{-- MAIN CARD --}}
    <div class="main-card" x-data="{ createModalOpen: false, editModalOpen: false, currentType: {} }">

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

        {{-- HEADER / ACTIONS ROW --}}
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
            <button
                class="btn-primary-orange"
                type="button"
                id="btn-create-off-time-type"
                @click="createModalOpen = true"
            >
                <span data-lucide="plus" style="width:15px; height:15px;"></span>
                Create Category
            </button>

            {{-- Search Bar --}}
            <form method="GET" action="{{ route('off-time-types.index') }}" style="display: flex; gap: 8px; align-items: center;">
                <input
                    type="text"
                    name="search"
                    id="off-time-type-search"
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
                    <a href="{{ route('off-time-types.index') }}" class="btn-reset-gray" style="height:38px; display:inline-flex; align-items:center;">Reset</a>
                @endif
            </form>
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="data-table" id="off-time-types-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">NO</th>
                        <th>NAME</th>
                        <th>MAX OFF TIMES</th>
                        <th>INTERVAL TYPE</th>
                        <th>SUPERADMIN APPROVAL</th>
                        <th>STATUS</th>
                        <th style="width: 70px; text-align: center;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($offTimeTypes as $index => $type)
                        <tr>
                            <td style="color: #94a3b8; font-size: 13px;">
                                {{ ($offTimeTypes->currentPage() - 1) * $offTimeTypes->perPage() + $loop->iteration }}
                            </td>
                            <td style="font-weight: 600; color: #1e293b;">
                                {{ $type->name }}
                            </td>
                            <td style="color: #475569;">
                                {{ $type->max_off_times }}
                            </td>
                            <td style="color: #475569;">
                                {{ $type->interval_type }}
                            </td>
                            <td style="color: #475569;">
                                {{ $type->superadmin_approval ? 'Yes' : 'No' }}
                            </td>
                            <td>
                                @if ($type->status === 'Active')
                                    <span style="display: inline-block; background: #22c55e; color: #fff; font-size: 11.5px; font-weight: 700; padding: 4px 14px; border-radius: 6px;">
                                        Active
                                    </span>
                                @else
                                    <span style="display: inline-block; background: #ef4444; color: #fff; font-size: 11.5px; font-weight: 700; padding: 4px 14px; border-radius: 6px;">
                                        Inactive
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
                                        <button
                                            type="button"
                                            @click="currentType = {{ json_encode($type) }}; editModalOpen = true; open = false;"
                                            style="width: 100%; padding: 8px 14px; font-size: 13px; color: #334155; background: none; border: none; text-align: left; cursor: pointer; display: flex; align-items: center; gap: 6px;"
                                            onmouseover="this.style.background='#f8fafc'"
                                            onmouseout="this.style.background='none'"
                                        >
                                            <span data-lucide="pencil" style="width: 14px; height: 14px;"></span>
                                            Edit
                                        </button>

                                        <form method="POST" action="{{ route('off-time-types.toggle-status', $type) }}" style="display: block;">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                type="submit"
                                                style="width: 100%; padding: 8px 14px; font-size: 13px; color: #334155; background: none; border: none; text-align: left; cursor: pointer; display: flex; align-items: center; gap: 6px;"
                                                onmouseover="this.style.background='#f8fafc'"
                                                onmouseout="this.style.background='none'"
                                            >
                                                <span data-lucide="refresh-cw" style="width: 14px; height: 14px;"></span>
                                                Toggle Status
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('off-time-types.destroy', $type) }}" style="display: block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
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
                            <td colspan="7" style="text-align: center; color: #94a3b8; padding: 32px;">
                                No Data Available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if ($offTimeTypes->hasPages())
            <div style="margin-top: 24px; display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: #64748b;">
                <div>
                    Menampilkan {{ $offTimeTypes->firstItem() }} sampai {{ $offTimeTypes->lastItem() }} dari {{ $offTimeTypes->total() }} data
                </div>
                <div>
                    {{ $offTimeTypes->links() }}
                </div>
            </div>
        @endif

        {{-- CREATE MODAL --}}
        <div class="modal-backdrop" x-show="createModalOpen" x-transition style="display: none;">
            <div class="modal-content" @click.outside="createModalOpen = false">
                <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                    <div style="font-size: 16px; font-weight: 800; color: #0f172a;">Create Off Time Category</div>
                    <button type="button" @click="createModalOpen = false" style="background: none; border: none; cursor: pointer; color: #94a3b8;">
                        <span data-lucide="x" style="width: 18px; height: 18px;"></span>
                    </button>
                </div>
                <form method="POST" action="{{ route('off-time-types.store') }}" style="padding: 24px;">
                    @csrf
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #334155;">Name *</label>
                        <input type="text" name="name" class="filter-input" value="{{ old('name') }}" placeholder="e.g. Cuti Tahunan" style="width: 100%;" required>
                        @error('name')
                            <span style="color: #ef4444; font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #334155;">Max Off Times *</label>
                        <input type="number" name="max_off_times" class="filter-input" value="{{ old('max_off_times', 1) }}" min="1" style="width: 100%;" required>
                        @error('max_off_times')
                            <span style="color: #ef4444; font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #334155;">Interval Type *</label>
                        <select name="interval_type" class="filter-select" style="width: 100%;" required>
                            <option value="Monthly" {{ old('interval_type') === 'Monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="Yearly" {{ old('interval_type') === 'Yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                        @error('interval_type')
                            <span style="color: #ef4444; font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #334155;">Superadmin Approval *</label>
                        <select name="superadmin_approval" class="filter-select" style="width: 100%;" required>
                            <option value="1" {{ old('superadmin_approval') == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('superadmin_approval', '0') == '0' ? 'selected' : '' }}>No</option>
                        </select>
                        @error('superadmin_approval')
                            <span style="color: #ef4444; font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #334155;">Status *</label>
                        <select name="status" class="filter-select" style="width: 100%;" required>
                            <option value="Active" {{ old('status', 'Active') === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <span style="color: #ef4444; font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="display: flex; justify-content: flex-end; gap: 8px;">
                        <button type="button" @click="createModalOpen = false" class="btn-reset-gray">Cancel</button>
                        <button type="submit" class="btn-primary-orange" style="background: #FFA800;">Save Category</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- EDIT MODAL --}}
        <div class="modal-backdrop" x-show="editModalOpen" x-transition style="display: none;">
            <div class="modal-content" @click.outside="editModalOpen = false">
                <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                    <div style="font-size: 16px; font-weight: 800; color: #0f172a;">Edit Off Time Category</div>
                    <button type="button" @click="editModalOpen = false" style="background: none; border: none; cursor: pointer; color: #94a3b8;">
                        <span data-lucide="x" style="width: 18px; height: 18px;"></span>
                    </button>
                </div>
                <form :action="'{{ url('off-time-types') }}/' + currentType.id" method="POST" style="padding: 24px;">
                    @csrf
                    @method('PUT')
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #334155;">Name *</label>
                        <input type="text" name="name" class="filter-input" :value="currentType.name" style="width: 100%;" required>
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #334155;">Max Off Times *</label>
                        <input type="number" name="max_off_times" class="filter-input" :value="currentType.max_off_times" min="1" style="width: 100%;" required>
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #334155;">Interval Type *</label>
                        <select name="interval_type" class="filter-select" :value="currentType.interval_type" style="width: 100%;" required>
                            <option value="Monthly">Monthly</option>
                            <option value="Yearly">Yearly</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #334155;">Superadmin Approval *</label>
                        <select name="superadmin_approval" class="filter-select" :value="currentType.superadmin_approval ? '1' : '0'" style="width: 100%;" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: #334155;">Status *</label>
                        <select name="status" class="filter-select" :value="currentType.status" style="width: 100%;" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <div style="display: flex; justify-content: flex-end; gap: 8px;">
                        <button type="button" @click="editModalOpen = false" class="btn-reset-gray">Cancel</button>
                        <button type="submit" class="btn-primary-orange" style="background: #FFA800;">Update Category</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection
