<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - KDM Mildos</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>

    <style>
        :root {
            --yellow: #ffd900;
            --yellow-dark: #e8bf00;
            --black: #111111;
            --dark: #171717;
            --gray: #6f6f6f;
            --gray-light: #9a9a95;
            --light: #f7f7f5;
            --border: #e7e7e3;
            --white: #ffffff;
            --green: #19b95b;
            --green-bg: #e9f9ef;
            --red: #e5484d;
            --red-bg: #fdeceb;
            --blue: #2f7bf6;
            --blue-bg: #eaf1ff;
            --gray-bg: #f0f0ee;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, sans-serif;
            background: var(--light);
            color: var(--black);
            line-height: 1.5;
        }

        a { text-decoration: none; color: inherit; }
        button, input { font: inherit; }

        .layout {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }

        /* ═══════════ SIDEBAR ═══════════ */
        .sidebar {
            background: var(--white);
            border-right: 1px solid var(--border);
            padding: 20px 14px 16px;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 10px 18px;
            margin-bottom: 8px;
        }

        .sidebar-brand-logo {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--yellow);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 14px;
            color: var(--black);
            flex-shrink: 0;
        }

        .sidebar-brand-name {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: -.3px;
        }

        .nav-group-label {
            font-size: 10.5px;
            font-weight: 700;
            color: var(--gray-light);
            text-transform: uppercase;
            letter-spacing: .6px;
            padding: 16px 10px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 10px;
            border-radius: 9px;
            font-size: 13.5px;
            font-weight: 600;
            color: #444;
            margin-bottom: 2px;
            transition: background .15s ease, color .15s ease;
        }

        .nav-item svg { width: 17px; height: 17px; flex-shrink: 0; }
        .nav-item .chevron { margin-left: auto; width: 14px; height: 14px; color: var(--gray-light); }

        .nav-item:hover { background: var(--light); color: var(--black); }

        .nav-item.active {
            background: #fff6cf;
            color: var(--black);
            font-weight: 700;
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid var(--border);
        }

        /* ═══════════ MAIN ═══════════ */
        .main { display: flex; flex-direction: column; }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 28px;
            background: var(--white);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .icon-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark);
        }

        .icon-btn svg { width: 17px; height: 17px; }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 10px 5px 5px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--white);
            position: relative;
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--yellow);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
            color: var(--black);
        }

        .user-chip .status-dot {
            position: absolute;
            bottom: 4px;
            left: 28px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--green);
            border: 2px solid var(--white);
        }

        .user-name { font-size: 12.5px; font-weight: 700; }

        /* Content */
        .content { padding: 24px 28px 40px; }

        .content-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 20px;
        }

        .content-title {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .content-subtitle {
            font-size: 13px;
            color: var(--gray);
            margin-top: 3px;
        }

        /* Filter bar */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-date {
            flex: 1;
            min-width: 220px;
            display: flex;
            align-items: center;
            gap: 10px;
            height: 42px;
            padding: 0 14px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: var(--light);
            color: var(--gray);
            font-size: 13px;
        }

        .filter-date svg { width: 16px; height: 16px; color: var(--gray-light); flex-shrink: 0; }
        .filter-date input {
            border: none;
            background: none;
            outline: none;
            width: 100%;
            font-size: 13px;
            color: var(--black);
        }
        .filter-date input::placeholder { color: var(--gray-light); }

        .btn-filter {
            height: 42px;
            padding: 0 20px;
            border-radius: 10px;
            border: none;
            background: var(--yellow);
            color: var(--black);
            font-size: 13px;
            font-weight: 700;
            transition: background .15s ease, transform .1s ease;
        }

        .btn-filter:hover { background: var(--yellow-dark); }
        .btn-filter:active { transform: translateY(1px); }

        .btn-reset {
            height: 42px;
            padding: 0 18px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--dark);
            font-size: 13px;
            font-weight: 700;
            transition: background .15s ease;
        }

        .btn-reset:hover { background: var(--light); }

        /* Stat grid */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 14px;
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 18px 18px 16px;
            position: relative;
            overflow: hidden;
            border-bottom: 3px solid transparent;
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(17,17,17,.06);
        }

        .stat-card.accent-green  { border-bottom-color: var(--green); }
        .stat-card.accent-yellow { border-bottom-color: var(--yellow-dark); }
        .stat-card.accent-red    { border-bottom-color: var(--red); }
        .stat-card.accent-blue   { border-bottom-color: var(--blue); }
        .stat-card.accent-gray   { border-bottom-color: var(--gray-light); }

        .stat-top {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon svg { width: 18px; height: 18px; }

        .stat-icon.green  { background: var(--green-bg); color: var(--green); }
        .stat-icon.yellow { background: #fff6cf; color: #b58a00; }
        .stat-icon.red    { background: var(--red-bg); color: var(--red); }
        .stat-icon.blue   { background: var(--blue-bg); color: var(--blue); }
        .stat-icon.gray   { background: var(--gray-bg); color: var(--gray); }

        .stat-value {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .stat-label {
            font-size: 13px;
            color: var(--dark);
            font-weight: 600;
            margin-top: 10px;
        }

        .stat-foot {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 6px;
            font-size: 11.5px;
        }

        .stat-percent { font-weight: 700; }
        .stat-percent.good { color: var(--green); }
        .stat-percent.warn { color: var(--yellow-dark); }
        .stat-percent.bad  { color: var(--red); }
        .stat-percent.flat { color: var(--gray-light); }

        .stat-sub { color: var(--gray-light); }

        /* Footer */
        .dash-footer {
            text-align: center;
            font-size: 11.5px;
            color: var(--gray-light);
            padding: 24px 0 4px;
        }

        .dash-footer span { color: var(--yellow-dark); font-weight: 700; }

        /* Responsive */
        @media (max-width: 1200px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 900px) {
            .layout { grid-template-columns: 1fr; }
            .sidebar {
                position: static;
                height: auto;
                border-right: none;
                border-bottom: 1px solid var(--border);
            }
        }

        @media (max-width: 560px) {
            .stat-grid { grid-template-columns: 1fr; }
            .content { padding: 18px 16px 30px; }
            .filter-bar { flex-direction: column; align-items: stretch; }
            .btn-filter, .btn-reset { width: 100%; }
        }
    </style>
</head>

<body>

    <div class="layout">

        {{-- ═══════════ SIDEBAR ═══════════ --}}
        <aside class="sidebar">

            <div class="sidebar-brand">
                <div class="sidebar-brand-logo">K</div>
                <div class="sidebar-brand-name">KDM MILDOS</div>
            </div>

            <nav>
                <a href="{{ url('/dashboard') }}" class="nav-item active">
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
                <a href="#" class="nav-item">
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
                <a href="#" class="nav-item">
                    <span data-lucide="user-round"></span>
                    Employee
                    <span data-lucide="chevron-right" class="chevron"></span>
                </a>
                <a href="#" class="nav-item">
                    <span data-lucide="clock-4"></span>
                    Shift Management
                </a>
                <a href="#" class="nav-item">
                    <span data-lucide="calendar-x"></span>
                    Off Time
                    <span data-lucide="chevron-right" class="chevron"></span>
                </a>
                <a href="#" class="nav-item">
                    <span data-lucide="calendar-check-2"></span>
                    Attendance
                    <span data-lucide="chevron-right" class="chevron"></span>
                </a>
                <a href="#" class="nav-item">
                    <span data-lucide="file-text"></span>
                    Form Requests
                    <span data-lucide="chevron-right" class="chevron"></span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="#" class="nav-item">
                    <span data-lucide="settings"></span>
                    Pengaturan
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-item" style="width:100%; background:none; border:none; text-align:left;">
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

                <div class="user-chip">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'K', 0, 1)) }}
                    </div>
                    <div class="status-dot"></div>
                    <div class="user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                </div>

            </header>

            {{-- CONTENT --}}
            <div class="content">

                <div class="content-header">
                    <div>
                        <div class="content-title">Dashboard</div>
                        <div class="content-subtitle">Ringkasan kehadiran &amp; data kepegawaian.</div>
                    </div>
                </div>

                {{-- FILTER BAR --}}
                <form class="filter-bar" method="GET">
                    <div class="filter-date">
                        <span data-lucide="calendar"></span>
                        <input type="text" name="dates" placeholder="Choose Dates" autocomplete="off">
                    </div>
                    <button type="submit" class="btn-filter">Filter</button>
                    <button type="reset" class="btn-reset">Reset Filter</button>
                </form>

                {{-- STAT CARDS --}}
                <div class="stat-grid">

                    <div class="stat-card accent-green">
                        <div class="stat-top">
                            <div class="stat-icon green"><span data-lucide="check"></span></div>
                            <div class="stat-value">93</div>
                        </div>
                        <div class="stat-label">On Time</div>
                        <div class="stat-foot">
                            <span class="stat-percent good">75.61%</span>
                            <span class="stat-sub">On Time Today</span>
                        </div>
                    </div>

                    <div class="stat-card accent-yellow">
                        <div class="stat-top">
                            <div class="stat-icon yellow"><span data-lucide="alert-triangle"></span></div>
                            <div class="stat-value">9</div>
                        </div>
                        <div class="stat-label">Late</div>
                        <div class="stat-foot">
                            <span class="stat-percent warn">7.32%</span>
                            <span class="stat-sub">Late Today</span>
                        </div>
                    </div>

                    <div class="stat-card accent-red">
                        <div class="stat-top">
                            <div class="stat-icon red"><span data-lucide="x-circle"></span></div>
                            <div class="stat-value">23</div>
                        </div>
                        <div class="stat-label">Absent</div>
                        <div class="stat-foot">
                            <span class="stat-percent bad">18.7%</span>
                            <span class="stat-sub">Absent Today</span>
                        </div>
                    </div>

                    <div class="stat-card accent-blue">
                        <div class="stat-top">
                            <div class="stat-icon blue"><span data-lucide="clock"></span></div>
                            <div class="stat-value">1</div>
                        </div>
                        <div class="stat-label">Excused</div>
                        <div class="stat-foot">
                            <span class="stat-percent flat">0.81%</span>
                            <span class="stat-sub">Excused Today</span>
                        </div>
                    </div>

                    <div class="stat-card accent-gray">
                        <div class="stat-top">
                            <div class="stat-icon gray"><span data-lucide="calendar-off"></span></div>
                            <div class="stat-value">2</div>
                        </div>
                        <div class="stat-label">Off Day</div>
                        <div class="stat-foot">
                            <span class="stat-percent flat">1.63%</span>
                            <span class="stat-sub">Off Day Today</span>
                        </div>
                    </div>

                    <div class="stat-card accent-green">
                        <div class="stat-top">
                            <div class="stat-icon green"><span data-lucide="users"></span></div>
                            <div class="stat-value">123</div>
                        </div>
                        <div class="stat-label">Active Employees</div>
                    </div>

                    <div class="stat-card accent-gray">
                        <div class="stat-top">
                            <div class="stat-icon gray"><span data-lucide="user-minus"></span></div>
                            <div class="stat-value">4</div>
                        </div>
                        <div class="stat-label">Resigned Employees</div>
                    </div>

                    <div class="stat-card accent-blue">
                        <div class="stat-top">
                            <div class="stat-icon blue"><span data-lucide="user-round"></span></div>
                            <div class="stat-value">0</div>
                        </div>
                        <div class="stat-label">Part Time Employees</div>
                    </div>

                    <div class="stat-card accent-blue">
                        <div class="stat-top">
                            <div class="stat-icon blue"><span data-lucide="graduation-cap"></span></div>
                            <div class="stat-value">5</div>
                        </div>
                        <div class="stat-label">Internship Employees</div>
                    </div>

                    <div class="stat-card accent-green">
                        <div class="stat-top">
                            <div class="stat-icon green"><span data-lucide="user-plus"></span></div>
                            <div class="stat-value">13</div>
                        </div>
                        <div class="stat-label">New Employees</div>
                    </div>

                </div>

                <div class="dash-footer">
                    &copy; {{ date('Y') }}, made with <span>&hearts;</span> by <span>KDM Mildos</span>
                </div>

            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) { lucide.createIcons(); }
        });
    </script>

</body>
</html>