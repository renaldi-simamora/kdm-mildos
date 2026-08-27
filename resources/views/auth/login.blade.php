<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - KDM</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>

    <style>
        /* ── CSS VARS ── */
        :root {
            --yellow:      #ffd900;
            --yellow-dark: #e8bf00;
            --text-link:   #a15c00; /* Amber gelap (kontras > 4.5:1 untuk WCAG 2.1 AA) */
            --black:       #111111;
            --dark:        #171717;
            --gray:        #555555; /* Dipergelap dari #6f6f6f untuk keterbacaan */
            --gray-light:  #70706b; /* Dipergelap dari #9a9a95 untuk keterbacaan & aksesibilitas */
            --light:       #f7f7f5;
            --border:      #e7e7e3;
            --white:       #ffffff;
            --green:       #10b981;
            --red:         #ef4444;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            background: var(--white);
            color: var(--black);
            line-height: 1.5;
            overflow-x: hidden;
        }

        /* ── MAIN WRAPPER — split 55:45 ── */
        .login-page {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            min-height: 100vh;
            width: 100%;
        }

        /* ════════════════════════════
           LEFT SIDE — BRANDING & INFO (WHITE BG)
        ════════════════════════════ */
        .left-panel {
            position: relative;
            background: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            /* overflow: hidden; */ /* Dinonaktifkan agar mockup dashboard melayang tidak terpotong */
            padding: 40px 56px;
            border-right: 1px solid var(--border);
        }

        .left-top,
        .left-main,
        .left-bottom {
            position: relative;
            z-index: 2;
        }

        /* Logo — K box kuning + KDM */
        .brand-mark {
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
        }

        .brand-mark .brand-name {
            font-size: 18px;
            font-weight: 800;
            color: var(--black);
            letter-spacing: .2px;
        }

        /* Headline */
        .left-headline {
            font-size: 36px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -.8px;
            color: var(--black);
            margin-bottom: 16px;
        }

        .left-headline .accent {
            color: var(--text-link);
        }

        .left-description {
            font-size: 14.5px;
            color: var(--gray);
            max-width: 380px;
            margin-bottom: 36px;
            line-height: 1.65;
        }

        /* Feature list */
        .feature-list {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .feature-icon {
            flex-shrink: 0;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(255, 217, 0, 0.12);
            border: 1px solid rgba(232, 191, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--yellow-dark);
        }

        .feature-icon svg {
            width: 20px;
            height: 20px;
        }

        .feature-text-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--black);
            margin-bottom: 2px;
        }

        .feature-text-desc {
            font-size: 12.5px;
            color: var(--gray);
            max-width: 300px;
            line-height: 1.5;
        }

        .left-bottom {
            font-size: 12px;
            color: var(--gray-light);
        }

        /* ── DASHBOARD MOCKUP — floating on left panel ── */
        .mock-float {
            position: absolute;
            right: -30px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
            width: 340px;
            pointer-events: none;
        }

        .mock-float-panel {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow:
                0 8px 24px rgba(0,0,0,0.06),
                0 24px 56px rgba(0,0,0,0.04);
            overflow: hidden;
            font-size: 9px;
        }

        .mock-float-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            border-bottom: 1px solid var(--border);
            background: #fafaf8;
        }

        .mock-float-dots {
            display: flex;
            gap: 5px;
        }

        .mock-float-dots span {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }

        .mock-float-dots .r { background: #ef4444; }
        .mock-float-dots .y { background: #f59e0b; }
        .mock-float-dots .g { background: #10b981; }

        .mock-float-body {
            padding: 14px;
            display: flex;
            gap: 10px;
        }

        .mock-float-sidebar {
            width: 70px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .mock-sidebar-item {
            height: 20px;
            border-radius: 5px;
            background: #f1f1ee;
            display: flex;
            align-items: center;
            padding: 0 6px;
            font-size: 7px;
            font-weight: 600;
            color: var(--gray);
        }

        .mock-sidebar-item.active {
            background: var(--yellow);
            color: var(--black);
            font-weight: 700;
        }

        .mock-float-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .mock-float-header {
            font-weight: 800;
            font-size: 10px;
            color: var(--black);
            margin-bottom: 2px;
        }

        .mock-stat-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
        }

        .mock-stat-card {
            background: #f7f7f5;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 8px;
            text-align: center;
        }

        .mock-stat-card .num {
            font-size: 16px;
            font-weight: 900;
            color: var(--black);
            line-height: 1;
        }

        .mock-stat-card .lbl {
            font-size: 7px;
            color: var(--gray);
            margin-top: 2px;
        }

        .mock-stat-card.green .num { color: var(--green); }
        .mock-stat-card.red .num { color: var(--red); }
        .mock-stat-card.yellow .num { color: var(--yellow-dark); }

        .mock-chart-area {
            background: #f7f7f5;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px;
            text-align: center;
        }

        .mock-chart-title {
            font-size: 7.5px;
            font-weight: 700;
            color: var(--black);
            margin-bottom: 6px;
        }

        .mock-donut {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: conic-gradient(
                var(--green) 0deg 200deg,
                var(--red) 200deg 250deg,
                var(--yellow) 250deg 310deg,
                var(--gray-light) 310deg 360deg
            );
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .mock-donut-inner {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #f7f7f5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 11px;
            color: var(--black);
        }

        .mock-legend {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 6px;
            font-size: 6.5px;
            color: var(--gray);
        }

        .mock-legend-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 2px;
            vertical-align: middle;
        }

        /* ════════════════════════════
           RIGHT SIDE — LOGIN FORM
        ════════════════════════════ */
        .right-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light);
            padding: 40px 24px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: var(--white);
            border-radius: 20px;
            padding: 44px 40px 36px;
            border: 1px solid var(--border);
            box-shadow:
                0 1px 2px rgba(17, 17, 17, 0.03),
                0 24px 48px rgba(17, 17, 17, 0.07);
        }

        /* Card Header */
        .login-card-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-card-header h2 {
            font-size: 22px;
            font-weight: 800;
            color: var(--black);
            letter-spacing: -.4px;
        }

        .login-card-header p {
            font-size: 13.5px;
            color: var(--gray);
            margin-top: 6px;
        }

        /* Form */
        .login-form { display: flex; flex-direction: column; }

        .field {
            margin-top: 20px;
        }

        .field:first-of-type {
            margin-top: 0;
        }

        .field-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 7px;
            letter-spacing: -.1px;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-light);
            display: flex;
            pointer-events: none;
        }

        .input-icon svg {
            width: 17px;
            height: 17px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            padding: 4px;
            color: var(--gray-light);
            cursor: pointer;
            display: flex;
            align-items: center;
            border-radius: 6px;
            transition: color .15s ease;
        }

        .toggle-password:hover { color: var(--gray); }

        .toggle-password svg {
            width: 17px;
            height: 17px;
        }

        /* Input */
        .login-input {
            width: 100%;
            height: 50px;
            background: var(--white);
            border: 1px solid var(--border);
            padding: 0 16px 0 42px;
            border-radius: 12px;
            font-size: 14.5px;
            font-family: inherit;
            color: var(--black);
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .login-input.has-toggle {
            padding-right: 44px;
        }

        .login-input::placeholder { color: #b7b7b2; }

        .login-input:hover {
            border-color: #d8d8d3;
        }

        .login-input:focus {
            outline: none;
            border-color: var(--text-link);
            box-shadow: 0 0 0 3px rgba(161, 92, 0, 0.15);
        }

        .login-input:focus-visible {
            outline: none;
        }

        .login-error {
            display: block;
            margin: 6px 2px 0;
            color: #dc2626;
            font-size: 12px;
        }

        /* Remember + Forgot row */
        .login-remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 16px;
        }

        .login-remember label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 13px;
            color: var(--gray);
        }

        .login-remember input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: var(--black);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-link);
            text-decoration: none;
            transition: color .15s ease-in-out;
        }

        .forgot-link:hover {
            color: var(--black);
            text-decoration: underline;
        }

        /* Button */
        .login-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            height: 50px;
            font-weight: 700;
            font-size: 14.5px;
            font-family: inherit;
            background: var(--black);
            color: var(--white);
            margin-top: 24px;
            border-radius: 12px;
            border: 1px solid var(--black);
            transition: background-color .2s ease, color .2s ease, border-color .2s ease, transform .1s ease, box-shadow .2s ease;
            cursor: pointer;
        }

        .login-button svg {
            width: 16px;
            height: 16px;
            transition: transform .18s ease;
        }

        .login-button:hover {
            background: #222222;
            color: var(--yellow);
            border-color: var(--yellow-dark);
            box-shadow: 0 6px 14px rgba(17, 17, 17, 0.15);
        }

        .login-button:hover svg {
            transform: translateX(2px);
        }

        .login-button:active {
            transform: translateY(1px);
            box-shadow: none;
        }

        .login-button:focus-visible {
            outline: 2px solid var(--text-link);
            outline-offset: 2px;
        }

        .login-button:disabled {
            opacity: .6;
            cursor: not-allowed;
        }

        .login-button.is-loading svg {
            animation: spin .7s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Divider */
        .login-divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 24px 0;
            font-size: 12px;
            color: var(--gray-light);
        }

        .login-divider::before,
        .login-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* Card Footer */
        .login-card-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
            color: var(--gray);
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .login-card-footer a {
            color: var(--text-link);
            font-weight: 700;
            text-decoration: none;
            transition: color .15s ease-in-out;
        }

        .login-card-footer a:hover {
            color: var(--black);
            text-decoration: underline;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 1100px) {
            .mock-float {
                display: none;
            }
            .login-page {
                grid-template-columns: 1fr 1fr; /* Diubah menjadi simetris saat mockup dashboard disembunyikan */
            }
            .left-panel {
                padding: 40px 40px;
            }
        }

        @media (max-width: 900px) {
            .login-page {
                grid-template-columns: 1fr;
            }
            .left-panel {
                padding: 36px 24px;
            }
            .left-headline {
                font-size: 28px;
            }
            .feature-list {
                display: none;
            }
            .left-description {
                margin-bottom: 8px;
            }
            .mock-float {
                display: none;
            }
            .right-panel {
                padding: 28px 20px 44px;
            }
        }

        @media (max-width: 420px) {
            .login-card {
                padding: 28px 22px 26px;
                border-radius: 18px;
            }
        }
    </style>
</head>

<body>

    <div class="login-page">

        <!-- ── LEFT SIDE — BRANDING & INFO (WHITE BG) ── -->
        <div class="left-panel">

            <div class="left-top">
                <div class="brand-mark">
                    <div class="brand-logo-box">K</div>
                    <span class="brand-name">KDM</span>
                </div>
            </div>

            <div class="left-main">
                <h1 class="left-headline">Kelola Data Karyawan<br>Lebih Mudah &amp; <span class="accent">Efisien</span></h1>
                <p class="left-description">
                    KDM adalah sistem HR modern yang membantu perusahaan mengelola karyawan, absensi, cuti, dan administrasi HR dalam satu platform terintegrasi.
                </p>

                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <span data-lucide="link"></span>
                        </div>
                        <div>
                            <div class="feature-text-title">Terintegrasi</div>
                            <div class="feature-text-desc">Semua data & proses HR terhubung dalam satu sistem.</div>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <span data-lucide="shield-check"></span>
                        </div>
                        <div>
                            <div class="feature-text-title">Aman & Terpercaya</div>
                            <div class="feature-text-desc">Keamanan data terjamin dengan sistem enkripsi berstandar tinggi.</div>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <span data-lucide="bar-chart-3"></span>
                        </div>
                        <div>
                            <div class="feature-text-title">Laporan Real-time</div>
                            <div class="feature-text-desc">Pantau dan analisa data HR secara real-time dengan visual yang mudah dipahami.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="left-bottom">
                &copy; {{ date('Y') }} KDM. All rights reserved.
            </div>

            <!-- ── FLOATING DASHBOARD MOCKUP ── -->
            <div class="mock-float">
                <div class="mock-float-panel">
                    <div class="mock-float-topbar">
                        <div class="mock-float-dots">
                            <span class="r"></span>
                            <span class="y"></span>
                            <span class="g"></span>
                        </div>
                        <span style="font-weight: 700; font-size: 8px; color: var(--black);">KDM</span>
                    </div>
                    <div class="mock-float-body">
                        <div class="mock-float-sidebar">
                            <div class="mock-sidebar-item active">Dashboard</div>
                            <div class="mock-sidebar-item">HRM</div>
                            <div class="mock-sidebar-item">Departments</div>
                            <div class="mock-sidebar-item">Job Titles</div>
                            <div class="mock-sidebar-item">Locations</div>
                            <div class="mock-sidebar-item">Employees</div>
                        </div>
                        <div class="mock-float-content">
                            <div class="mock-float-header">Dashboard 📊</div>
                            <div class="mock-stat-row">
                                <div class="mock-stat-card green">
                                    <div class="num">119</div>
                                    <div class="lbl">On Time</div>
                                </div>
                                <div class="mock-stat-card red">
                                    <div class="num">5</div>
                                    <div class="lbl">Late Today</div>
                                </div>
                            </div>
                            <div class="mock-stat-row">
                                <div class="mock-stat-card yellow">
                                    <div class="num">2</div>
                                    <div class="lbl">Off Day</div>
                                </div>
                                <div class="mock-stat-card">
                                    <div class="num">123</div>
                                    <div class="lbl">Active Employees</div>
                                </div>
                            </div>
                            <div class="mock-chart-area">
                                <div class="mock-chart-title">Ringkasan Kehadiran</div>
                                <div class="mock-donut">
                                    <div class="mock-donut-inner">128</div>
                                </div>
                                <div class="mock-legend">
                                    <span><span class="mock-legend-dot" style="background: var(--green);"></span> On Time</span>
                                    <span><span class="mock-legend-dot" style="background: var(--red);"></span> Late</span>
                                    <span><span class="mock-legend-dot" style="background: var(--yellow);"></span> Absent</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ── RIGHT SIDE — LOGIN FORM ── -->
        <div class="right-panel">
            <div class="login-card">

                <div class="login-card-header">
                    <h2>Selamat Datang Kembali 👋</h2>
                    <p>Masuk untuk melanjutkan ke akun KDM Anda</p>
                </div>

                <form class="login-form" method="POST" action="{{ route('login') }}">

                    @csrf

                    <!-- Username -->
                    <div class="field">
                        <label class="field-label" for="username">Email atau Username</label>
                        <div class="input-group">
                            <span class="input-icon" data-lucide="user"></span>
                            <input
                                placeholder="Masukkan username"
                                id="username"
                                name="username"
                                type="text"
                                class="login-input"
                                value="{{ old('username') }}"
                                required
                                autofocus
                                autocomplete="username"
                            >
                        </div>
                        @error('username')
                            <span class="login-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="field">
                        <label class="field-label" for="password">Password</label>
                        <div class="input-group">
                            <span class="input-icon" data-lucide="lock"></span>
                            <input
                                placeholder="Masukkan password"
                                id="password"
                                name="password"
                                type="password"
                                class="login-input has-toggle"
                                required
                                autocomplete="current-password"
                            >
                            <button type="button" class="toggle-password" id="togglePassword" aria-label="Tampilkan password">
                                <span data-lucide="eye" id="eyeIcon"></span>
                            </button>
                        </div>
                        @error('password')
                            <span class="login-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me + Lupa Password -->
                    <div class="login-remember-row">
                        <div class="login-remember">
                            <label for="remember">
                                <input
                                    id="remember"
                                    type="checkbox"
                                    name="remember"
                                    value="1"
                                >
                                <span>Ingat saya</span>
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                        @endif
                    </div>

                    <!-- Sign In -->
                    <button type="submit" class="login-button" id="submitBtn">
                        <span id="submitLabel">Masuk</span>
                        <span data-lucide="arrow-right" id="submitIcon"></span>
                    </button>

                </form>

                <!-- Footer -->
                <div class="login-card-footer">
                    Belum punya akun? <a href="#">Hubungi administrator Anda</a>
                </div>

            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) { lucide.createIcons(); }

            // Toggle show/hide password (UI only, tidak mengubah auth logic)
            var toggleBtn = document.getElementById('togglePassword');
            var passwordInput = document.getElementById('password');
            var eyeIcon = document.getElementById('eyeIcon');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function () {
                    var isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    eyeIcon.setAttribute('data-lucide', isPassword ? 'eye-off' : 'eye');
                    toggleBtn.setAttribute('aria-label', isPassword ? 'Sembunyikan password' : 'Tampilkan password');
                    if (window.lucide) { lucide.createIcons(); }
                });
            }

            // Loading state saat submit (UI only, tidak mengubah proses login)
            var form = document.querySelector('.login-form');
            var submitBtn = document.getElementById('submitBtn');
            var submitLabel = document.getElementById('submitLabel');

            if (form && submitBtn) {
                form.addEventListener('submit', function () {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('is-loading');
                    submitLabel.textContent = 'Memproses...';
                });
            }
        });
    </script>

</body>
</html>