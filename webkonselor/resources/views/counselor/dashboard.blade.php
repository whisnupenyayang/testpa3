<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Konselor – WebKonselor</title>
    <meta name="description" content="Dashboard konselor untuk memantau mahasiswa yang membutuhkan penanganan segera." />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-page: #edf7ef;
            --bg-panel: #ffffff;
            --bg-soft: #f6fbf6;
            --border: #dce8db;
            --text-1: #1e3a2a;
            --text-2: #4f6b53;
            --text-3: #7d8a7e;
            --green: #1d643b;
            --green-soft: #d8eed7;
            --mint: #29864c;
            --red: #b91c1c;
            --red-soft: #fef2f2;
            --yellow: #b45309;
            --yellow-soft: #fef3c7;
            --radius-xl: 28px;
            --radius-lg: 20px;
            --radius-md: 16px;
            --shadow: 0 24px 60px rgba(23, 55, 31, 0.08);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-page);
            color: var(--text-1);
            min-height: 100vh;
        }

        a { color: inherit; text-decoration: none; }
        button { font-family: inherit; cursor: pointer; }

        .app-shell {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: var(--bg-soft);
            border-right: 1px solid var(--border);
            padding: 32px 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 28px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #2f855a, #68d391);
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .brand-title {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .brand-title .title { font-size: 1rem; font-weight: 700; }
        .brand-title .subtitle { font-size: 0.86rem; color: var(--text-3); }

        .sidebar nav {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 14px;
            font-weight: 600;
            color: var(--text-2);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.95rem;
            letter-spacing: -0.3px;
        }

        .nav-link:hover {
            background: #e8f3e6;
            color: var(--mint);
            transform: translateX(2px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #c9e0c5 0%, #d8eed7 100%);
            color: var(--green);
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(29, 100, 59, 0.1);
        }

        .sidebar-footer {
            display: flex;
            flex-direction: column;
            gap: 12px;
            border-top: 1px solid var(--border);
            padding-top: 16px;
        }

        .sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-2);
            text-decoration: none;
            padding: 12px 14px;
            border-radius: 14px;
            transition: background 0.2s;
        }

        .sidebar-footer a:hover { background: #eef5ee; }

        /* Main Content */
        .main {
            flex: 1;
            padding: 32px 34px;
            overflow-y: auto;
            height: 100vh;
        }

        /* Top Bar */
        .topbar {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 24px;
            margin-bottom: 32px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e9f0eb;
        }

        .topbar-left {
            display: flex;
            flex-direction: column;
            gap: 6px;
            justify-self: center;
        }

        .topbar-left .sm-label {
            font-size: 0.8rem;
            color: var(--text-3);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .topbar-left .headline {
            font-size: 1.9rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            color: var(--text-1);
            background: linear-gradient(135deg, #1d643b, #29864c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .topbar-right:first-child {
            justify-self: start;
        }

        .topbar-right:last-child {
            justify-self: end;
        }

        .search-box {
            position: relative;
            width: 100%;
            max-width: 300px;
        }

        .search-box input {
            width: 100%;
            border: 1px solid #dce8db;
            border-radius: 16px;
            padding: 11px 16px 11px 40px;
            font-size: 0.9rem;
            color: var(--text-1);
            background: white;
            outline: none;
            transition: all 0.2s;
        }

        .search-box input:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(29, 100, 59, 0.08);
            background: #fafbfa;
        }

        .search-box input::placeholder {
            color: var(--text-3);
        }

        .search-box svg {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-3);
            width: 16px;
            height: 16px;
        }

        .profile-card {
            display: flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, #ffffff 0%, #f6fbf6 100%);
            border: 1px solid #d8eed7;
            border-radius: 16px;
            padding: 10px 14px;
            box-shadow: 0 4px 12px rgba(29, 100, 59, 0.08);
        }

        .profile-card .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #1d643b, #29864c);
            color: white;
            font-weight: 700;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .profile-card .profile-info {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .profile-card .name { font-weight: 700; font-size: 0.9rem; color: var(--text-1); }
        .profile-card .role { color: var(--text-3); font-size: 0.8rem; font-weight: 500; }

        /* Panels & Cards */
        .panel {
            background: var(--bg-panel);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            padding: 26px;
            margin-bottom: 24px;
            transition: all 0.3s ease;
        }

        .panel:hover {
            box-shadow: 0 28px 70px rgba(23, 55, 31, 0.12);
        }

        .panel-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-1);
            margin-bottom: 20px;
        }

        /* Alert Card */
        .alert-card {
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 18px;
            background: linear-gradient(135deg, #fef2f2 0%, #fde9e9 100%);
            border: 2px solid #f5c2c7;
            border-radius: 20px;
            padding: 24px;
            align-items: center;
            margin-bottom: 24px;
            box-shadow: 0 8px 24px rgba(185, 28, 28, 0.08);
            animation: slideDown 0.5s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-card .symbol {
            width: 48px;
            height: 44px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: #fee2e2;
            color: var(--red);
            font-size: 1.3rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .alert-card .alert-title {
            font-weight: 700;
            color: var(--text-1);
            margin-bottom: 6px;
            font-size: 0.95rem;
        }

        .alert-card .alert-text {
            color: var(--text-2);
            line-height: 1.6;
            font-size: 0.9rem;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 18px;
            border-radius: 999px;
            background: linear-gradient(135deg, #f8d7da 0%, #f5c2c7 100%);
            color: var(--red);
            font-weight: 800;
            white-space: nowrap;
            font-size: 0.85rem;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(185, 28, 28, 0.15);
            border: 1px solid #f0a8ad;
            letter-spacing: 0.5px;
        }

        /* Student Cards Grid */
        .student-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .student-card {
            background: white;
            border: 1px solid #e6efea;
            border-radius: 20px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            min-height: 200px;
            transition: box-shadow 0.2s, transform 0.2s;
            position: relative;
            overflow: hidden;
        }

        .student-card:hover {
            box-shadow: 0 12px 32px rgba(23, 55, 31, 0.16);
            transform: translateY(-4px);
        }

        .student-card .student-name {
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--text-1);
            margin-top: 24px;
        }

        .student-card .student-meta {
            display: flex;
            flex-direction: column;
            gap: 6px;
            color: var(--text-3);
            font-size: 0.85rem;
        }

        .student-card .student-meta span { display: block; }

        .status-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 12px;
            padding: 8px 12px;
            font-weight: 700;
            font-size: 0.75rem;
            width: fit-content;
            position: absolute;
            top: 12px;
            left: 16px;
            letter-spacing: 0.5px;
        }

        .status-chip.urgent {
            background: #fee2e2;
            color: var(--red);
            border: 1px solid #f5c2c7;
        }

        .status-chip.warning {
            background: #fff7ed;
            color: var(--yellow);
            border: 1px solid #fde3a7;
        }

        .status-chip.safe {
            background: #d8eed7;
            color: var(--green);
            border: 1px solid #a8e6a1;
        }

        /* Layout Grid */
        .row-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.8fr) minmax(320px, 1fr);
            gap: 24px;
            margin-bottom: 24px;
        }

        /* Stats Panel */
        .stats-panel {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .section-title {
            font-size: 0.88rem;
            color: var(--text-2);
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .stat-block {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .progress-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 12px;
            align-items: center;
        }

        .progress-label {
            font-size: 0.9rem;
            color: var(--text-1);
            font-weight: 600;
        }

        .progress-bar {
            height: 10px;
            border-radius: 999px;
            background: #f1f4f1;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 999px;
            transition: width 0.3s ease;
        }

        .progress-value {
            font-size: 0.9rem;
            color: var(--text-3);
            font-weight: 600;
        }

        /* Feeling Cards */
        .feeling-list {
            display: grid;
            gap: 12px;
        }

        .feeling-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 16px 18px;
            border-radius: 18px;
            background: #f6fbf6;
            border: 1px solid #e6efea;
            transition: background 0.2s;
        }

        .feeling-card:hover {
            background: #f0f7f0;
        }

        .feeling-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .feeling-icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: white;
            border: 1px solid #dce8db;
            color: var(--green);
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .feeling-name { font-weight: 700; color: var(--text-1); font-size: 0.95rem; }
        .feeling-value { font-size: 0.96rem; font-weight: 700; color: var(--text-1); }
        .feeling-label { color: var(--text-3); font-size: 0.84rem; }

        /* Chart Card */
        .chart-card {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .chart-wrapper {
            min-height: 320px;
            position: relative;
        }

        .chart-action {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Table */
        .table-card {
            margin-top: 0;
        }

        .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .table-header .section-title {
            margin: 0;
            font-size: 0.85rem;
            text-transform: none;
            letter-spacing: 0;
        }

        .text-link {
            color: var(--green);
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s;
        }

        .text-link:hover {
            color: var(--mint);
        }

        .preview-table {
            width: 100%;
            border-collapse: collapse;
        }

        .preview-table th,
        .preview-table td {
            padding: 16px 18px;
            text-align: left;
            border-bottom: 1px solid #ecf2ec;
        }

        .preview-table th {
            color: var(--text-3);
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
            background: #fafbfa;
        }

        .preview-table tbody tr:hover {
            background: #f4f9f3;
        }

        .student-name-row {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .student-name-row .name {
            font-weight: 700;
            color: var(--text-1);
        }

        .student-name-row .meta {
            color: var(--text-3);
            font-size: 0.85rem;
        }

        .student-status-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 999px;
            background: #eef5ee;
            color: var(--green);
            font-weight: 700;
            font-size: 0.8rem;
            border: 1px solid #d8eed7;
        }

        .student-status-badge.urgent {
            background: #fee2e2;
            color: var(--red);
            border-color: #f5c2c7;
        }

        .student-status-badge.warning {
            background: #fff7ed;
            color: var(--yellow);
            border-color: #fde3a7;
        }

        /* Buttons */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 13px 22px;
            border-radius: 16px;
            border: none;
            background: var(--green);
            color: white;
            font-weight: 700;
            font-size: 0.95rem;
            box-shadow: 0 18px 34px rgba(45, 105, 66, 0.16);
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s, box-shadow 0.2s;
        }

        .btn-primary:hover {
            background: #155936;
            box-shadow: 0 22px 40px rgba(45, 105, 66, 0.2);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 16px;
            border: 1px solid #dce8db;
            background: white;
            color: var(--text-2);
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .btn-secondary:hover {
            background: #f4fbf5;
            border-color: #c9dfc6;
        }

        .card-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        /* Empty State */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 40px 24px;
            text-align: center;
            background: #fafbfa;
            border-radius: 16px;
        }

        .empty-state .icon {
            font-size: 2rem;
        }

        .empty-state .text {
            color: var(--text-2);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Toast */
        #toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--green);
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
            display: none;
            gap: 12px;
            align-items: center;
            z-index: 9999;
            animation: slideIn 0.3s ease;
        }

        #toast.show {
            display: flex;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(400px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive */
        @media (max-width: 1120px) {
            .row-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 860px) {
            .app-shell { flex-direction: column; }
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: space-between;
                padding: 20px;
                gap: 16px;
            }
            .main {
                padding: 24px;
                height: auto;
            }
            .topbar-right { width: 100%; justify-content: space-between; flex-direction: column; }
            .sidebar-footer { flex-direction: row; flex-wrap: wrap; gap: 10px; border-top: none; padding-top: 0; }
            .sidebar nav { width: 100%; }
            .student-list {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }

        @media (max-width: 640px) {
            .topbar { flex-direction: column; gap: 12px; }
            .topbar-left { gap: 4px; }
            .topbar-left .headline { font-size: 1.4rem; }
            .search-box input { padding-left: 40px; }
            .panel { padding: 18px; }
            .student-card { padding: 16px; }
            .preview-table { font-size: 0.85rem; }
            .preview-table th, .preview-table td { padding: 12px; }
            .alert-card { grid-template-columns: auto 1fr; }
            .pill { font-size: 0.75rem; }
            .row-grid { gap: 16px; }
        }
    </style>
</head>
<body>

<div class="app-shell">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div>
            <div class="brand">
                <div class="brand-icon">K</div>
                <div class="brand-title">
                    <span class="title">Portal Konselor</span>
                    <span class="subtitle">Management Suite</span>
                </div>
            </div>

            <nav>
                <a href="{{ route('counselor.dashboard') }}" class="nav-link active">
                    <span>🏠</span>
                    Dashboard
                </a>
                <a href="{{ route('counselor.education.index') }}" class="nav-link">
                    <span>👥</span>
                    Direktori Mahasiswa
                </a>
                <a href="{{ route('counselor.semua-mahasiswa') }}" class="nav-link">
                    <span>📊</span>
                    Data Lengkap
                </a>
                <a href="{{ route('counselor.prioritas') }}" class="nav-link">
                    <span>🚨</span>
                    Prioritas Handling
                </a>
                <a href="#" class="nav-link">
                    <span>📄</span>
                    Laporan
                </a>
            </nav>
        </div>

        <div class="sidebar-footer">
            <a href="#">
                <span>⚙️</span>
                Settings
            </a>
            <a href="#">
                <span>🚪</span>
                Logout
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main">
        <!-- Top Bar -->
        <div class="topbar">
            <div class="topbar-right">
                <div class="profile-card">
                    <div class="avatar">LC</div>
                    <div class="profile-info">
                        <span class="name">Laura Cecil</span>
                        <span class="role">Konselor IDL</span>
                    </div>
                    <button class="btn-secondary" type="button" aria-label="Notifikasi" style="border: none; padding: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                        🔔
                    </button>
                </div>
            </div>

            <div class="topbar-left">
                <span class="sm-label">Dashboard</span>
                <h1 class="headline">Selamat datang, Konselor</h1>
            </div>

            <div class="topbar-right" style="order: 0;">
                <div class="search-box">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7"/>
                        <path d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="search" placeholder="Cari data mahasiswa..." />
                </div>
            </div>
        </div>

        <!-- Urgent Alert Section -->
        <div class="panel">
            @php
                $scanned = $students->whereNotNull('mental_level');
                $urgentCount = $scanned->where('mental_level', 3)->count();
                $topUrgents = $scanned->where('mental_level', 3)->sortByDesc('mental_confidence')->take(3);
                $previewStudents = $students->sortBy('name')->take(5);
                $totalScanned = max($scanned->count(), 1);
                $positive = round($scanned->where('mental_level', 0)->count() / $totalScanned * 100);
                $neutral = round($scanned->where('mental_level', 1)->count() / $totalScanned * 100);
                $negative = round($scanned->where('mental_level', 2)->count() / $totalScanned * 100);
                $mentalLabels = [0 => 'Aman', 1 => 'Waspada', 2 => 'Perlu Pantauan', 3 => 'Urgent'];
            @endphp

            <div class="alert-card">
                <div class="symbol">⚠️</div>
                <div>
                    <div class="alert-title">Mahasiswa dengan Status Urgent</div>
                    <div class="alert-text">Mahasiswa yang memerlukan perhatian segera berdasarkan indikator emosional dan mental.</div>
                </div>
                <div class="pill">{{ $urgentCount }} Kasus Urgent</div>
            </div>

            <!-- Urgent Students Cards -->
            <div class="student-list">
                @forelse($topUrgents as $student)
                    <div class="student-card">
                        <div class="status-chip urgent">
                            🔴 SIAGA TINGGI
                        </div>
                        <div class="student-name">{{ $student->name }}</div>
                        <div class="student-meta">
                            <span><strong>NIM:</strong> {{ $student->nim }}</span>
                            <span><strong>Prodi:</strong> {{ $student->prodi ?? 'Belum tersedia' }}</span>
                        </div>
                        <div class="student-meta" style="margin-top: auto; font-size: 0.85rem;">
                            <span>📱 {{ $student->phone ?? '+62 000-0000-0000' }}</span>
                        </div>
                    </div>
                @empty
                    <div class="empty-state" style="grid-column: 1 / -1; padding: 30px; background: #f6fbf6;">
                        <div class="icon">✅</div>
                        <div class="text">
                            <strong>Tidak ada mahasiswa urgent saat ini</strong>
                            <p style="margin-top: 4px; font-size: 0.9rem;">Data mahasiswa akan muncul ketika terdeteksi level krisis.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="card-footer">
                <a href="{{ route('counselor.prioritas') }}" class="btn-primary">📋 Buat Laporan</a>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row-grid">
            <!-- Mood Trend Chart -->
            <section class="panel chart-card">
                <div class="table-header">
                    <div>
                        <div class="section-title">📈 Grafik Tren Suasana Hati</div>
                        <div style="margin-top: 6px; color: var(--text-2); font-size: 0.9rem;">Perkembangan psikologis mahasiswa minggu terakhir</div>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <canvas id="moodTrendChart"></canvas>
                </div>
                <div class="chart-action">
                    <button class="btn-secondary" type="button">📥 Unduh Grafik</button>
                </div>
            </section>

            <!-- Statistics Panel -->
            <aside class="panel stats-panel">
                <div>
                    <div class="section-title">📊 Rincian Statistik</div>
                    <div style="margin-top: 12px; font-size: 0.95rem; font-weight: 700; color: var(--text-1);">Distribusi Kondisi Mental</div>
                </div>

                <!-- Progress Stats -->
                <div class="stat-block">
                    <div class="progress-row">
                        <span class="progress-label">✅ Aman</span>
                        <span class="progress-value">{{ $positive }}%</span>
                    </div>
                    <div class="progress-bar">
                        <span class="progress-fill" style="width: {{ $positive }}%; background: var(--green);"></span>
                    </div>
                </div>

                <div class="stat-block">
                    <div class="progress-row">
                        <span class="progress-label">⚠️ Waspada</span>
                        <span class="progress-value">{{ $neutral }}%</span>
                    </div>
                    <div class="progress-bar">
                        <span class="progress-fill" style="width: {{ $neutral }}%; background: var(--yellow);"></span>
                    </div>
                </div>

                <div class="stat-block">
                    <div class="progress-row">
                        <span class="progress-label">🔴 Perlu Pantauan</span>
                        <span class="progress-value">{{ $negative }}%</span>
                    </div>
                    <div class="progress-bar">
                        <span class="progress-fill" style="width: {{ $negative }}%; background: var(--red);"></span>
                    </div>
                </div>

                <!-- Feelings Distribution -->
                <div style="margin-top: 20px; font-size: 0.95rem; font-weight: 700; color: var(--text-1);">😊 Perasaan Umum</div>
                <div class="feeling-list">
                    <div class="feeling-card">
                        <div class="feeling-info">
                            <div class="feeling-icon">😊</div>
                            <div>
                                <div class="feeling-name">Senang</div>
                                <div class="feeling-label">Positif</div>
                            </div>
                        </div>
                        <div class="feeling-value">42%</div>
                    </div>
                    <div class="feeling-card">
                        <div class="feeling-info">
                            <div class="feeling-icon">😌</div>
                            <div>
                                <div class="feeling-name">Tenang</div>
                                <div class="feeling-label">Stabil</div>
                            </div>
                        </div>
                        <div class="feeling-value">28%</div>
                    </div>
                    <div class="feeling-card">
                        <div class="feeling-info">
                            <div class="feeling-icon">⚠️</div>
                            <div>
                                <div class="feeling-name">Cemas</div>
                                <div class="feeling-label">Waspada</div>
                            </div>
                        </div>
                        <div class="feeling-value">18%</div>
                    </div>
                    <div class="feeling-card">
                        <div class="feeling-info">
                            <div class="feeling-icon">😢</div>
                            <div>
                                <div class="feeling-name">Sedih</div>
                                <div class="feeling-label">Kritis</div>
                            </div>
                        </div>
                        <div class="feeling-value">12%</div>
                    </div>
                </div>
            </aside>
        </div>

        <!-- Feelings Trend Chart -->
        <div class="panel chart-card">
            <div class="table-header">
                <div>
                    <div class="section-title">💭 Grafik Tren Perasaan</div>
                    <div style="margin-top: 6px; color: var(--text-2); font-size: 0.9rem;">Distribusi emosi dari waktu ke waktu</div>
                </div>
            </div>
            <div class="chart-wrapper">
                <canvas id="feelingsTrendChart"></canvas>
            </div>
            <div class="chart-action">
                <button class="btn-secondary" type="button">📥 Unduh Grafik</button>
            </div>
        </div>

        <!-- Students Preview Table -->
        <div class="panel table-card">
            <div class="table-header">
                <div>
                    <div class="section-title">👥 Pratinjau Direktori Mahasiswa</div>
                    <div style="margin-top: 6px; color: var(--text-2); font-size: 0.9rem;">Data mahasiswa aktif dan informasi mental status</div>
                </div>
                <a href="{{ route('counselor.semua-mahasiswa') }}" class="text-link">Lihat Selengkapnya →</a>
            </div>

            <div style="overflow-x: auto;">
                <table class="preview-table">
                    <thead>
                        <tr>
                            <th>Nama Mahasiswa</th>
                            <th>Program Studi</th>
                            <th>Tingkat</th>
                            <th>Status Mental</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($previewStudents as $student)
                            @php
                                $levelLabel = $mentalLabels[$student->mental_level] ?? 'Belum Dianalisis';
                                $badgeClass = $student->mental_level === 3 ? 'urgent' : ($student->mental_level === 2 ? 'warning' : '');
                            @endphp
                            <tr>
                                <td>
                                    <div class="student-name-row">
                                        <span class="name">{{ $student->name }}</span>
                                        <span class="meta">{{ $student->nim }}</span>
                                    </div>
                                </td>
                                <td>{{ $student->prodi ?? '—' }}</td>
                                <td>{{ $student->semester ? 'Sem. '.$student->semester : '—' }}</td>
                                <td>
                                    <span class="student-status-badge {{ $badgeClass }}">
                                        {{ $levelLabel }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('counselor.detail', $student->nim) }}" class="text-link" style="font-size: 0.9rem;">
                                        Lihat Detail →
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px 20px; color: var(--text-3);">
                                    Tidak ada data mahasiswa untuk ditampilkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Toast Notification -->
<div id="toast"></div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Toast Function
    function showToast(msg) {
        const toast = document.getElementById('toast');
        toast.textContent = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    // Initialize Mood Trend Chart
    const moodCtx = document.getElementById('moodTrendChart');
    if (moodCtx) {
        new Chart(moodCtx, {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5'],
                datasets: [{
                    label: 'Skor Mood',
                    data: [52, 63, 57, 70, 65],
                    borderColor: '#1d643b',
                    backgroundColor: 'rgba(45, 115, 63, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#1d643b',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#4f6b53', font: { size: 12, weight: 600 } }
                    },
                    y: {
                        grid: { color: '#e9f0eb' },
                        beginAtZero: true,
                        max: 100,
                        ticks: { color: '#4f6b53', font: { size: 12, weight: 600 } }
                    }
                }
            }
        });
    }

    // Initialize Feelings Trend Chart
    const feelingsCtx = document.getElementById('feelingsTrendChart');
    if (feelingsCtx) {
        new Chart(feelingsCtx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Tren Perasaan',
                    data: [35, 42, 38, 46, 44, 47, 50],
                    borderColor: '#29864c',
                    backgroundColor: 'rgba(41, 134, 76, 0.1)',
                    fill: true,
                    tension: 0.45,
                    pointRadius: 5,
                    pointBackgroundColor: '#29864c',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#4f6b53', font: { size: 12, weight: 600 } }
                    },
                    y: {
                        grid: { color: '#e9f0eb' },
                        beginAtZero: true,
                        max: 100,
                        ticks: { color: '#4f6b53', font: { size: 12, weight: 600 } }
                    }
                }
            }
        });
    }

    // Search functionality
    document.querySelector('.search-box input')?.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            showToast('🔍 Fitur pencarian akan tersedia di versi berikutnya');
        }
    });

    // Chart download buttons
    document.querySelectorAll('.chart-action .btn-secondary').forEach((btn, idx) => {
        btn.addEventListener('click', function() {
            showToast('📥 Fitur unduh grafik akan tersedia segera');
        });
    });
</script>

</body>
</html>
