<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KDM - Sistem Informasi & Kelola Data Karyawan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>
    <style>
        /* ── DESIGN SYSTEM & CONSTANTS ── */
        :root {
            --yellow:      #ffd900;
            --yellow-dark: #e8bf00;
            --black:       #111111;
            --dark:        #171717;
            --gray:        #555555;
            --gray-light:  #9a9a95;
            --light:       #fafaf8;
            --border:      #ecece9;
            --white:       #ffffff;
            --green:       #10b981;
            --red:         #ef4444;
            --blue:        #3b82f6;
            --purple:      #8b5cf6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, sans-serif;
            color: var(--black);
            background: var(--white);
            line-height: 1.5;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button, input {
            font: inherit;
        }

        img {
            max-width: 100%;
            display: block;
        }

        .wrap {
            width: min(1240px, calc(100% - 40px));
            margin: auto;
        }

        /* ── HEADER ── */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255,255,255,.9);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border);
        }

        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 72px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-logo-box {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--yellow);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 18px;
            color: var(--black);
            border: 1px solid var(--yellow-dark);
            flex-shrink: 0;
        }

        .brand-name {
            font-size: 18px;
            font-weight: 900;
            letter-spacing: -.5px;
            color: var(--black);
        }

        .main-nav {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link {
            padding: 9px 14px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--gray);
            transition: .2s ease;
            position: relative;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--black);
        }

        .nav-link.active::after {
            content: "";
            position: absolute;
            left: 14px;
            right: 14px;
            bottom: 2px;
            height: 2px;
            border-radius: 2px;
            background: var(--yellow-dark);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .link-plain {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--gray);
            padding: 9px 12px;
            transition: color .2s;
        }

        .link-plain:hover {
            color: var(--black);
        }

        .btn-cta {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            border-radius: 10px;
            background: var(--black);
            color: var(--white);
            font-size: 13.5px;
            font-weight: 700;
            transition: .2s ease;
            border: 1px solid var(--black);
        }

        .btn-cta:hover {
            background: var(--yellow);
            color: var(--black);
            border-color: var(--yellow-dark);
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(255,217,0,.3);
        }

        /* Mobile Menu Button */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--black);
            padding: 8px;
        }

        /* ── HERO SECTION ── */
        .hero {
            padding: 72px 0 54px;
            background: radial-gradient(circle at 10% 20%, rgba(255, 217, 0, 0.04) 0%, transparent 40%);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.1fr 1.2fr;
            gap: 56px;
            align-items: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 217, 0, 0.08);
            border: 1px solid rgba(232, 191, 0, 0.2);
            color: #7a6300;
            border-radius: 99px;
            padding: 8px 16px;
            font-size: 12.5px;
            font-weight: 700;
            margin-bottom: 22px;
        }

        .hero h1 {
            font-size: clamp(34px, 4vw, 48px);
            line-height: 1.15;
            letter-spacing: -1.6px;
            font-weight: 900;
            color: var(--black);
        }

        .hero h1 .accent {
            color: var(--yellow-dark);
            position: relative;
            display: inline-block;
        }

        .hero h1 .accent::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 0;
            right: 0;
            height: 8px;
            background: rgba(255, 217, 0, 0.25);
            z-index: -1;
            border-radius: 4px;
        }

        .hero-text {
            max-width: 480px;
            margin-top: 20px;
            font-size: 15px;
            color: var(--gray);
            line-height: 1.6;
        }

        .hero-actions {
            display: flex;
            gap: 14px;
            margin-top: 32px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 24px;
            border-radius: 12px;
            background: var(--black);
            color: var(--white);
            font-size: 14px;
            font-weight: 700;
            transition: .2s ease;
            border: 1px solid var(--black);
        }

        .btn-primary:hover {
            background: var(--yellow);
            color: var(--black);
            border-color: var(--yellow-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(255, 217, 0, 0.35);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 24px;
            border-radius: 12px;
            background: var(--white);
            border: 1px solid var(--border);
            font-size: 14px;
            font-weight: 700;
            color: var(--black);
            transition: .2s ease;
        }

        .btn-secondary:hover {
            border-color: var(--gray-light);
            background: var(--light);
            transform: translateY(-2px);
        }

        .hero-trust {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            margin-top: 40px;
            border-top: 1px solid var(--border);
            padding-top: 24px;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: var(--gray);
            font-weight: 600;
        }

        .trust-icon {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: rgba(255, 217, 0, 0.1);
            border: 1px solid rgba(232, 191, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--yellow-dark);
        }

        /* ── HERO VISUAL (MOCK DASHBOARD) ── */
        .hero-visual {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .mock-panel {
            width: 100%;
            background: var(--white);
            border-radius: 18px;
            border: 1px solid var(--border);
            box-shadow: 
                0 4px 6px -1px rgba(0,0,0,0.02), 
                0 25px 50px -12px rgba(0,0,0,0.08);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            font-size: 10.5px;
        }

        .mock-topbar {
            height: 48px;
            border-bottom: 1px solid var(--border);
            background: #fafaf9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
        }

        .mock-topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mock-window-dots {
            display: flex;
            gap: 6px;
        }

        .mock-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        .mock-dot.red { background: #ff5f56; }
        .mock-dot.yellow { background: #ffbd2e; }
        .mock-dot.green { background: #27c93f; }

        .mock-search-bar {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 4px 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--gray-light);
            width: 180px;
            font-size: 9.5px;
        }

        .mock-topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mock-bell {
            position: relative;
            color: var(--gray);
            font-size: 13px;
        }
        .mock-bell::after {
            content: '';
            position: absolute;
            top: 1px;
            right: 1px;
            width: 4px;
            height: 4px;
            background: var(--red);
            border-radius: 50%;
        }

        .mock-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--yellow);
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .mock-body {
            display: grid;
            grid-template-columns: 128px 1fr;
            min-height: 410px;
            background: #fbfbf9;
        }

        .mock-sidebar {
            background: #fafaf9;
            border-right: 1px solid var(--border);
            padding: 14px 8px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .mock-sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .mock-sidebar-brand {
            font-weight: 800;
            font-size: 12px;
            padding: 0 8px 14px;
            color: var(--black);
            display: flex;
            align-items: center;
            gap: 6px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 8px;
        }

        .mock-sidebar-brand::before {
            content: '';
            width: 8px;
            height: 8px;
            background: var(--yellow);
            border-radius: 2px;
            border: 1px solid var(--black);
        }

        .mock-menu-header {
            font-size: 8px;
            font-weight: 800;
            color: var(--gray-light);
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 8px 8px 4px;
        }

        .mock-menu-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 8px;
            border-radius: 6px;
            color: #555;
            font-weight: 600;
            cursor: pointer;
        }

        .mock-menu-item:hover {
            background: rgba(0,0,0,0.03);
            color: var(--black);
        }

        .mock-menu-item.active {
            background: var(--yellow);
            color: var(--black);
            font-weight: 700;
            border: 1px solid var(--black);
        }

        .mock-menu-item-icon {
            font-size: 11px;
            width: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .mock-sidebar-footer {
            padding: 8px;
            border-top: 1px solid var(--border);
            margin-top: 8px;
        }

        .mock-content {
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .mock-content-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .mock-content-title h3 {
            font-size: 13.5px;
            font-weight: 800;
            color: var(--black);
        }
        .mock-content-title p {
            font-size: 9.5px;
            color: var(--gray);
            margin-top: 1px;
        }

        .mock-header-actions {
            display: flex;
            gap: 6px;
        }

        .mock-btn {
            background: var(--white);
            border: 1px solid var(--border);
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 9px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
            color: var(--black);
        }

        .mock-btn.primary {
            background: var(--black);
            color: var(--white);
            border: 1px solid var(--black);
        }

        /* Stat Grid */
        .mock-stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 6px;
        }

        .mock-stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 8px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 54px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.01);
        }

        .mock-stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 9px;
            color: var(--gray);
        }

        .mock-stat-icon {
            font-size: 10px;
            width: 16px;
            height: 16px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .mock-stat-icon.green { background: rgba(16, 185, 129, 0.12); color: var(--green); }
        .mock-stat-icon.yellow { background: rgba(232, 191, 0, 0.12); color: var(--yellow-dark); }
        .mock-stat-icon.red { background: rgba(239, 68, 68, 0.12); color: var(--red); }
        .mock-stat-icon.blue { background: rgba(59, 130, 246, 0.12); color: var(--blue); }

        .mock-stat-val {
            font-size: 13px;
            font-weight: 800;
            color: var(--black);
            margin: 4px 0 2px;
        }

        .mock-stat-trend {
            font-size: 8px;
            font-weight: 600;
        }
        .mock-stat-trend.up { color: var(--green); }
        .mock-stat-trend.down { color: var(--red); }
        .mock-stat-trend.neutral { color: var(--yellow-dark); }

        .mock-stat-grid-row2 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
        }

        /* Bottom Section Grid */
        .mock-charts-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr 1fr;
            gap: 8px;
        }

        .mock-chart-box {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 8px;
            display: flex;
            flex-direction: column;
        }

        .mock-chart-title {
            font-weight: 800;
            font-size: 9.5px;
            color: var(--black);
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
            padding-bottom: 4px;
        }

        .mock-chart-title span.link {
            font-size: 8px;
            color: var(--yellow-dark);
            cursor: pointer;
            font-weight: 700;
        }

        /* Donut Chart representation */
        .mock-donut-container {
            display: flex;
            align-items: center;
            justify-content: space-around;
            flex: 1;
            padding: 4px 0;
        }

        .mock-donut {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: conic-gradient(
                var(--green) 0% 86%, 
                var(--red) 86% 96%, 
                var(--yellow) 96% 100%
            );
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mock-donut-inner {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--white);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            font-weight: 800;
        }

        .mock-donut-legend {
            display: flex;
            flex-direction: column;
            gap: 2px;
            font-size: 8px;
        }

        .mock-legend-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .mock-legend-color {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }
        .mock-legend-color.green { background: var(--green); }
        .mock-legend-color.yellow { background: var(--yellow); }
        .mock-legend-color.red { background: var(--red); }

        /* SVG Line Chart */
        .mock-svg-container {
            height: 62px;
            width: 100%;
            position: relative;
            margin-top: 4px;
        }

        /* Activity List */
        .mock-activity-list {
            display: flex;
            flex-direction: column;
            gap: 5px;
            flex: 1;
        }

        .mock-activity-item {
            display: flex;
            align-items: center;
            gap: 6px;
            padding-bottom: 4px;
            border-bottom: 1px dotted var(--border);
        }
        .mock-activity-item:last-child {
            border-bottom: none;
        }

        .mock-activity-avatar {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #e7e7e3;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 7px;
            font-weight: 700;
            color: var(--black);
        }

        .mock-activity-text {
            flex: 1;
        }

        .mock-activity-name {
            font-weight: 700;
            font-size: 8px;
        }

        .mock-activity-desc {
            color: var(--gray);
            font-size: 7.5px;
        }

        .mock-activity-time {
            font-size: 7px;
            color: var(--gray-light);
        }

        .hero-visual::before {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: rgba(255, 217, 0, 0.1);
            top: -40px;
            right: -40px;
            z-index: -1;
        }

        /* ── FEATURES SECTION ── */
        .features-section {
            padding: 80px 0;
            background: var(--light);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            text-align: center;
        }

        .section-header-center {
            max-width: 600px;
            margin: 0 auto 48px;
        }

        .section-header-center h2 {
            font-size: 32px;
            font-weight: 900;
            letter-spacing: -1.2px;
            color: var(--black);
        }

        .section-header-center h2 .accent {
            color: var(--yellow-dark);
        }

        .section-header-center p {
            margin-top: 12px;
            color: var(--gray);
            font-size: 15px;
            line-height: 1.6;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
            text-align: left;
        }

        .feature-card {
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px 20px;
            background: var(--white);
            transition: .3s ease;
            display: flex;
            flex-direction: column;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0,0,0,.05);
            border-color: var(--gray-light);
        }

        .feature-card-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255, 217, 0, 0.12);
            border: 1px solid rgba(232, 191, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--yellow-dark);
            margin-bottom: 16px;
        }

        .feature-card-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--black);
        }

        .feature-card-text {
            font-size: 12.5px;
            color: var(--gray);
            margin-top: 8px;
            line-height: 1.5;
        }

        /* ── STATS ROW ── */
        .stats-row {
            margin-top: 56px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            padding: 40px 0 0;
            border-top: 1px solid var(--border);
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 16px;
            justify-content: center;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--white);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--black);
            font-size: 18px;
        }

        .stat-content {
            text-align: left;
        }

        .stat-value {
            font-size: 22px;
            font-weight: 900;
            color: var(--black);
            line-height: 1.1;
        }

        .stat-label {
            font-size: 12px;
            color: var(--gray);
            margin-top: 2px;
            font-weight: 600;
        }

        /* ── KEUNGGULAN SECTION ── */
        .advantages {
            padding: 80px 0;
        }

        .advantages-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 56px;
            align-items: center;
        }

        .advantages-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 28px;
        }

        .advantage-item {
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }

        .advantage-bullet {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--black);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
            border: 2px solid var(--yellow);
        }

        .advantage-text h4 {
            font-size: 15px;
            font-weight: 800;
            color: var(--black);
        }

        .advantage-text p {
            font-size: 13px;
            color: var(--gray);
            margin-top: 4px;
            line-height: 1.5;
        }



        /* ── CALL TO ACTION ── */
        .cta-section {
            padding: 80px 0;
            background: var(--white);
        }

        .cta-box {
            background: var(--black);
            border-radius: 24px;
            padding: 56px;
            color: var(--white);
            text-align: center;
            position: relative;
            overflow: hidden;
            border: 3px solid var(--yellow);
        }

        .cta-box::before {
            content: "";
            position: absolute;
            width: 380px;
            height: 380px;
            border: 55px solid rgba(255,217,0,.06);
            border-radius: 50%;
            right: -100px;
            top: -100px;
        }

        .cta-content {
            position: relative;
            z-index: 2;
            max-width: 620px;
            margin: auto;
        }

        .cta-content h2 {
            font-size: 32px;
            font-weight: 900;
            letter-spacing: -1px;
            line-height: 1.2;
        }

        .cta-content p {
            color: var(--gray-light);
            font-size: 15px;
            margin-top: 14px;
            line-height: 1.6;
        }

        .cta-content .btn-primary {
            background: var(--yellow);
            color: var(--black);
            margin-top: 28px;
            border: 1px solid var(--yellow-dark);
        }

        .cta-content .btn-primary:hover {
            background: var(--white);
            color: var(--black);
            border-color: var(--border);
            box-shadow: 0 10px 22px rgba(255, 255, 255, 0.1);
        }

        /* ── FOOTER ── */
        .footer {
            border-top: 1px solid var(--border);
            background: #fafaf8;
            padding: 56px 0 24px;
        }

        .footer-inner {
            display: grid;
            grid-template-columns: 1.8fr 1fr 1fr 1.2fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-brand p {
            max-width: 280px;
            margin-top: 14px;
            color: var(--gray);
            font-size: 13px;
            line-height: 1.6;
        }

        .footer-title {
            font-size: 13px;
            font-weight: 800;
            color: var(--black);
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .footer-link {
            display: block;
            color: var(--gray);
            font-size: 13px;
            margin-bottom: 10px;
            transition: .2s;
        }

        .footer-link:hover {
            color: var(--black);
        }

        .footer-bottom {
            border-top: 1px solid var(--border);
            padding-top: 24px;
            display: flex;
            justify-content: space-between;
            color: var(--gray-light);
            font-size: 12px;
            font-weight: 600;
        }

        /* ── MOBILE NAV OVERLAY ── */
        .mobile-nav-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(17,17,17,0.4);
            backdrop-filter: blur(4px);
            z-index: 1500;
            display: none;
            justify-content: flex-end;
        }

        .mobile-nav-panel {
            width: 280px;
            background: var(--white);
            height: 100%;
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: -10px 0 30px rgba(0,0,0,0.1);
        }

        .mobile-nav-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
        }

        .mobile-nav-links {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .mobile-nav-link {
            font-size: 16px;
            font-weight: 700;
            color: var(--black);
            padding: 8px 0;
            border-bottom: 1px solid var(--border);
        }

        .mobile-nav-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 32px;
        }

        /* ── RESPONSIVE BREAKPOINTS ── */
        @media (max-width: 1080px) {
            .hero-grid {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }

            .hero h1 {
                max-width: 600px;
                margin: auto;
            }

            .hero-text {
                max-width: 500px;
                margin: 20px auto 0;
            }

            .hero-actions {
                justify-content: center;
            }

            .hero-trust {
                justify-content: center;
            }

            .features-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .stats-row {
                grid-template-columns: repeat(2, 1fr);
                gap: 24px;
            }

            .pricing-grid {
                grid-template-columns: 1fr;
                max-width: 480px;
                margin-left: auto;
                margin-right: auto;
            }

            .footer-inner {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 820px) {
            .main-nav, .header-actions {
                display: none;
            }

            .menu-toggle {
                display: block;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .advantages-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }
        }

        @media (max-width: 520px) {
            .features-grid {
                grid-template-columns: 1fr;
            }

            .stats-row {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .cta-box {
                padding: 32px 20px;
            }

            .cta-content h2 {
                font-size: 24px;
            }

            .footer-inner {
                grid-template-columns: 1fr;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 8px;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    {{-- HEADER ── --}}
    <header class="header">
        <div class="wrap header-inner">

            <a href="{{ url('/') }}" class="brand">
                <div class="brand-logo-box">K</div>
                <span class="brand-name">KDM</span>
            </a>

            <nav class="main-nav">
                <a href="#" class="nav-link active">Beranda</a>
                <a href="#fitur" class="nav-link">Fitur</a>
                <a href="#keunggulan" class="nav-link">Keunggulan</a>
                <a href="#footer" class="nav-link">Tentang Kami</a>
            </nav>

            <div class="header-actions">
                <a href="{{ route('login') }}" class="btn-cta">
                    <span data-lucide="log-in"></span>
                    Login
                </a>
            </div>

            <button class="menu-toggle" id="menuOpenBtn" aria-label="Buka Menu">
                <span data-lucide="menu" style="width: 24px; height: 24px;"></span>
            </button>

        </div>
    </header>

    {{-- MOBILE NAV OVERLAY ── --}}
    <div class="mobile-nav-overlay" id="mobileNav">
        <div class="mobile-nav-panel">
            <div>
                <div class="mobile-nav-header">
                    <a href="{{ url('/') }}" class="brand">
                        <div class="brand-logo-box">K</div>
                        <span class="brand-name">KDM</span>
                    </a>
                    <button class="menu-toggle" id="menuCloseBtn" aria-label="Tutup Menu">
                        <span data-lucide="x" style="width: 24px; height: 24px;"></span>
                    </button>
                </div>
                <div class="mobile-nav-links">
                    <a href="#" class="mobile-nav-link" onclick="toggleMobileNav()">Beranda</a>
                    <a href="#fitur" class="mobile-nav-link" onclick="toggleMobileNav()">Fitur</a>
                    <a href="#keunggulan" class="mobile-nav-link" onclick="toggleMobileNav()">Keunggulan</a>
                    <a href="#footer" class="mobile-nav-link" onclick="toggleMobileNav()">Tentang Kami</a>
                </div>
            </div>
            <div class="mobile-nav-actions">
                <a href="{{ route('login') }}" class="btn-cta" style="width: 100%; justify-content: center;">
                    <span data-lucide="log-in"></span>
                    Login
                </a>
            </div>
        </div>
    </div>

    <main>

        {{-- HERO SECTION ── --}}
        <section class="hero">
            <div class="wrap hero-grid">

                <div class="hero-copy">
                    <div class="hero-badge">
                        <span data-lucide="sparkles" style="width: 14px; height: 14px;"></span>
                        Sistem HR Modern &amp; Terintegrasi
                    </div>

                    <h1>
                        Kelola Data Karyawan
                        <span class="accent">Lebih Mudah &amp; Efisien</span>
                    </h1>

                    <p class="hero-text">
                        KDM membantu perusahaan mengelola data karyawan, absensi, cuti, dan administrasi HR dalam satu platform terintegrasi.
                    </p>

                    <div class="hero-actions">
                        <a href="{{ route('login') }}" class="btn-primary">
                            Login ke Sistem
                            <span data-lucide="arrow-right" style="width: 16px; height: 16px;"></span>
                        </a>
                        <a href="#fitur" class="btn-secondary">
                            <span data-lucide="play" style="width: 16px; height: 16px; fill: currentColor;"></span>
                            Lihat Fitur
                        </a>
                    </div>

                    <div class="hero-trust">
                        <div class="trust-item">
                            <span class="trust-icon"><span data-lucide="smile" style="width: 16px; height: 16px;"></span></span>
                            Mudah Digunakan
                        </div>
                        <div class="trust-item">
                            <span class="trust-icon"><span data-lucide="shield" style="width: 16px; height: 16px;"></span></span>
                            Aman &amp; Terpercaya
                        </div>
                        <div class="trust-item">
                            <span class="trust-icon"><span data-lucide="zap" style="width: 16px; height: 16px;"></span></span>
                            Data Real-time
                        </div>
                    </div>
                </div>

                {{-- MOCKUP DASHBOARD PANEL ── --}}
                <div class="hero-visual">
                    <div class="mock-panel">
                        
                        {{-- Top Window bar --}}
                        <div class="mock-topbar">
                            <div class="mock-topbar-left">
                                <div class="mock-window-dots">
                                    <span class="mock-dot red"></span>
                                    <span class="mock-dot yellow"></span>
                                    <span class="mock-dot green"></span>
                                </div>
                                <div class="mock-search-bar">
                                    <span data-lucide="search" style="width: 11px; height: 11px;"></span>
                                    <span>Cari apa saja...</span>
                                    <span style="margin-left: auto; font-size: 8px; opacity: 0.6;">⌘K</span>
                                </div>
                            </div>
                            <div class="mock-topbar-right">
                                <span class="mock-bell" data-lucide="bell"></span>
                                <div class="mock-avatar">
                                    <span style="display: flex; align-items: center; justify-content: center; height: 100%; font-weight: 800; font-size: 8px;">HR</span>
                                </div>
                            </div>
                        </div>

                        {{-- App Workspace --}}
                        <div class="mock-body">
                            
                            {{-- Sidebar --}}
                            <aside class="mock-sidebar">
                                <div class="mock-sidebar-menu">
                                    <div class="mock-sidebar-brand">KDM</div>
                                    
                                    <div class="mock-menu-item active">
                                        <span class="mock-menu-item-icon" data-lucide="layout-dashboard"></span>
                                        <span>Dashboard</span>
                                    </div>
                                    
                                    <div class="mock-menu-header">HRM</div>
                                    <div class="mock-menu-item">
                                        <span class="mock-menu-item-icon" data-lucide="users"></span>
                                        <span>Karyawan</span>
                                    </div>
                                    <div class="mock-menu-item">
                                        <span class="mock-menu-item-icon" data-lucide="calendar"></span>
                                        <span>Kehadiran</span>
                                    </div>
                                    <div class="mock-menu-item">
                                        <span class="mock-menu-item-icon" data-lucide="file-text"></span>
                                        <span>Cuti &amp; Izin</span>
                                    </div>
                                    
                                    <div class="mock-menu-header">Manajemen</div>
                                    <div class="mock-menu-item">
                                        <span class="mock-menu-item-icon" data-lucide="briefcase"></span>
                                        <span>Jabatan</span>
                                    </div>
                                    <div class="mock-menu-item">
                                        <span class="mock-menu-item-icon" data-lucide="map-pin"></span>
                                        <span>Lokasi</span>
                                    </div>
                                </div>
                                <div class="mock-sidebar-footer">
                                    <div class="mock-menu-item">
                                        <span class="mock-menu-item-icon" data-lucide="settings"></span>
                                        <span>Pengaturan</span>
                                    </div>
                                </div>
                            </aside>

                            {{-- Main Dashboard Area --}}
                            <div class="mock-content">
                                <div class="mock-content-header">
                                    <div class="mock-content-title">
                                        <h3>Dashboard </h3>
                                        <p>Selamat datang kembali! Berikut ringkasan data kepegawaian hari ini.</p>
                                    </div>
                                    <div class="mock-header-actions">
                                        <button class="mock-btn">
                                            <span data-lucide="calendar" style="width: 10px; height: 10px;"></span>
                                            <span>26 Mei - 1 Jun</span>
                                        </button>
                                        <button class="mock-btn primary">
                                            <span data-lucide="download" style="width: 10px; height: 10px;"></span>
                                            <span>Export Report</span>
                                        </button>
                                    </div>
                                </div>

                                {{-- Stats cards row 1 --}}
                                <div class="mock-stat-grid">
                                    <div class="mock-stat-card">
                                        <div class="mock-stat-top">
                                            <span>Tepat Waktu</span>
                                            <span class="mock-stat-icon green" data-lucide="check-circle-2"></span>
                                        </div>
                                        <div class="mock-stat-val">119</div>
                                        <div class="mock-stat-trend up">98.75% Hari Ini</div>
                                    </div>
                                    <div class="mock-stat-card">
                                        <div class="mock-stat-top">
                                            <span>Terlambat</span>
                                            <span class="mock-stat-icon yellow" data-lucide="alert-circle"></span>
                                        </div>
                                        <div class="mock-stat-val">0</div>
                                        <div class="mock-stat-trend neutral">0% Hari Ini</div>
                                    </div>
                                    <div class="mock-stat-card">
                                        <div class="mock-stat-top">
                                            <span>Mangkir</span>
                                            <span class="mock-stat-icon red" data-lucide="x-circle"></span>
                                        </div>
                                        <div class="mock-stat-val">4</div>
                                        <div class="mock-stat-trend down">3.25% Absen</div>
                                    </div>
                                    <div class="mock-stat-card">
                                        <div class="mock-stat-top">
                                            <span>Izin</span>
                                            <span class="mock-stat-icon blue" data-lucide="clock"></span>
                                        </div>
                                        <div class="mock-stat-val">3</div>
                                        <div class="mock-stat-trend up">2.44% Hari Ini</div>
                                    </div>
                                </div>

                                {{-- Stats cards row 2 --}}
                                <div class="mock-stat-grid-row2">
                                    <div class="mock-stat-card">
                                        <div class="mock-stat-top">
                                            <span>Karyawan Aktif</span>
                                            <span class="mock-stat-icon green" data-lucide="user-check"></span>
                                        </div>
                                        <div class="mock-stat-val">123</div>
                                        <div class="mock-stat-trend up">Total Aktif</div>
                                    </div>
                                    <div class="mock-stat-card">
                                        <div class="mock-stat-top">
                                            <span>Internship</span>
                                            <span class="mock-stat-icon blue" data-lucide="graduation-cap"></span>
                                        </div>
                                        <div class="mock-stat-val">5</div>
                                        <div class="mock-stat-trend up">Aktif Magang</div>
                                    </div>
                                    <div class="mock-stat-card">
                                        <div class="mock-stat-top">
                                            <span>Karyawan Baru</span>
                                            <span class="mock-stat-icon yellow" data-lucide="user-plus"></span>
                                        </div>
                                        <div class="mock-stat-val">13</div>
                                        <div class="mock-stat-trend up">Bulan Ini</div>
                                    </div>
                                </div>

                                {{-- Charts Row --}}
                                <div class="mock-charts-grid">
                                    
                                    {{-- Donut Chart --}}
                                    <div class="mock-chart-box">
                                        <div class="mock-chart-title">
                                            <span>Kehadiran</span>
                                            <span class="link">Detail</span>
                                        </div>
                                        <div class="mock-donut-container">
                                            <div class="mock-donut">
                                                <div class="mock-donut-inner">
                                                    <span>128</span>
                                                    <span style="font-size: 6px; color: var(--gray-light);">Total</span>
                                                </div>
                                            </div>
                                            <div class="mock-donut-legend">
                                                <div class="mock-legend-item">
                                                    <span class="mock-legend-color green"></span>
                                                    <span>Hadir (119)</span>
                                                </div>
                                                <div class="mock-legend-item">
                                                    <span class="mock-legend-color red"></span>
                                                    <span>Absen (4)</span>
                                                </div>
                                                <div class="mock-legend-item">
                                                    <span class="mock-legend-color yellow"></span>
                                                    <span>Izin (5)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SVG Line Chart --}}
                                    <div class="mock-chart-box">
                                        <div class="mock-chart-title">
                                            <span>Tren Kehadiran (7 Hari)</span>
                                        </div>
                                        <div class="mock-svg-container">
                                            <svg viewBox="0 0 100 50" style="width: 100%; height: 100%;">
                                                <!-- Grid lines -->
                                                <line x1="0" y1="10" x2="100" y2="10" stroke="#f0f0ed" stroke-width="0.5"/>
                                                <line x1="0" y1="25" x2="100" y2="25" stroke="#f0f0ed" stroke-width="0.5"/>
                                                <line x1="0" y1="40" x2="100" y2="40" stroke="#f0f0ed" stroke-width="0.5"/>
                                                <!-- Area fill -->
                                                <path d="M 0 50 L 0 35 Q 20 20, 40 30 T 80 15 L 100 20 L 100 50 Z" fill="rgba(255, 217, 0, 0.1)"/>
                                                <!-- Curvy line path -->
                                                <path d="M 0 35 Q 20 20, 40 30 T 80 15 L 100 20" fill="none" stroke="var(--yellow-dark)" stroke-width="1.8" stroke-linecap="round"/>
                                                <!-- Points -->
                                                <circle cx="40" cy="30" r="1.5" fill="var(--black)"/>
                                                <circle cx="80" cy="15" r="1.5" fill="var(--black)"/>
                                            </svg>
                                        </div>
                                    </div>

                                    {{-- Activity list --}}
                                    <div class="mock-chart-box">
                                        <div class="mock-chart-title">
                                            <span>Aktivitas Terbaru</span>
                                        </div>
                                        <div class="mock-activity-list">
                                            <div class="mock-activity-item">
                                                <div class="mock-activity-avatar">SN</div>
                                                <div class="mock-activity-text">
                                                    <div class="mock-activity-name">Siti Nurhaliza</div>
                                                    <div class="mock-activity-desc">Karyawan baru ditambahkan</div>
                                                </div>
                                                <span class="mock-activity-time">2j lalu</span>
                                            </div>
                                            <div class="mock-activity-item">
                                                <div class="mock-activity-avatar">BS</div>
                                                <div class="mock-activity-text">
                                                    <div class="mock-activity-name">Budi Santoso</div>
                                                    <div class="mock-activity-desc">Tidak Hadir (Tanpa Keterangan)</div>
                                                </div>
                                                <span class="mock-activity-time">3j lalu</span>
                                            </div>
                                            <div class="mock-activity-item">
                                                <div class="mock-activity-avatar">DL</div>
                                                <div class="mock-activity-text">
                                                    <div class="mock-activity-name">Dewi Lestari</div>
                                                    <div class="mock-activity-desc">Izin Sakit disetujui</div>
                                                </div>
                                                <span class="mock-activity-time">5j lalu</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        {{-- FITUR SECTION (FEATURES) ── --}}
        <section class="features-section" id="fitur">
            <div class="wrap">

                <div class="section-header-center">
                    <h2>Semua Kebutuhan HR Anda dalam <span class="accent">Satu Platform</span></h2>
                    <p>Fitur lengkap untuk membantu tim HR bekerja lebih cepat, akurat, dan terorganisir.</p>
                </div>

                <div class="features-grid">
                    
                    <div class="feature-card">
                        <div class="feature-card-icon">
                            <span data-lucide="users" style="width: 20px; height: 20px;"></span>
                        </div>
                        <div class="feature-card-title">Manajemen Karyawan</div>
                        <div class="feature-card-text">Kelola data induk, kontrak kerja, berkas pribadi, dan jabatan secara terstruktur.</div>
                    </div>

                    <div class="feature-card">
                        <div class="feature-card-icon">
                            <span data-lucide="calendar" style="width: 20px; height: 20px;"></span>
                        </div>
                        <div class="feature-card-title">Absensi &amp; Kehadiran</div>
                        <div class="feature-card-text">Pantau riwayat absensi secara real-time lengkap dengan integrasi lokasi kerja.</div>
                    </div>

                    <div class="feature-card">
                        <div class="feature-card-icon">
                            <span data-lucide="file-text" style="width: 20px; height: 20px;"></span>
                        </div>
                        <div class="feature-card-title">Cuti &amp; Izin Kerja</div>
                        <div class="feature-card-text">Kelola pengajuan cuti tahunan, sakit, dan izin kerja dalam satu alur persetujuan.</div>
                    </div>

                    <div class="feature-card">
                        <div class="feature-card-icon">
                            <span data-lucide="bar-chart-3" style="width: 20px; height: 20px;"></span>
                        </div>
                        <div class="feature-card-title">Laporan &amp; Analitik</div>
                        <div class="feature-card-text">Dapatkan visualisasi data kepegawaian secara lengkap dan download laporan instan.</div>
                    </div>

                    <div class="feature-card">
                        <div class="feature-card-icon">
                            <span data-lucide="shield-check" style="width: 20px; height: 20px;"></span>
                        </div>
                        <div class="feature-card-title">Aman &amp; Terpercaya</div>
                        <div class="feature-card-text">Data perusahaan aman dengan sistem keamanan enkripsi berstandar tinggi.</div>
                    </div>

                </div>

                <div class="stats-row">
                    <div class="stat-item">
                        <span class="stat-icon"><span data-lucide="building-2"></span></span>
                        <div class="stat-content">
                            <div class="stat-value">500+</div>
                            <div class="stat-label">Perusahaan Aktif</div>
                        </div>
                    </div>
                    <div class="stat-item">
                        <span class="stat-icon"><span data-lucide="users"></span></span>
                        <div class="stat-content">
                            <div class="stat-value">10.000+</div>
                            <div class="stat-label">Pengguna Aktif</div>
                        </div>
                    </div>
                    <div class="stat-item">
                        <span class="stat-icon"><span data-lucide="server"></span></span>
                        <div class="stat-content">
                            <div class="stat-value">99.9%</div>
                            <div class="stat-label">Uptime System</div>
                        </div>
                    </div>
                    <div class="stat-item">
                        <span class="stat-icon"><span data-lucide="headphones"></span></span>
                        <div class="stat-content">
                            <div class="stat-value">24/7</div>
                            <div class="stat-label">Customer Support</div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        {{-- KEUNGGULAN SECTION (ADVANTAGES) ── --}}
        <section class="advantages" id="keunggulan">
            <div class="wrap advantages-grid">

                <div class="mock-panel feature-detail-panel" style="width: 100%; max-width: 580px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); border: 1px solid var(--border);">
                    <div class="mock-topbar">
                        <div class="mock-topbar-left">
                            <div class="mock-window-dots">
                                <span class="mock-dot red"></span>
                                <span class="mock-dot yellow"></span>
                                <span class="mock-dot green"></span>
                            </div>
                            <span style="font-weight: 700; color: var(--black); margin-left: 8px;">Detail Kehadiran Karyawan</span>
                        </div>
                        <div class="mock-header-actions">
                            <span style="font-size: 8px; font-weight: 700; background: rgba(16, 185, 129, 0.12); color: var(--green); padding: 2px 6px; border-radius: 4px;">Live Update</span>
                        </div>
                    </div>
                    <div class="feature-detail-content" style="padding: 16px; background: var(--white); display: flex; flex-direction: column; gap: 12px; text-align: left;">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border); padding-bottom: 8px;">
                            <span style="font-weight: 800; color: var(--black); font-size: 11px;">Daftar Absensi Harian</span>
                            <span style="font-size: 9px; color: var(--gray);">Kamis, 27 Agt 2026</span>
                        </div>
                        <div class="feature-detail-table" style="display: flex; flex-direction: column; gap: 8px;">
                            <!-- Row 1 -->
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 6px 8px; background: #fbfbf9; border-radius: 6px; border: 1px solid var(--border);">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 20px; height: 20px; border-radius: 50%; background: #e7e7e3; display: flex; align-items: center; justify-content: center; font-size: 8px; font-weight: 700;">SN</div>
                                    <div style="display: flex; flex-direction: column;">
                                        <span style="font-weight: 700; font-size: 9.5px; color: var(--black);">Siti Nurhaliza</span>
                                        <span style="font-size: 8px; color: var(--gray);">Divisi HRD • WFO</span>
                                    </div>
                                </div>
                                <div style="text-align: right; display: flex; align-items: center; gap: 8px;">
                                    <div style="display: flex; flex-direction: column; font-size: 8px;">
                                        <span style="font-weight: 700; color: var(--black);">Masuk: 09.54</span>
                                        <span style="color: var(--gray-light);">GPS Verified</span>
                                    </div>
                                    <span style="font-size: 8px; font-weight: 700; background: rgba(16, 185, 129, 0.12); color: var(--green); padding: 2px 6px; border-radius: 4px;">Tepat Waktu</span>
                                </div>
                            </div>
                            <!-- Row 2 -->
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 6px 8px; background: #fbfbf9; border-radius: 6px; border: 1px solid var(--border);">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 20px; height: 20px; border-radius: 50%; background: #e7e7e3; display: flex; align-items: center; justify-content: center; font-size: 8px; font-weight: 700;">BS</div>
                                    <div style="display: flex; flex-direction: column;">
                                        <span style="font-weight: 700; font-size: 9.5px; color: var(--black);">Budi Santoso</span>
                                        <span style="font-size: 8px; color: var(--gray);">Divisi IT • WFO</span>
                                    </div>
                                </div>
                                <div style="text-align: right; display: flex; align-items: center; gap: 8px;">
                                    <div style="display: flex; flex-direction: column; font-size: 8px;">
                                        <span style="font-weight: 700; color: var(--red);">-</span>
                                        <span style="color: var(--gray-light);">-</span>
                                    </div>
                                    <span style="font-size: 8px; font-weight: 700; background: rgba(239, 68, 68, 0.12); color: var(--red); padding: 2px 6px; border-radius: 4px;">Tanpa Keterangan</span>
                                </div>
                            </div>
                            <!-- Row 3 -->
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 6px 8px; background: #fbfbf9; border-radius: 6px; border: 1px solid var(--border);">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 20px; height: 20px; border-radius: 50%; background: #e7e7e3; display: flex; align-items: center; justify-content: center; font-size: 8px; font-weight: 700;">DL</div>
                                    <div style="display: flex; flex-direction: column;">
                                        <span style="font-weight: 700; font-size: 9.5px; color: var(--black);">Dewi Lestari</span>
                                        <span style="font-size: 8px; color: var(--gray);">Divisi Design</span>
                                    </div>
                                </div>
                                <div style="text-align: right; display: flex; align-items: center; gap: 8px;">
                                    <div style="display: flex; flex-direction: column; font-size: 8px;">
                                        <span style="font-weight: 700; color: var(--black);">Izin: Sakit</span>
                                        <span style="color: var(--gray-light);">Lampiran .jpg/.jpeg/.pdf</span>
                                    </div>
                                    <span style="font-size: 8px; font-weight: 700; background: rgba(232, 191, 0, 0.12); color: var(--yellow-dark); padding: 2px 6px; border-radius: 4px;">Izin</span>
                                </div>
                            </div>
                            <!-- Row 4 -->
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 6px 8px; background: #fbfbf9; border-radius: 6px; border: 1px solid var(--border);">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 20px; height: 20px; border-radius: 50%; background: #e7e7e3; display: flex; align-items: center; justify-content: center; font-size: 8px; font-weight: 700;">RH</div>
                                    <div style="display: flex; flex-direction: column;">
                                        <span style="font-weight: 700; font-size: 9.5px; color: var(--black);">Rian Hidayat</span>
                                        <span style="font-size: 8px; color: var(--gray);">Divisi Finance • WFO</span>
                                    </div>
                                </div>
                                <div style="text-align: right; display: flex; align-items: center; gap: 8px;">
                                    <div style="display: flex; flex-direction: column; font-size: 8px;">
                                        <span style="font-weight: 700; color: var(--black);">Masuk: 10.16</span>
                                        <span style="color: var(--gray-light);">Selfie Verified</span>
                                    </div>
                                    <span style="font-size: 8px; font-weight: 700; background: rgba(232, 191, 0, 0.12); color: var(--yellow-dark); padding: 2px 6px; border-radius: 4px;">Terlambat</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="hero-badge">
                        <span data-lucide="check" style="width: 14px; height: 14px;"></span>
                        Mengapa Memilih KDM?
                    </div>
                    <h2>Tinggalkan Proses Manual, <span class="accent">Beralih ke Digital</span></h2>
                    <p style="color: var(--gray); margin-top: 12px; font-size: 14.5px;">Bantu tingkatkan efisiensi operasional bisnis Anda dengan pengelolaan SDM yang serba otomatis dan aman.</p>

                    <div class="advantages-list">
                        <div class="advantage-item">
                            <div class="advantage-bullet">1</div>
                            <div class="advantage-text">
                                <h4>UI/UX Modern dan Intuitif</h4>
                                <p>Tampilan yang bersih dan sangat mudah digunakan, bahkan oleh staf yang awam teknologi sekalipun.</p>
                            </div>
                        </div>
                        <div class="advantage-item">
                            <div class="advantage-bullet">2</div>
                            <div class="advantage-text">
                                <h4>Sistem Berbasis Cloud &amp; Real-time</h4>
                                <p>Semua data sinkron otomatis dan dapat dipantau dari perangkat mana saja secara instan.</p>
                            </div>
                        </div>
                        <div class="advantage-item">
                            <div class="advantage-bullet">3</div>
                            <div class="advantage-text">
                                <h4>Proses Onboarding &amp; Setup Cepat</h4>
                                <p>Tidak perlu instalasi rumit. Daftarkan akun perusahaan Anda dan langsung mulai kelola tim.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>



        {{-- CALL TO ACTION (CTA) --}}
        <section class="cta-section">
            <div class="wrap">
                <div class="cta-box">
                    <div class="cta-content">

                        <h2>Mulai Transformasi Kelola Karyawan Anda Sekarang juga!</h2>

                        <p>
                            Ribuan praktisi HR telah beralih ke KDM untuk kemudahan
                            operasional kepegawaian yang cepat, akurat, dan serba otomatis.
                        </p>

                        <a href="{{ route('login') }}" class="btn-primary">
                            Login ke Sistem
                        </a>

                    </div>
                </div>
            </div>
        </section>

    </main>

    {{-- FOOTER ── --}}
    <footer class="footer" id="footer">
        <div class="wrap">
            
            <div class="footer-inner">
                <div class="footer-brand">
                    <a href="{{ url('/') }}" class="brand">
                        <div class="brand-logo-box">K</div>
                        <span class="brand-name">KDM</span>
                    </a>
                    <p>Sistem Informasi Manajemen Data Karyawan, Kehadiran, Absensi, dan Cuti yang modern, cepat, serta terpercaya.</p>
                </div>

                <div>
                    <h4 class="footer-title">Platform</h4>
                    <a href="#" class="footer-link">Beranda</a>
                    <a href="#fitur" class="footer-link">Fitur Utama</a>
                    <a href="#keunggulan" class="footer-link">Keunggulan</a>
                </div>

                <div>
                    <h4 class="footer-title">Bantuan</h4>
                    <a href="#" class="footer-link">Pusat Bantuan</a>
                    <a href="#" class="footer-link">Dokumentasi API</a>
                    <a href="#" class="footer-link">Keamanan Data</a>
                    <a href="#" class="footer-link">Kontak Kami</a>
                </div>

                <div>
                    <h4 class="footer-title">Akun</h4>
                    <a href="{{ route('login') }}" class="footer-link">Masuk (Login)</a>
                </div>
            </div>

            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} KDM. Hak Cipta Dilindungi.</span>
                <span>Sistem Informasi Kepegawaian &amp; HR Modern</span>
            </div>

        </div>
    </footer>

    {{-- SCRIPTS ── --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                lucide.createIcons();
            }
        });

        // Mobile Menu Toggle
        var mobileNav = document.getElementById('mobileNav');
        var menuOpenBtn = document.getElementById('menuOpenBtn');
        var menuCloseBtn = document.getElementById('menuCloseBtn');

        if (menuOpenBtn && mobileNav) {
            menuOpenBtn.addEventListener('click', function () {
                mobileNav.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        }

        if (menuCloseBtn && mobileNav) {
            menuCloseBtn.addEventListener('click', function () {
                toggleMobileNav();
            });
        }

        function toggleMobileNav() {
            if (mobileNav) {
                mobileNav.style.display = 'none';
                document.body.style.overflow = '';
            }
        }
    </script>

</body>
</html>