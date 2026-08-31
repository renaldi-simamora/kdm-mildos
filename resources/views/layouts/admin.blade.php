<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'KDM Mildos') - KDM Mildos</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --yellow: #f59e0b;
            --yellow-hover: #d97706;
            --orange-btn: #e59b20;
            --orange-btn-hover: #cc8413;
            --black: #111111;
            --dark: #1e293b;
            --gray: #64748b;
            --gray-light: #94a3b8;
            --gray-border: #e2e8f0;
            --light: #f8fafc;
            --border: #f1f5f9;
            --white: #ffffff;
            --green: #22c55e;
            --green-badge: #22c55e;
            --orange-badge: #f59e0b;
            --red: #ef4444;
            --sidebar-active: #fff6cf;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
            background: #f4f6f8;
            color: #334155;
            line-height: 1.5;
        }

        a { text-decoration: none; color: inherit; }
        button, input, select { font: inherit; }

        .layout {
            display: grid;
            grid-template-columns: 260px 1fr;
            min-height: 100vh;
        }

        /* ═══════════ SIDEBAR ═══════════ */
        .sidebar {
            background: var(--white);
            border-right: 1px solid #e5e7eb;
            padding: 20px 14px 16px;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 20;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 10px 18px;
            margin-bottom: 8px;
        }

        .sidebar-brand-logo {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: #ffd900;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 15px;
            color: #111;
            flex-shrink: 0;
        }

        .sidebar-brand-name {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: -.3px;
            color: #0f172a;
        }

        .nav-group-label {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .6px;
            padding: 16px 10px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 9px;
            font-size: 13.5px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 2px;
            transition: all .15s ease;
            cursor: pointer;
        }

        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
        .nav-item .chevron { margin-left: auto; width: 14px; height: 14px; color: #94a3b8; transition: transform .2s ease; }

        .nav-item:hover { background: #f1f5f9; color: #0f172a; }

        .nav-item.active {
            background: #fff6cf;
            color: #0f172a;
            font-weight: 700;
        }

        .nav-submenu {
            padding-left: 28px;
            display: flex;
            flex-direction: column;
            gap: 2px;
            margin-top: 2px;
            margin-bottom: 4px;
        }

        .nav-subitem {
            display: flex;
            align-items: center;
            padding: 7px 12px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 500;
            color: #64748b;
            transition: all .15s ease;
        }

        .nav-subitem:hover {
            color: #0f172a;
            background: #f8fafc;
        }

        .nav-subitem.active {
            color: #d97706;
            font-weight: 700;
            background: #fffbeb;
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid #f1f5f9;
        }

        /* ═══════════ MAIN ═══════════ */
        .main { display: flex; flex-direction: column; min-width: 0; }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            padding: 14px 28px;
            background: var(--white);
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 15;
        }

        .icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid #e2e8f0;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            cursor: pointer;
            transition: all .15s ease;
        }

        .icon-btn:hover {
            background: #f8fafc;
            color: #0f172a;
        }

        .icon-btn svg { width: 17px; height: 17px; }

        .brand-badge-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px 10px 4px 6px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            background: var(--white);
            font-size: 13px;
            font-weight: 700;
            color: #334155;
            position: relative;
        }

        .brand-circle-logo {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 900;
            color: #0f172a;
            background: #fff;
            position: relative;
        }

        .brand-circle-logo .online-dot {
            position: absolute;
            bottom: 0px;
            right: -2px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--green);
            border: 1.5px solid #fff;
        }

        /* ═══════════ CONTENT ═══════════ */
        .content { padding: 20px 28px 40px; }

        /* Breadcrumb Card */
        .breadcrumb-card {
            background: var(--white);
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            padding: 14px 20px;
            margin-bottom: 20px;
            font-size: 13.5px;
            font-weight: 600;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .breadcrumb-card a { color: #64748b; transition: color .15s ease; }
        .breadcrumb-card a:hover { color: #0f172a; }
        .breadcrumb-card .active-crumb { color: #0f172a; font-weight: 700; }
        .breadcrumb-card .divider { color: #cbd5e1; font-weight: 400; }

        /* Main Card Container */
        .main-card {
            background: var(--white);
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        /* Buttons */
        .btn-primary-orange {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: #e59b20;
            color: #fff;
            font-size: 13.5px;
            font-weight: 700;
            padding: 9px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            box-shadow: 0 1px 2px rgba(229, 155, 32, 0.2);
            transition: all .15s ease;
        }

        .btn-primary-orange:hover {
            background: #d48b13;
            transform: translateY(-1px);
        }

        .btn-reset-gray {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #788292;
            color: #fff;
            font-size: 13.5px;
            font-weight: 600;
            padding: 8px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all .15s ease;
        }

        .btn-reset-gray:hover {
            background: #646e7e;
        }

        /* Filter Controls */
        .filter-select {
            height: 38px;
            padding: 0 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background-color: #fff;
            font-size: 13.5px;
            color: #475569;
            min-width: 170px;
            outline: none;
            cursor: pointer;
        }

        .filter-select:focus {
            border-color: #e59b20;
            box-shadow: 0 0 0 2px rgba(229, 155, 32, 0.15);
        }

        .filter-input {
            height: 38px;
            padding: 0 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background-color: #fff;
            font-size: 13.5px;
            color: #1e293b;
            min-width: 220px;
            outline: none;
        }

        .filter-input:focus {
            border-color: #e59b20;
            box-shadow: 0 0 0 2px rgba(229, 155, 32, 0.15);
        }

        /* Table styles */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            margin-top: 16px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13.5px;
        }

        .data-table th {
            padding: 14px 16px;
            font-size: 12px;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: .5px;
            border-bottom: 1px solid #e5e7eb;
            background: #fff;
            white-space: nowrap;
        }

        .data-table td {
            padding: 16px 16px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .data-table tr:hover td {
            background-color: #fafbfd;
        }

        /* Status badges */
        .badge-pending {
            display: inline-block;
            background: #e59b20;
            color: #fff;
            font-size: 11.5px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 6px;
        }

        .badge-approved {
            display: inline-block;
            background: #22c55e;
            color: #fff;
            font-size: 11.5px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 6px;
        }

        .badge-rejected {
            display: inline-block;
            background: #ef4444;
            color: #fff;
            font-size: 11.5px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 6px;
        }

        /* Action three dots */
        .action-dropdown-btn {
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .action-dropdown-btn:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        /* Modal styling */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(2px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
        }

        .modal-content {
            background: #fff;
            border-radius: 14px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        /* Alerts */
        .alert-success {
            padding: 12px 16px;
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Pagination */
        nav[role="navigation"] {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
        }

        nav[role="navigation"] svg {
            width: 16px !important;
            height: 16px !important;
            max-width: 100%;
            display: inline-block;
            vertical-align: middle;
        }

        nav[role="navigation"] .flex,
        nav[role="navigation"] .inline-flex,
        nav[role="navigation"] span.relative.z-0.inline-flex,
        nav[role="navigation"] div.sm\:flex-1 {
            display: flex !important;
            align-items: center !important;
            gap: 8px;
        }

        nav[role="navigation"] a,
        nav[role="navigation"] span[aria-disabled="true"] > span,
        nav[role="navigation"] span[aria-current="page"] > span,
        nav[role="navigation"] span.relative.inline-flex {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 32px;
            height: 32px;
            padding: 0 10px;
            font-size: 13px;
            font-weight: 500;
            color: #475569;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
            box-sizing: border-box;
        }

        nav[role="navigation"] a:hover {
            background-color: #f1f5f9;
            color: #0f172a;
            border-color: #cbd5e1;
        }

        nav[role="navigation"] span[aria-current="page"] > span,
        nav[role="navigation"] .active > span {
            background-color: var(--yellow, #f59e0b) !important;
            color: #111111 !important;
            border-color: var(--yellow, #f59e0b) !important;
            font-weight: 700;
        }

        nav[role="navigation"] span[aria-disabled="true"] > span {
            color: #cbd5e1;
            background-color: #f8fafc;
            border-color: #e2e8f0;
            cursor: not-allowed;
        }

        nav[role="navigation"] p {
            display: none !important;
        }

        nav[role="navigation"] .sm\:hidden {
            display: none !important;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .layout { grid-template-columns: 1fr; }
            .sidebar {
                position: static;
                height: auto;
                border-right: none;
                border-bottom: 1px solid #e5e7eb;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    <div class="layout" x-data="{ 
        hrmOpen: {{ request()->routeIs('employees.*') || request()->routeIs('face-enrollments.*') ? 'true' : 'true' }}, 
        offTimeOpen: {{ request()->routeIs('off-time-types.*') || request()->routeIs('off-times.*') ? 'true' : 'true' }}, 
        attendanceOpen: {{ request()->routeIs('attendances.*') ? 'true' : 'true' }}, 
        formRequestsOpen: {{ request()->routeIs('off-time-requests.*') || request()->routeIs('attendance-requests.*') || request()->routeIs('change-shift-requests.*') || request()->routeIs('overtime-requests.*') ? 'true' : 'true' }},
        crmOpen: false, 
        bizOpen: false 
    }">

        {{-- ═══════════ SIDEBAR ═══════════ --}}
        <aside class="sidebar">

            <div class="sidebar-brand">
                <div class="sidebar-brand-logo">K</div>
                <div class="sidebar-brand-name">KDM MILDOS</div>
            </div>

            <nav>
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span data-lucide="layout-dashboard"></span>
                    Dashboard
                    <span data-lucide="chevron-right" class="chevron"></span>
                </a>

                <div class="nav-group-label">Business Management</div>
                <a href="#" class="nav-item">
                    <span data-lucide="building-2"></span>
                    Departments
                </a>
                <a href="#" class="nav-item">
                    <span data-lucide="badge-check"></span>
                    Job Titles
                </a>
                <a href="#" class="nav-item">
                    <span data-lucide="map-pin"></span>
                    Locations
                </a>
                <a href="#" class="nav-item">
                    <span data-lucide="git-branch"></span>
                    Divisions
                </a>
                <a href="#" class="nav-item">
                    <span data-lucide="percent"></span>
                    Commission
                    <span data-lucide="chevron-right" class="chevron"></span>
                </a>

                <div class="nav-group-label">CRM</div>
                <a href="#" class="nav-item">
                    <span data-lucide="line-chart"></span>
                    Sales
                    <span data-lucide="chevron-right" class="chevron"></span>
                </a>
                <a href="#" class="nav-item">
                    <span data-lucide="users"></span>
                    Customer
                    <span data-lucide="chevron-right" class="chevron"></span>
                </a>
                <a href="{{ route('attendances.index') }}" class="nav-item {{ request()->routeIs('attendances.*') ? 'active' : '' }}">
                    <span data-lucide="calendar-check"></span>
                    Attendances
                    <span data-lucide="chevron-right" class="chevron"></span>
                </a>
                <a href="#" class="nav-item">
                    <span data-lucide="clipboard-list"></span>
                    Form Requests
                    <span data-lucide="chevron-right" class="chevron"></span>
                </a>

                <div class="nav-group-label">HRM</div>
                
                <!-- Employee Group -->
                <div class="nav-item {{ request()->routeIs('employees.*') || request()->routeIs('face-enrollments.*') ? 'active' : '' }}" @click="hrmOpen = !hrmOpen">
                    <span data-lucide="user-round"></span>
                    Employee
                    <span data-lucide="chevron-down" class="chevron" :style="hrmOpen ? 'transform: rotate(180deg)' : ''"></span>
                </div>

                <div class="nav-submenu" x-show="hrmOpen" x-transition>
                    <a href="{{ route('employees.index') }}" class="nav-subitem {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                        <span data-lucide="list" style="width:14px; height:14px; margin-right:6px;"></span>
                        Employee Management
                    </a>
                    <a href="{{ route('face-enrollments.index') }}" class="nav-subitem {{ request()->routeIs('face-enrollments.*') ? 'active' : '' }}">
                        <span data-lucide="scan-face" style="width:14px; height:14px; margin-right:6px;"></span>
                        Face Enrollments
                    </a>
                </div>

                <a href="{{ route('shifts.index') }}" class="nav-item {{ request()->routeIs('shifts.*') ? 'active' : '' }}">
                    <span data-lucide="clock-4"></span>
                    Shift Management
                </a>

                <!-- Off Time Group -->
                <div class="nav-item {{ request()->routeIs('off-time-types.*') || request()->routeIs('off-times.*') ? 'active' : '' }}" @click="offTimeOpen = !offTimeOpen">
                    <span data-lucide="calendar-x"></span>
                    Off Time
                    <span data-lucide="chevron-down" class="chevron" :style="offTimeOpen ? 'transform: rotate(180deg)' : ''"></span>
                </div>

                <div class="nav-submenu" x-show="offTimeOpen" x-transition>
                    <a href="{{ route('off-time-types.index') }}" class="nav-subitem {{ request()->routeIs('off-time-types.*') ? 'active' : '' }}">
                        <span data-lucide="circle-dot" style="width:12px; height:12px; margin-right:6px;"></span>
                        Categories
                    </a>
                    <a href="{{ route('off-times.index') }}" class="nav-subitem {{ request()->routeIs('off-times.*') ? 'active' : '' }}">
                        <span data-lucide="circle-dot" style="width:12px; height:12px; margin-right:6px;"></span>
                        Off Times
                    </a>
                </div>

                <!-- Attendance Group -->
                <div class="nav-item {{ request()->routeIs('attendances.*') ? 'active' : '' }}" @click="attendanceOpen = !attendanceOpen">
                    <span data-lucide="calendar-check-2"></span>
                    Attendance
                    <span data-lucide="chevron-down" class="chevron" :style="attendanceOpen ? 'transform: rotate(180deg)' : ''"></span>
                </div>

                <div class="nav-submenu" x-show="attendanceOpen" x-transition>
                    <a href="{{ route('attendances.index') }}" class="nav-subitem {{ request()->routeIs('attendances.index') ? 'active' : '' }}">
                        <span data-lucide="circle-dot" style="width:12px; height:12px; margin-right:6px;"></span>
                        Logs
                    </a>
                    <a href="{{ route('attendances.reports') }}" class="nav-subitem {{ request()->routeIs('attendances.reports') ? 'active' : '' }}">
                        <span data-lucide="circle-dot" style="width:12px; height:12px; margin-right:6px;"></span>
                        Reports
                    </a>
                </div>

                <!-- Form Requests Group -->
                <div class="nav-item {{ request()->routeIs('off-time-requests.*') || request()->routeIs('attendance-requests.*') || request()->routeIs('change-shift-requests.*') || request()->routeIs('overtime-requests.*') ? 'active' : '' }}" @click="formRequestsOpen = !formRequestsOpen">
                    <span data-lucide="file-text"></span>
                    Form Requests
                    <span data-lucide="chevron-down" class="chevron" :style="formRequestsOpen ? 'transform: rotate(180deg)' : ''"></span>
                </div>

                <div class="nav-submenu" x-show="formRequestsOpen" x-transition>
                    <a href="{{ route('off-time-requests.index') }}" class="nav-subitem {{ request()->routeIs('off-time-requests.*') ? 'active' : '' }}">
                        <span data-lucide="circle-dot" style="width:12px; height:12px; margin-right:6px;"></span>
                        Off Time Request
                    </a>
                    <a href="{{ route('attendance-requests.index') }}" class="nav-subitem {{ request()->routeIs('attendance-requests.*') ? 'active' : '' }}">
                        <span data-lucide="circle-dot" style="width:12px; height:12px; margin-right:6px;"></span>
                        Attendance Requests
                    </a>
                    <a href="{{ route('change-shift-requests.index') }}" class="nav-subitem {{ request()->routeIs('change-shift-requests.*') ? 'active' : '' }}">
                        <span data-lucide="circle-dot" style="width:12px; height:12px; margin-right:6px;"></span>
                        Change Shifts Request
                    </a>
                    <a href="{{ route('overtime-requests.index') }}" class="nav-subitem {{ request()->routeIs('overtime-requests.*') ? 'active' : '' }}">
                        <span data-lucide="circle-dot" style="width:12px; height:12px; margin-right:6px;"></span>
                        Overtime Requests
                    </a>
                </div>
            </nav>

            <div class="sidebar-footer">
                <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <span data-lucide="settings"></span>
                    Pengaturan
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-item" style="width:100%; background:none; border:none; text-align:left; cursor:pointer;">
                        <span data-lucide="log-out"></span>
                        Keluar
                    </button>
                </form>
            </div>

        </aside>

        {{-- ═══════════ MAIN ═══════════ --}}
        <div class="main">

            {{-- TOPBAR --}}
            <header class="topbar">

                <button class="icon-btn" type="button" aria-label="Bahasa">
                    <span data-lucide="globe"></span>
                </button>

                <div class="brand-badge-chip">
                    <div class="brand-circle-logo">
                        <span>KDM</span>
                        <div class="online-dot"></div>
                    </div>
                    <span>{{ auth()->user()->name ?? 'KDM STRATEGY' }}</span>
                </div>

            </header>

            {{-- CONTENT --}}
            <div class="content">
                @yield('content')
            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) { lucide.createIcons(); }
        });
    </script>
    @stack('scripts')

</body>
</html>
