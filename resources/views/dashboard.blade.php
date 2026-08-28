<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - KDM Mildos</title>
    <meta name="description" content="HR Dashboard KDM Mildos - Ringkasan kehadiran dan data kepegawaian">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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
            --purple: #8b5cf6;
            --purple-bg: #f3e8ff;
            --gray-bg: #f0f0ee;
            --dark-bg: #27272a;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, sans-serif;
            background: var(--light);
            color: var(--black);
            line-height: 1.5;
        }

        a { text-decoration: none; color: inherit; }
        button, input, select { font: inherit; }

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
        .nav-item .chevron { margin-left: auto; width: 14px; height: 14px; color: var(--gray-light); transition: transform .2s ease; }

        .nav-item:hover { background: var(--light); color: var(--black); }

        .nav-item.active {
            background: #fff6cf;
            color: var(--black);
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
            margin-bottom: 18px;
        }

        .content-title { font-size: 22px; font-weight: 800; letter-spacing: -.5px; }
        .content-subtitle { font-size: 13px; color: var(--gray); margin-top: 3px; }

        .greeting-time { font-size: 12px; color: var(--gray-light); }

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
            cursor: pointer;
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
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .btn-reset:hover { background: var(--light); }

        /* ─── Main 2-column layout ─── */
        .dash-two-col {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: start;
        }

        .dash-left { display: flex; flex-direction: column; gap: 18px; min-width: 0; }
        .dash-right { display: flex; flex-direction: column; gap: 16px; position: sticky; top: 70px; }

        /* ─── Stat grid ─── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 16px 16px 14px;
            position: relative;
            overflow: hidden;
            border-bottom: 3px solid transparent;
            transition: transform .15s ease, box-shadow .15s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(17,17,17,.06);
        }

        .stat-card.accent-green  { border-bottom-color: var(--green); }
        .stat-card.accent-yellow { border-bottom-color: var(--yellow-dark); }
        .stat-card.accent-red    { border-bottom-color: var(--red); }
        .stat-card.accent-blue   { border-bottom-color: var(--blue); }
        .stat-card.accent-purple { border-bottom-color: var(--purple); }
        .stat-card.accent-gray   { border-bottom-color: var(--gray-light); }
        .stat-card.accent-dark   { border-bottom-color: #334155; }

        .stat-top { display: flex; align-items: center; gap: 12px; }

        .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .stat-icon svg { width: 17px; height: 17px; }
        .stat-icon.green  { background: var(--green-bg); color: var(--green); }
        .stat-icon.yellow { background: #fff6cf; color: #b58a00; }
        .stat-icon.red    { background: var(--red-bg); color: var(--red); }
        .stat-icon.blue   { background: var(--blue-bg); color: var(--blue); }
        .stat-icon.purple { background: var(--purple-bg); color: var(--purple); }
        .stat-icon.gray   { background: var(--gray-bg); color: var(--gray); }
        .stat-icon.dark   { background: #f1f5f9; color: #0f172a; }

        .stat-value { font-size: 22px; font-weight: 800; letter-spacing: -.5px; }
        .stat-label { font-size: 12.5px; color: var(--dark); font-weight: 600; margin-top: 9px; }

        .stat-foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 5px;
            font-size: 11.5px;
        }
        .stat-foot-left { display: flex; align-items: center; gap: 6px; }
        .stat-percent { font-weight: 700; }
        .stat-percent.good   { color: var(--green); }
        .stat-percent.warn   { color: var(--yellow-dark); }
        .stat-percent.bad    { color: var(--red); }
        .stat-percent.flat   { color: var(--gray-light); }
        .stat-percent.purple { color: var(--purple); }
        .stat-sub { color: var(--gray-light); }
        .mini-sparkline { width: 60px; height: 20px; flex-shrink: 0; }

        /* ─── Panels ─── */
        .dash-panel {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .dash-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .dash-panel-title { font-size: 14px; font-weight: 800; color: #0f172a; }

        .panel-select {
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: #fff;
            color: #64748b;
            outline: none;
            cursor: pointer;
        }

        /* 2-across bottom panels */
        .dash-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* Donut */
        .donut-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 8px 0;
        }

        .donut-chart-container {
            position: relative;
            width: 120px;
            height: 120px;
            flex-shrink: 0;
        }

        .donut-center-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            pointer-events: none;
        }

        .donut-center-text .title { font-size: 10px; color: #94a3b8; font-weight: 600; text-transform: uppercase; }
        .donut-center-text .number { font-size: 17px; font-weight: 800; color: #0f172a; line-height: 1.2; }

        .donut-legend { display: flex; flex-direction: column; gap: 7px; font-size: 12px; flex: 1; }

        .legend-item { display: flex; align-items: center; justify-content: space-between; }

        .legend-label { display: flex; align-items: center; gap: 6px; color: #64748b; font-weight: 500; }
        .legend-dot { width: 8px; height: 8px; border-radius: 2px; }
        .legend-val { font-weight: 700; color: #0f172a; }

        /* Activities */
        .activity-list { display: flex; flex-direction: column; gap: 11px; }

        .activity-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .activity-left { display: flex; align-items: center; gap: 9px; }

        .activity-icon {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .activity-icon svg { width: 14px; height: 14px; }
        .activity-icon.green  { background: var(--green-bg); color: var(--green); }
        .activity-icon.red    { background: var(--red-bg); color: var(--red); }
        .activity-icon.blue   { background: var(--blue-bg); color: var(--blue); }
        .activity-icon.gray   { background: var(--gray-bg); color: var(--gray); }
        .activity-icon.dark   { background: #f1f5f9; color: #0f172a; }
        .activity-icon.yellow { background: #fff6cf; color: #b58a00; }
        .activity-icon.purple { background: var(--purple-bg); color: var(--purple); }

        .activity-name { font-size: 12px; font-weight: 700; color: #0f172a; }
        .activity-desc { font-size: 11px; color: #64748b; }
        .activity-time { font-size: 10.5px; color: #94a3b8; white-space: nowrap; }

        .dash-panel-footer {
            margin-top: 16px;
            padding-top: 12px;
            border-top: 1px solid var(--border);
        }

        .panel-link {
            font-size: 12px;
            font-weight: 600;
            color: #2563eb;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: color .15s ease;
        }
        .panel-link:hover { color: #1d4ed8; }

        /* ─── Perlu Perhatian ─── */
        .attention-list { display: flex; flex-direction: column; gap: 10px; }

        .attention-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 10px;
            background: var(--light);
            border: 1px solid var(--border);
            transition: background .15s;
        }
        .attention-item:hover { background: #f0f0ed; }

        .attention-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .attention-icon svg { width: 16px; height: 16px; }
        .attention-icon.red    { background: var(--red-bg); color: var(--red); }
        .attention-icon.yellow { background: #fff6cf; color: #b58a00; }
        .attention-icon.blue   { background: var(--blue-bg); color: var(--blue); }

        .attention-body { flex: 1; min-width: 0; }
        .attention-title { font-size: 12.5px; font-weight: 700; color: #0f172a; }
        .attention-sub { font-size: 11px; color: var(--gray); margin-top: 1px; }
        .attention-count {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
            flex-shrink: 0;
        }
        .attention-arrow { color: var(--gray-light); flex-shrink: 0; }
        .attention-arrow svg { width: 14px; height: 14px; }

        /* ─── Quick Access ─── */
        .quick-access-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 12px;
        }

        .quick-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 9px;
            padding: 16px 10px;
            border-radius: 14px;
            border: 1px solid var(--border);
            background: var(--white);
            cursor: pointer;
            transition: background .15s, transform .1s, box-shadow .15s;
            text-align: center;
            text-decoration: none;
            color: var(--black);
        }

        .quick-btn:hover {
            background: #fff6cf;
            border-color: var(--yellow-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(232,191,0,.15);
        }

        .quick-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--light);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .quick-icon svg { width: 20px; height: 20px; }
        .quick-btn:hover .quick-icon { background: var(--yellow); }
        .quick-label { font-size: 11.5px; font-weight: 600; line-height: 1.3; }

        /* ─── Employee Overview chart ─── */
        .overview-chart-container { position: relative; height: 160px; width: 100%; }

        /* ─── RIGHT: Calendar ─── */
        .right-panel {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 16px;
        }

        .right-panel-title {
            font-size: 13px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .right-panel-link {
            font-size: 11px;
            font-weight: 600;
            color: var(--blue);
        }

        /* Calendar */
        .cal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .cal-month-label {
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
        }

        .cal-nav-btn {
            width: 26px;
            height: 26px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray);
            transition: background .12s;
        }
        .cal-nav-btn:hover { background: var(--light); }
        .cal-nav-btn svg { width: 13px; height: 13px; }

        .cal-today-btn {
            font-size: 11px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: var(--white);
            cursor: pointer;
            color: var(--gray);
            transition: background .12s;
        }
        .cal-today-btn:hover { background: var(--light); }

        .cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; }

        .cal-dow {
            text-align: center;
            font-size: 10.5px;
            font-weight: 700;
            color: var(--gray-light);
            padding: 3px 0 6px;
        }

        .cal-day {
            text-align: center;
            font-size: 12px;
            font-weight: 500;
            padding: 5px 2px;
            border-radius: 7px;
            cursor: default;
            transition: background .12s;
            color: var(--black);
        }

        .cal-day.other-month { color: #cbd5e1; }
        .cal-day.today {
            background: var(--yellow);
            font-weight: 800;
            color: var(--black);
        }
        .cal-day.selected {
            background: var(--yellow-dark);
            color: var(--black);
            font-weight: 700;
        }
        .cal-day:not(.other-month):not(.today):hover { background: var(--light); }

        /* Birthday */
        .birthday-list { display: flex; flex-direction: column; gap: 10px; }

        .birthday-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .birthday-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--yellow);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            flex-shrink: 0;
            color: var(--black);
        }

        .birthday-info { flex: 1; min-width: 0; }
        .birthday-name { font-size: 12px; font-weight: 700; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .birthday-dept { font-size: 10.5px; color: var(--gray-light); }

        .birthday-badge {
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 5px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .birthday-badge.today { background: var(--green-bg); color: var(--green); }
        .birthday-badge.soon  { background: var(--blue-bg); color: var(--blue); }

        .birthday-icon { color: var(--gray-light); flex-shrink: 0; }
        .birthday-icon svg { width: 14px; height: 14px; }

        /* Events */
        .events-list { display: flex; flex-direction: column; gap: 9px; }

        .event-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .event-color-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-top: 4px;
            flex-shrink: 0;
        }

        .event-title { font-size: 12px; font-weight: 700; color: #0f172a; }
        .event-date  { font-size: 10.5px; color: var(--gray-light); margin-top: 1px; }

        /* Footer */
        .dash-footer {
            text-align: center;
            font-size: 11.5px;
            color: var(--gray-light);
            padding: 20px 0 4px;
        }
        .dash-footer span { color: var(--yellow-dark); font-weight: 700; }

        /* ─── Responsive ─── */
        @media (max-width: 1280px) {
            .stat-grid { grid-template-columns: repeat(3, 1fr); }
            .dash-two-col { grid-template-columns: 1fr; }
            .dash-right { position: static; display: grid; grid-template-columns: repeat(3, 1fr); }
        }

        @media (max-width: 1024px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .quick-access-grid { grid-template-columns: repeat(3, 1fr); }
        }

        @media (max-width: 900px) {
            .layout { grid-template-columns: 1fr; }
            .sidebar { position: static; height: auto; border-right: none; border-bottom: 1px solid var(--border); }
            .dash-right { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 640px) {
            .stat-grid { grid-template-columns: 1fr 1fr; }
            .dash-row-2 { grid-template-columns: 1fr; }
            .content { padding: 16px 14px 28px; }
            .filter-bar { flex-direction: column; align-items: stretch; }
            .btn-filter, .btn-reset { width: 100%; }
            .quick-access-grid { grid-template-columns: repeat(3, 1fr); }
            .dash-right { grid-template-columns: 1fr; }
        }

        @media (max-width: 400px) {
            .stat-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>

    <div class="layout" x-data="{ hrmOpen: true }">

        {{-- ═══════════ SIDEBAR ═══════════ --}}
        <aside class="sidebar">

            <div class="sidebar-brand">
                <div class="sidebar-brand-logo">K</div>
                <div class="sidebar-brand-name">KDM MILDOS</div>
            </div>

            <nav>
                <a href="{{ route('dashboard') }}" class="nav-item active">
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
                <div class="nav-item" @click="hrmOpen = !hrmOpen" style="cursor: pointer;">
                    <span data-lucide="user-round"></span>
                    Employee
                    <span data-lucide="chevron-down" class="chevron" :style="hrmOpen ? 'transform: rotate(180deg)' : ''"></span>
                </div>
                <div class="nav-submenu" x-show="hrmOpen" x-transition>
                    <a href="{{ route('employees.index') }}" class="nav-subitem">
                        <span data-lucide="list" style="width:14px; height:14px; margin-right:6px;"></span>
                        Employee Management
                    </a>
                    <a href="{{ route('face-enrollments.index') }}" class="nav-subitem">
                        <span data-lucide="scan-face" style="width:14px; height:14px; margin-right:6px;"></span>
                        Face Enrollments
                    </a>
                </div>
                <a href="{{ route('shifts.index') }}" class="nav-item">
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
                <a href="{{ route('profile.edit') }}" class="nav-item">
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

                {{-- Header --}}
                <div class="content-header">
                    <div>
                        <div class="content-title" id="greeting-title">Selamat datang, {{ auth()->user()->name ?? 'Admin' }} 👋</div>
                        <div class="content-subtitle">Berikut ringkasan aktivitas HR hari ini.</div>
                    </div>
                </div>

                {{-- FILTER BAR --}}
                <form class="filter-bar" method="GET" action="{{ route('dashboard') }}">
                    <div class="filter-date">
                        <span data-lucide="calendar"></span>
                        <input type="text" id="dates-picker" name="dates" value="{{ $selectedDate }}" placeholder="Choose Dates (e.g. YYYY-MM-DD to YYYY-MM-DD)" autocomplete="off">
                    </div>
                    <button type="submit" class="btn-filter">Filter</button>
                    <a href="{{ route('dashboard') }}" class="btn-reset">Reset Filter</a>
                </form>

                {{-- 2-COLUMN LAYOUT --}}
                <div class="dash-two-col">

                    {{-- LEFT COLUMN --}}
                    <div class="dash-left">

                        {{-- STAT CARDS --}}
                        <div class="stat-grid">

                            {{-- 1. On Time --}}
                            <div class="stat-card accent-green">
                                <div class="stat-top">
                                    <div class="stat-icon green"><span data-lucide="check"></span></div>
                                    <div class="stat-value">{{ $onTimeCount }}</div>
                                </div>
                                <div class="stat-label">On Time</div>
                                <div class="stat-foot">
                                    <div class="stat-foot-left">
                                        <span class="stat-percent good">{{ $onTimePercent }}%</span>
                                        <span class="stat-sub">Hadir Tepat Waktu</span>
                                    </div>
                                    <svg class="mini-sparkline" viewBox="0 0 60 20" fill="none">
                                        <path d="M2 15 C 12 10, 22 18, 35 6 C 44 12, 54 3, 58 8" stroke="#19b95b" stroke-width="1.8" stroke-linecap="round"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- 2. Late --}}
                            <div class="stat-card accent-yellow">
                                <div class="stat-top">
                                    <div class="stat-icon yellow"><span data-lucide="alert-triangle"></span></div>
                                    <div class="stat-value">{{ $lateCount }}</div>
                                </div>
                                <div class="stat-label">Late</div>
                                <div class="stat-foot">
                                    <div class="stat-foot-left">
                                        <span class="stat-percent warn">{{ $latePercent }}%</span>
                                        <span class="stat-sub">Terlambat</span>
                                    </div>
                                    <svg class="mini-sparkline" viewBox="0 0 60 20" fill="none">
                                        <path d="M2 12 C 12 15, 22 8, 35 13 C 44 6, 54 15, 58 10" stroke="#e8bf00" stroke-width="1.8" stroke-linecap="round"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- 3. Absent --}}
                            <div class="stat-card accent-red">
                                <div class="stat-top">
                                    <div class="stat-icon red"><span data-lucide="calendar-x"></span></div>
                                    <div class="stat-value">{{ $absentCount }}</div>
                                </div>
                                <div class="stat-label">Absent</div>
                                <div class="stat-foot">
                                    <div class="stat-foot-left">
                                        <span class="stat-percent bad">{{ $absentPercent }}%</span>
                                        <span class="stat-sub">Tidak Hadir</span>
                                    </div>
                                    <svg class="mini-sparkline" viewBox="0 0 60 20" fill="none">
                                        <path d="M2 13 C 12 11, 22 17, 35 8 C 44 13, 54 4, 58 12" stroke="#e5484d" stroke-width="1.8" stroke-linecap="round"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- 4. Excused --}}
                            <div class="stat-card accent-blue">
                                <div class="stat-top">
                                    <div class="stat-icon blue"><span data-lucide="clock"></span></div>
                                    <div class="stat-value">{{ $excusedCount }}</div>
                                </div>
                                <div class="stat-label">Excused</div>
                                <div class="stat-foot">
                                    <div class="stat-foot-left">
                                        <span class="stat-percent flat">{{ $excusedPercent }}%</span>
                                        <span class="stat-sub">Izin / Cuti</span>
                                    </div>
                                    <svg class="mini-sparkline" viewBox="0 0 60 20" fill="none">
                                        <path d="M2 10 C 12 14, 22 6, 35 12 C 44 4, 54 12, 58 6" stroke="#2f7bf6" stroke-width="1.8" stroke-linecap="round"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- 5. Off Day --}}
                            <div class="stat-card accent-purple">
                                <div class="stat-top">
                                    <div class="stat-icon purple"><span data-lucide="calendar-off"></span></div>
                                    <div class="stat-value">{{ $offDayCount }}</div>
                                </div>
                                <div class="stat-label">Off Day</div>
                                <div class="stat-foot">
                                    <div class="stat-foot-left">
                                        <span class="stat-percent purple">{{ $offDayPercent }}%</span>
                                        <span class="stat-sub">Hari Libur</span>
                                    </div>
                                    <svg class="mini-sparkline" viewBox="0 0 60 20" fill="none">
                                        <path d="M2 12 C 12 8, 22 15, 35 6 C 44 13, 54 8, 58 10" stroke="#8b5cf6" stroke-width="1.8" stroke-linecap="round"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- 6. Active Employees --}}
                            <div class="stat-card accent-green">
                                <div class="stat-top">
                                    <div class="stat-icon green"><span data-lucide="user-check"></span></div>
                                    <div class="stat-value">{{ $activeEmployees }}</div>
                                </div>
                                <div class="stat-label">Active Employees</div>
                                <div class="stat-foot">
                                    <span class="stat-sub">Total Karyawan Aktif</span>
                                </div>
                            </div>

                            {{-- 7. Resigned Employees --}}
                            <div class="stat-card accent-gray">
                                <div class="stat-top">
                                    <div class="stat-icon gray"><span data-lucide="user-minus"></span></div>
                                    <div class="stat-value">{{ $resignedEmployees }}</div>
                                </div>
                                <div class="stat-label">Resigned Employees</div>
                                <div class="stat-foot">
                                    <span class="stat-sub">Total Resigned</span>
                                </div>
                            </div>

                            {{-- 8. Blacklisted Employees --}}
                            <div class="stat-card accent-dark">
                                <div class="stat-top">
                                    <div class="stat-icon dark"><span data-lucide="user-x"></span></div>
                                    <div class="stat-value">{{ $blacklistedEmployees }}</div>
                                </div>
                                <div class="stat-label">Blacklisted Employees</div>
                                <div class="stat-foot">
                                    <span class="stat-sub">Total Blacklisted</span>
                                </div>
                            </div>

                            {{-- 9. Part Time --}}
                            <div class="stat-card accent-blue">
                                <div class="stat-top">
                                    <div class="stat-icon blue"><span data-lucide="user-round"></span></div>
                                    <div class="stat-value">{{ $partTimeEmployees }}</div>
                                </div>
                                <div class="stat-label">Part Time Employees</div>
                                <div class="stat-foot">
                                    <span class="stat-sub">Total Part Time</span>
                                </div>
                            </div>

                            {{-- 10. Internship --}}
                            <div class="stat-card accent-blue">
                                <div class="stat-top">
                                    <div class="stat-icon blue"><span data-lucide="graduation-cap"></span></div>
                                    <div class="stat-value">{{ $internshipEmployees }}</div>
                                </div>
                                <div class="stat-label">Internship Employees</div>
                                <div class="stat-foot">
                                    <span class="stat-sub">Total Magang</span>
                                </div>
                            </div>

                            {{-- 11. New Employees --}}
                            <div class="stat-card accent-green">
                                <div class="stat-top">
                                    <div class="stat-icon green"><span data-lucide="user-plus"></span></div>
                                    <div class="stat-value">{{ $newEmployees }}</div>
                                </div>
                                <div class="stat-label">New Employees</div>
                                <div class="stat-foot">
                                    <span class="stat-sub">Bulan Ini</span>
                                </div>
                            </div>

                        </div>{{-- /stat-grid --}}

                        {{-- ROW: Ringkasan Kehadiran + Tren Kehadiran --}}
                        <div class="dash-row-2">

                            {{-- Ringkasan Kehadiran --}}
                            <div class="dash-panel">
                                <div class="dash-panel-header">
                                    <div class="dash-panel-title">Ringkasan Kehadiran</div>
                                </div>
                                <div class="donut-wrapper">
                                    <div class="donut-chart-container">
                                        <canvas id="attendanceDonutChart"></canvas>
                                        <div class="donut-center-text">
                                            <div class="title">Total</div>
                                            <div class="number">{{ $totalAttendance }}</div>
                                        </div>
                                    </div>
                                    <div class="donut-legend">
                                        <div class="legend-item">
                                            <div class="legend-label"><span class="legend-dot" style="background:#19b95b;"></span><span>On Time</span></div>
                                            <div class="legend-val">{{ $onTimeCount }} ({{ $onTimePercent }}%)</div>
                                        </div>
                                        <div class="legend-item">
                                            <div class="legend-label"><span class="legend-dot" style="background:#e8bf00;"></span><span>Late</span></div>
                                            <div class="legend-val">{{ $lateCount }} ({{ $latePercent }}%)</div>
                                        </div>
                                        <div class="legend-item">
                                            <div class="legend-label"><span class="legend-dot" style="background:#e5484d;"></span><span>Absent</span></div>
                                            <div class="legend-val">{{ $absentCount }} ({{ $absentPercent }}%)</div>
                                        </div>
                                        <div class="legend-item">
                                            <div class="legend-label"><span class="legend-dot" style="background:#2f7bf6;"></span><span>Excused</span></div>
                                            <div class="legend-val">{{ $excusedCount }} ({{ $excusedPercent }}%)</div>
                                        </div>
                                        <div class="legend-item">
                                            <div class="legend-label"><span class="legend-dot" style="background:#8b5cf6;"></span><span>Off Day</span></div>
                                            <div class="legend-val">{{ $offDayCount }} ({{ $offDayPercent }}%)</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dash-panel-footer">
                                    <a href="#" class="panel-link">Lihat Laporan Lengkap &rarr;</a>
                                </div>
                            </div>

                            {{-- Tren Kehadiran --}}
                            <div class="dash-panel">
                                <div class="dash-panel-header">
                                    <div class="dash-panel-title">Tren Kehadiran</div>
                                    <span style="font-size:11px; color: var(--gray-light);">{{ count($trendDays) }} Hari</span>
                                </div>
                                <div style="position: relative; height: 150px; width: 100%;">
                                    <canvas id="attendanceTrendChart"></canvas>
                                </div>
                                <div class="dash-panel-footer">
                                    <a href="#" class="panel-link">Lihat Analitik Lengkap &rarr;</a>
                                </div>
                            </div>

                        </div>{{-- /dash-row-2 --}}

                        {{-- ROW: Perlu Perhatian + Aktivitas Terbaru --}}
                        <div class="dash-row-2">

                            {{-- Perlu Perhatian --}}
                            <div class="dash-panel">
                                <div class="dash-panel-header">
                                    <div class="dash-panel-title">Perlu Perhatian</div>
                                    <a href="{{ route('employees.index') }}" class="panel-link" style="font-size:11px;">Lihat Semua</a>
                                </div>
                                <div class="attention-list">
                                    <a href="{{ route('employees.index') }}" class="attention-item" style="text-decoration:none; color:inherit;">
                                        <div class="attention-icon red"><span data-lucide="user-x"></span></div>
                                        <div class="attention-body">
                                            <div class="attention-title">Karyawan belum hadir hari ini</div>
                                            <div class="attention-sub">Perlu dicek dan ditindaklanjuti</div>
                                        </div>
                                        <div class="attention-count">{{ $absentToday }}</div>
                                        <div class="attention-arrow"><span data-lucide="chevron-right"></span></div>
                                    </a>
                                    <a href="{{ route('employees.index') }}" class="attention-item" style="text-decoration:none; color:inherit;">
                                        <div class="attention-icon yellow"><span data-lucide="user-plus"></span></div>
                                        <div class="attention-body">
                                            <div class="attention-title">Karyawan baru bulan ini</div>
                                            <div class="attention-sub">Perlu onboarding &amp; orientasi</div>
                                        </div>
                                        <div class="attention-count">{{ $newThisMonth }}</div>
                                        <div class="attention-arrow"><span data-lucide="chevron-right"></span></div>
                                    </a>
                                    <a href="{{ route('shifts.index') }}" class="attention-item" style="text-decoration:none; color:inherit;">
                                        <div class="attention-icon blue"><span data-lucide="clock-4"></span></div>
                                        <div class="attention-body">
                                            <div class="attention-title">Shift aktif terdaftar</div>
                                            <div class="attention-sub">Periksa jadwal shift karyawan</div>
                                        </div>
                                        <div class="attention-count">{{ \App\Models\Shift::where('status','Active')->count() }}</div>
                                        <div class="attention-arrow"><span data-lucide="chevron-right"></span></div>
                                    </a>
                                </div>
                            </div>

                            {{-- Aktivitas Terbaru --}}
                            <div class="dash-panel">
                                <div class="dash-panel-header">
                                    <div class="dash-panel-title">Aktivitas Terbaru</div>
                                </div>
                                <div class="activity-list">
                                    @forelse ($activities as $act)
                                        <div class="activity-item">
                                            <div class="activity-left">
                                                @if ($act->type === 'new_employee')
                                                    <div class="activity-icon green"><span data-lucide="user-plus"></span></div>
                                                @elseif ($act->type === 'absent')
                                                    <div class="activity-icon red"><span data-lucide="calendar-x"></span></div>
                                                @elseif ($act->type === 'excused')
                                                    <div class="activity-icon blue"><span data-lucide="clock"></span></div>
                                                @elseif ($act->type === 'resigned')
                                                    <div class="activity-icon gray"><span data-lucide="user-minus"></span></div>
                                                @elseif ($act->type === 'blacklisted')
                                                    <div class="activity-icon dark"><span data-lucide="user-x"></span></div>
                                                @elseif ($act->type === 'update')
                                                    <div class="activity-icon purple"><span data-lucide="pencil"></span></div>
                                                @else
                                                    <div class="activity-icon yellow"><span data-lucide="activity"></span></div>
                                                @endif
                                                <div>
                                                    <div class="activity-name">{{ $act->employee_name }}</div>
                                                    <div class="activity-desc">{{ $act->description }}</div>
                                                </div>
                                            </div>
                                            <div class="activity-time">
                                                {{ $act->occurred_at ? $act->occurred_at->diffForHumans(null, true) . ' lalu' : '-' }}
                                            </div>
                                        </div>
                                    @empty
                                        <div style="font-size:12px; color:#94a3b8; text-align:center; padding:20px;">
                                            Belum ada aktivitas terbaru.
                                        </div>
                                    @endforelse
                                </div>
                                <div class="dash-panel-footer">
                                    <a href="#" class="panel-link">Lihat Semua Aktivitas &rarr;</a>
                                </div>
                            </div>

                        </div>{{-- /dash-row-2 --}}

                        {{-- Employee Overview --}}
                        <div class="dash-panel">
                            <div class="dash-panel-header">
                                <div class="dash-panel-title">Employee Overview</div>
                                <span style="font-size:11px; color: var(--gray-light);">6 Bulan Terakhir</span>
                            </div>
                            <div class="overview-chart-container">
                                <canvas id="employeeOverviewChart"></canvas>
                            </div>
                        </div>

                        {{-- Akses Cepat --}}
                        <div class="dash-panel">
                            <div class="dash-panel-header" style="margin-bottom: 12px;">
                                <div class="dash-panel-title">Akses Cepat</div>
                            </div>
                            <div class="quick-access-grid">

                                <a href="{{ route('employees.index') }}" class="quick-btn" id="qa-tambah-karyawan">
                                    <div class="quick-icon"><span data-lucide="user-plus"></span></div>
                                    <span class="quick-label">Tambah Karyawan</span>
                                </a>

                                <a href="#" class="quick-btn" id="qa-pengajuan-cuti">
                                    <div class="quick-icon"><span data-lucide="calendar-plus"></span></div>
                                    <span class="quick-label">Pengajuan Cuti/Izin</span>
                                </a>

                                <a href="#" class="quick-btn" id="qa-attendance-manual">
                                    <div class="quick-icon"><span data-lucide="clipboard-check"></span></div>
                                    <span class="quick-label">Input Attendance Manual</span>
                                </a>

                                <a href="{{ route('shifts.index') }}" class="quick-btn" id="qa-tambah-shift">
                                    <div class="quick-icon"><span data-lucide="clock-4"></span></div>
                                    <span class="quick-label">Tambah Shift Baru</span>
                                </a>

                                <a href="#" class="quick-btn" id="qa-report">
                                    <div class="quick-icon"><span data-lucide="bar-chart-2"></span></div>
                                    <span class="quick-label">Generate Report Kehadiran</span>
                                </a>

                                <a href="{{ route('employees.index') }}" class="quick-btn" id="qa-lainnya">
                                    <div class="quick-icon"><span data-lucide="more-horizontal"></span></div>
                                    <span class="quick-label">Hal Lainnya</span>
                                </a>

                            </div>
                        </div>

                    </div>{{-- /dash-left --}}

                    {{-- RIGHT COLUMN --}}
                    <div class="dash-right">

                        {{-- Calendar --}}
                        <div class="right-panel">
                            <div class="right-panel-title">
                                <span>Kalender</span>
                            </div>

                            {{-- Calendar Header --}}
                            <div class="cal-header" id="cal-header">
                                <div style="display:flex; gap:4px;">
                                    <button class="cal-nav-btn" id="cal-prev" type="button" aria-label="Bulan sebelumnya">
                                        <span data-lucide="chevron-left"></span>
                                    </button>
                                    <button class="cal-nav-btn" id="cal-next" type="button" aria-label="Bulan berikutnya">
                                        <span data-lucide="chevron-right"></span>
                                    </button>
                                </div>
                                <div class="cal-month-label" id="cal-month-label"></div>
                                <button class="cal-today-btn" id="cal-today-btn" type="button">Hari Ini</button>
                            </div>

                            {{-- Day-of-week headers --}}
                            <div class="cal-grid" id="cal-dow">
                                <div class="cal-dow">Sen</div>
                                <div class="cal-dow">Sel</div>
                                <div class="cal-dow">Rab</div>
                                <div class="cal-dow">Kam</div>
                                <div class="cal-dow">Jum</div>
                                <div class="cal-dow">Sab</div>
                                <div class="cal-dow">Min</div>
                            </div>

                            {{-- Day cells rendered by JS --}}
                            <div class="cal-grid" id="cal-days"></div>
                        </div>

                        {{-- Birthday Calendar --}}
                        <div class="right-panel">
                            <div class="right-panel-title">
                                <span>Birthday Kalender</span>
                                <a href="{{ route('employees.index') }}" class="right-panel-link">Lihat Semua</a>
                            </div>
                            <div class="birthday-list">
                                @forelse ($birthdayEmployees as $bday)
                                    <div class="birthday-item">
                                        <div class="birthday-avatar">
                                            {{ strtoupper(substr($bday['name'], 0, 1)) }}{{ strtoupper(substr(explode(' ', $bday['name'])[1] ?? '', 0, 1)) }}
                                        </div>
                                        <div class="birthday-info">
                                            <div class="birthday-name">{{ $bday['name'] }}</div>
                                            <div class="birthday-dept">{{ $bday['department'] }}</div>
                                        </div>
                                        @if ($bday['is_today'])
                                            <span class="birthday-badge today">Hari Ini 🎂</span>
                                        @else
                                            <span class="birthday-badge soon">{{ $bday['birth_date_display'] }}</span>
                                        @endif
                                        <div class="birthday-icon"><span data-lucide="cake"></span></div>
                                    </div>
                                @empty
                                    <div style="font-size:12px; color:#94a3b8; text-align:center; padding:12px 0;">
                                        Tidak ada data ulang tahun.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- Upcoming Events --}}
                        <div class="right-panel">
                            <div class="right-panel-title">
                                <span>Upcoming Events</span>
                            </div>
                            <div class="events-list">
                                @forelse ($upcomingEvents as $evt)
                                    <div class="event-item">
                                        <div class="event-color-dot" style="background: {{ $evt->color }};"></div>
                                        <div>
                                            <div class="event-title">{{ $evt->title }}</div>
                                            <div class="event-date">
                                                {{ \Carbon\Carbon::parse($evt->start_date)->locale('id')->isoFormat('D MMM YYYY') }}
                                                @if ($evt->end_date && $evt->end_date->ne($evt->start_date))
                                                    – {{ \Carbon\Carbon::parse($evt->end_date)->locale('id')->isoFormat('D MMM YYYY') }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div style="font-size:12px; color:#94a3b8; text-align:center; padding:12px 0;">
                                        Tidak ada event mendatang.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    </div>{{-- /dash-right --}}

                </div>{{-- /dash-two-col --}}

                <div class="dash-footer">
                    &copy; {{ date('Y') }}, made with <span>&hearts;</span> by <span>KDM Strategy</span>
                </div>

            </div>{{-- /content --}}

        </div>{{-- /main --}}

    </div>{{-- /layout --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Lucide icons
            if (window.lucide) { lucide.createIcons(); }

            // ─── Greeting based on server time ────────────────────────────
            const serverDate = '{{ $serverDate }}';
            const serverHour = parseInt(serverDate.split('-')[0]); // fallback
            try {
                const now = new Date(serverDate + 'T00:00:00+07:00');
                const h = now.getHours();
                const greet = h < 11 ? 'Selamat pagi' : h < 15 ? 'Selamat siang' : h < 18 ? 'Selamat sore' : 'Selamat malam';
                const el = document.getElementById('greeting-title');
                if (el) {
                    el.innerHTML = greet + ', {{ addslashes(auth()->user()->name ?? "Admin") }} 👋';
                }
            } catch(e) {}

            // ─── Interactive Calendar ──────────────────────────────────────
            const todayServer = serverDate; // 'YYYY-MM-DD'
            const todayParts = todayServer.split('-');
            const todayY = parseInt(todayParts[0]);
            const todayM = parseInt(todayParts[1]) - 1; // 0-indexed
            const todayD = parseInt(todayParts[2]);

            let calYear = todayY;
            let calMonth = todayM;
            let selectedDay = null;

            const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            function renderCalendar() {
                const label = document.getElementById('cal-month-label');
                const grid = document.getElementById('cal-days');
                if (!label || !grid) return;

                label.textContent = monthNames[calMonth] + ' ' + calYear;
                grid.innerHTML = '';

                // First day of month (0=Sun, 1=Mon ... 6=Sat) → convert to Mon-first (0=Mon)
                const firstDay = new Date(calYear, calMonth, 1).getDay();
                const startOffset = (firstDay === 0) ? 6 : firstDay - 1;

                const daysInMonth = new Date(calYear, calMonth + 1, 0).getDate();
                const daysInPrev = new Date(calYear, calMonth, 0).getDate();

                // Previous month padding
                for (let i = startOffset - 1; i >= 0; i--) {
                    const d = document.createElement('div');
                    d.className = 'cal-day other-month';
                    d.textContent = daysInPrev - i;
                    grid.appendChild(d);
                }

                // Current month days
                for (let day = 1; day <= daysInMonth; day++) {
                    const d = document.createElement('div');
                    d.className = 'cal-day';
                    d.textContent = day;
                    d.dataset.date = calYear + '-' + String(calMonth + 1).padStart(2,'0') + '-' + String(day).padStart(2,'0');

                    const isToday = (calYear === todayY && calMonth === todayM && day === todayD);
                    const isSelected = selectedDay && d.dataset.date === selectedDay;

                    if (isToday) d.classList.add('today');
                    if (isSelected && !isToday) d.classList.add('selected');

                    d.addEventListener('click', function () {
                        selectedDay = this.dataset.date;
                        renderCalendar();
                    });

                    grid.appendChild(d);
                }

                // Next month padding to fill 6 rows
                const totalCells = startOffset + daysInMonth;
                const remainder = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
                for (let i = 1; i <= remainder; i++) {
                    const d = document.createElement('div');
                    d.className = 'cal-day other-month';
                    d.textContent = i;
                    grid.appendChild(d);
                }

                if (window.lucide) { lucide.createIcons(); }
            }

            document.getElementById('cal-prev')?.addEventListener('click', function () {
                calMonth--;
                if (calMonth < 0) { calMonth = 11; calYear--; }
                renderCalendar();
            });

            document.getElementById('cal-next')?.addEventListener('click', function () {
                calMonth++;
                if (calMonth > 11) { calMonth = 0; calYear++; }
                renderCalendar();
            });

            document.getElementById('cal-today-btn')?.addEventListener('click', function () {
                calYear = todayY;
                calMonth = todayM;
                selectedDay = null;
                renderCalendar();
            });

            renderCalendar();

            // ─── Attendance Donut Chart ────────────────────────────────────
            const donutCtx = document.getElementById('attendanceDonutChart')?.getContext('2d');
            if (donutCtx) {
                const totalData = {{ $onTimeCount + $lateCount + $absentCount + $excusedCount + $offDayCount }};
                new Chart(donutCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['On Time', 'Late', 'Absent', 'Excused', 'Off Day'],
                        datasets: [{
                            data: [
                                {{ $onTimeCount }}, {{ $lateCount }},
                                {{ $absentCount }}, {{ $excusedCount }}, {{ $offDayCount }}
                            ],
                            backgroundColor: ['#19b95b', '#e8bf00', '#e5484d', '#2f7bf6', '#8b5cf6'],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(ctx) { return ctx.label + ': ' + ctx.raw; }
                                }
                            }
                        }
                    }
                });
            }

            // ─── Attendance Trend Line Chart ───────────────────────────────
            const trendCtx = document.getElementById('attendanceTrendChart')?.getContext('2d');
            if (trendCtx) {
                const grad = trendCtx.createLinearGradient(0, 0, 0, 140);
                grad.addColorStop(0, 'rgba(139, 92, 246, 0.22)');
                grad.addColorStop(1, 'rgba(139, 92, 246, 0.00)');
                new Chart(trendCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($trendDays) !!},
                        datasets: [{
                            label: 'On Time',
                            data: {!! json_encode($trendValues) !!},
                            borderColor: '#8b5cf6',
                            borderWidth: 2.5,
                            backgroundColor: grad,
                            fill: true,
                            tension: 0.35,
                            pointBackgroundColor: '#8b5cf6',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                padding: 8,
                                displayColors: false,
                                callbacks: {
                                    label: function(ctx) { return '● On Time: ' + ctx.parsed.y; }
                                }
                            }
                        },
                        scales: {
                            x: { grid: { display: false }, ticks: { font: { size: 10 }, color: '#94a3b8' } },
                            y: {
                                min: 0,
                                ticks: { font: { size: 10 }, color: '#94a3b8' },
                                grid: { color: '#f1f5f9' }
                            }
                        }
                    }
                });
            }

            // ─── Employee Overview Line Chart ─────────────────────────────
            const overviewCtx = document.getElementById('employeeOverviewChart')?.getContext('2d');
            if (overviewCtx) {
                new Chart(overviewCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($overviewMonths) !!},
                        datasets: [
                            {
                                label: 'Active',
                                data: {!! json_encode($overviewActive) !!},
                                borderColor: '#2f7bf6',
                                borderWidth: 2,
                                pointRadius: 4,
                                pointBackgroundColor: '#2f7bf6',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                tension: 0.3,
                                fill: false
                            },
                            {
                                label: 'New',
                                data: {!! json_encode($overviewNew) !!},
                                borderColor: '#19b95b',
                                borderWidth: 2,
                                pointRadius: 4,
                                pointBackgroundColor: '#19b95b',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                tension: 0.3,
                                fill: false
                            },
                            {
                                label: 'Resigned',
                                data: {!! json_encode($overviewResigned) !!},
                                borderColor: '#e5484d',
                                borderWidth: 2,
                                pointRadius: 4,
                                pointBackgroundColor: '#e5484d',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                tension: 0.3,
                                fill: false
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: { font: { size: 11 }, boxWidth: 10, padding: 14 }
                            }
                        },
                        scales: {
                            x: { grid: { display: false }, ticks: { font: { size: 10 }, color: '#94a3b8' } },
                            y: {
                                min: 0,
                                ticks: { font: { size: 10 }, color: '#94a3b8' },
                                grid: { color: '#f1f5f9' }
                            }
                        }
                    }
                });
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof flatpickr !== 'undefined') {
                flatpickr("#dates-picker", {
                    mode: "range",
                    dateFormat: "Y-m-d",
                    separator: " to ",
                    locale: { rangeSeparator: " to " }
                });
            }
        });
    </script>
</body>
</html>