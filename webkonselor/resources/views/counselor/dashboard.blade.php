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
            --bg-base:    #f8fafc;
            --bg-sidebar: #eefdf5;
            --bg-card:    #ffffff;
            --border:     #e2e8f0;
            --accent:     #059669;
            --accent-light: #d1fae5;
            --text-1:     #1e293b;
            --text-2:     #475569;
            --text-3:     #94a3b8;
            --green:      #059669;
            --green-light: #10b981;
            --red:        #dc2626;
            --red-dim:    #fef2f2;
            --red-border: #fca5a5;
            --amber:      #d97706;
            --blue:       #2563eb;
            --radius-lg:  16px;
            --radius-md:  10px;
            --radius-sm:  6px;
            --shadow-sm:  0 1px 3px rgba(0,0,0,0.05);
            --shadow-md:  0 4px 6px -1px rgba(0,0,0,0.05);
        }

        body { font-family: 'Inter', sans-serif; background: var(--bg-base); color: var(--text-1); min-height: 100vh; display: flex; }



        /* ── Main Content Area ── */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* ── Top Bar ── */
        .topbar {
            position: sticky; top: 0; z-index: 50;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px; height: 58px;
            background: rgba(248, 250, 252, 0.95); backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }
        .search-container {
            position: relative; width: 280px;
        }
        .search-container svg {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            color: var(--text-3); width: 16px; height: 16px;
        }
        .search-input {
            width: 100%; padding: 8px 14px 8px 38px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: var(--bg-card);
            font-size: 0.9rem; color: var(--text-1);
            outline: none; transition: border-color 0.2s;
        }
        .search-input:focus { border-color: var(--accent); }
        .topbar-right { display: flex; align-items: center; gap: 24px; }
        .notification { position: relative; cursor: pointer; color: var(--text-2); }
        .notification-dot {
            position: absolute; top: 0; right: 2px;
            width: 8px; height: 8px; background: var(--red);
            border-radius: 50%; border: 2px solid var(--bg-base);
        }
        .user-profile { display: flex; align-items: center; gap: 12px; cursor: pointer; }
        .user-info { display: flex; flex-direction: column; align-items: flex-end; }
        .user-name { font-size: 1rem; font-weight: 700; color: var(--text-1); }
        .user-role { font-size: 0.8rem; font-weight: 700; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.05em; }
        .user-avatar { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; background: var(--border); }

        /* ── Layout ── */
        .container { padding: 16px 20px; max-width: 1400px; margin: 0 auto; width: 100%; }

        /* ── Alert Banner ── */
        .alert-banner {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-left: 3px solid var(--red);
            border-radius: var(--radius-lg);
            padding: 14px 18px; margin-bottom: 14px;
            box-shadow: var(--shadow-sm);
        }
        .alert-header {
            display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 10px;
        }
        .alert-title-wrap { display: flex; gap: 10px; align-items: center; }
        .alert-icon { color: var(--red); flex-shrink: 0; }
        .alert-title { font-size: 0.95rem; font-weight: 700; color: var(--red); margin-bottom: 2px; }
        .alert-desc { font-size: 0.82rem; color: var(--text-2); line-height: 1.4; }
        .alert-badge {
            background: var(--red); color: white;
            padding: 5px 12px; border-radius: 999px;
            font-size: 0.78rem; font-weight: 700;
            white-space: nowrap;
        }

        /* ── Priority Cards ── */
        .priority-cards {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 10px; margin-bottom: 10px;
        }
        .p-card {
            background: var(--bg-card);
            border: 1px solid var(--red-border);
            border-radius: var(--radius-md);
            padding: 12px 14px;
            text-decoration: none; color: inherit;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .p-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .p-card-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; }
        .p-card-name { font-weight: 700; font-size: 0.95rem; color: var(--text-1); }
        .p-card-badge {
            background: var(--red-dim); color: var(--red);
            font-size: 0.7rem; font-weight: 800; padding: 3px 8px;
            border-radius: 4px; text-transform: uppercase;
        }
        .p-card-meta { display: flex; align-items: center; gap: 6px; font-size: 0.82rem; color: var(--text-3); margin-bottom: 4px; }
        .p-card-meta svg { width: 14px; height: 14px; }

        .btn-primary {
            display: inline-flex; align-items: center; justify-content: center; gap: 6px;
            padding: 8px 18px; border-radius: var(--radius-md);
            font-size: 0.85rem; font-weight: 700; font-family: inherit;
            border: none; background: var(--accent); color: white;
            cursor: pointer; transition: background 0.2s; text-decoration: none;
        }
        .btn-primary:hover { background: #047857; }
        .btn-primary:disabled { opacity: 0.6; cursor: not-allowed; }

        /* ── Charts & Stats Layout ── */
        .charts-stats-grid {
            display: grid; grid-template-columns: 2fr 1fr;
            gap: 14px; margin-bottom: 16px;
        }

        .chart-column { display: flex; flex-direction: column; gap: 14px; }
        
        .card-box {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 16px 18px;
            box-shadow: var(--shadow-sm);
        }

        .card-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 12px;
        }
        .card-title { font-size: 0.95rem; font-weight: 700; color: var(--text-1); }
        .card-subtitle { font-size: 0.8rem; color: var(--text-3); margin-top: 2px; }

        .filter-dropdown {
            padding: 5px 10px; border: 1px solid var(--border); border-radius: var(--radius-sm);
            font-size: 0.8rem; color: var(--text-2); background: var(--bg-card); cursor: pointer;
            outline: none;
        }
        .btn-icon {
            padding: 5px; border: 1px solid var(--border); border-radius: var(--radius-sm);
            background: var(--bg-card); color: var(--text-2); cursor: pointer;
            display: inline-flex; align-items: center; justify-content: center;
        }

        /* ── Stats Right Column ── */
        .stats-section-title { font-size: 0.72rem; font-weight: 700; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 8px; margin-top: 4px;}
        
        .progress-item { margin-bottom: 10px; }
        .progress-header { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 4px; }
        .progress-header span { font-size: 0.875rem; font-weight: 500; color: var(--text-1); }
        .progress-header strong { font-size: 0.875rem; font-weight: 700; color: var(--text-1); }
        .progress-bar-bg { width: 100%; height: 5px; background: #eef2f6; border-radius: 999px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 999px; transition: width 0.6s ease; }
        
        .feelings-list { display: flex; flex-direction: column; gap: 5px; }
        .feeling-item {
            display: flex; align-items: center; justify-content: space-between;
            padding: 7px 10px; background: #f8fafc; border-radius: var(--radius-sm);
        }
        .feeling-item.danger { background: var(--red-dim); }
        .feeling-info { display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 600; }
        .feeling-percent { font-size: 0.85rem; font-weight: 700; color: var(--text-1); }
        .feeling-item.danger .feeling-percent { color: var(--red); }

        /* ── Table Area ── */
        .table-area {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 16px 18px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 20px;
        }
        .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
        .btn-link { color: var(--accent); font-size: 0.85rem; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 5px; }
        .btn-link:hover { color: var(--accent); }
        
        .premium-table { width: 100%; border-collapse: collapse; text-align: left; }
        .premium-table th {
            padding: 9px 12px; font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
            color: var(--text-3); border-bottom: 1px solid var(--border);
        }
        .premium-table td { padding: 11px 12px; font-size: 0.9rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        .premium-table tr:last-child td { border-bottom: none; }
        .action-link { 
            display: inline-flex; align-items: center; justify-content: center;
            padding: 6px 14px; border-radius: var(--radius-sm);
            background: var(--accent-light); color: var(--accent);
            font-weight: 700; text-decoration: none; font-size: 0.82rem;
            transition: all 0.2s;
        }
        .action-link:hover { background: var(--accent); color: white; transform: translateY(-1px); }

        .spin {
            width: 14px; height: 14px; border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff;
            animation: spin 0.7s linear infinite; flex-shrink: 0;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Toast ── */
        #toast {
            position: fixed; bottom: 28px; right: 28px; z-index: 999;
            display: none; align-items: center; gap: 10px;
            padding: 14px 24px; border-radius: var(--radius-md);
            background: var(--text-1); color: white;
            box-shadow: var(--shadow-md); font-size: 0.95rem;
            animation: slideInUp 0.3s ease;
        }
        #toast.show { display: flex; }
        @keyframes slideInUp { from { transform:translateY(16px);opacity:0 } to { transform:none;opacity:1 } }

        /* ── Sidebar ── */
        .sidebar {
            width: 220px;
            background: linear-gradient(180deg, #eafdf5 0%, #f0fdf8 60%, #f8fafc 100%);
            border-right: 1px solid var(--border);
            padding: 20px 14px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            height: 100vh;
            position: sticky;
            top: 0;
        }
        .sidebar-header {
            margin-bottom: 20px;
            text-align: center;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(5,150,105,0.12);
        }
        .sidebar-header::before {
            content: ''; display: block; width: 28px; height: 3px;
            background: linear-gradient(90deg, #059669, #10b981);
            margin: 0 auto 10px auto; border-radius: 2px;
        }
        .sidebar-header::after { display: none; }
        .sidebar-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: #064e3b;
            margin-bottom: 3px;
            letter-spacing: -0.01em;
        }
        .sidebar-subtitle {
            font-size: 0.68rem;
            font-weight: 600;
            color: var(--text-3);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: var(--radius-md);
            text-decoration: none;
            color: #047857;
            font-weight: 600;
            font-size: 0.88rem;
            transition: all 0.18s;
        }
        .nav-item:hover {
            background: rgba(5, 150, 105, 0.08);
            color: #064e3b;
        }
        .nav-item.active {
            background: linear-gradient(135deg, rgba(5,150,105,0.15) 0%, rgba(16,185,129,0.1) 100%);
            color: #064e3b;
            font-weight: 700;
            box-shadow: inset 2px 0 0 var(--accent);
        }
        .nav-item svg {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
        }

        @media (max-width: 1024px) {
            .charts-stats-grid { grid-template-columns: 1fr; }
        }

    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-title">Portal Konselor</div>
        <div class="sidebar-subtitle">Management Suite</div>
    </div>
    
    <nav class="sidebar-nav">
        <a href="{{ route('counselor.dashboard') }}" class="nav-item {{ request()->routeIs('counselor.dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            Dashboard
        </a>
        <a href="{{ route('counselor.education.index') }}" class="nav-item {{ request()->routeIs('counselor.education.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
            Edukasi
        </a>
    </nav>
</aside>

<main class="main-wrapper">
    <!-- Topbar -->
    <header class="topbar">
        <form action="{{ route('counselor.semua-mahasiswa') }}" method="GET" class="search-container">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" name="search" id="globalSearch" class="search-input" placeholder="Cari data mahasiswa..." />
        </form>
        <div class="topbar-right">
            <div class="notification">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                <div class="notification-dot"></div>
            </div>
            <div class="user-profile">
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name ?? 'Laura Cecil' }}</span>
                    <span class="user-role">KONSELOR IT DEL</span>
                </div>
                <div class="user-avatar" style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Laura Cecil') }}&background=0D8ABC&color=fff');"></div>
            </div>
        </div>
    </header>

    <div class="container">
        
        @php
            $scanned  = isset($students) ? $students->whereNotNull('mental_level') : collect();
            $countL3  = $scanned->where('mental_level', 3)->count();
            $topL3ForCards = $scanned->where('mental_level', 3)->sortBy('mental_scanned_at')->take(3);
        @endphp

        <!-- Alert Banner -->
        <div class="alert-banner">
            <div class="alert-header">
                <div class="alert-title-wrap">
                    <div class="alert-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    </div>
                    <div>
                        <div class="alert-title">Label Merah Mahasiswa</div>
                        <div class="alert-desc">Mahasiswa yang memerlukan perhatian segera berdasarkan indikator emosional.</div>
                    </div>
                </div>
                <div class="alert-badge">{{ $countL3 }} Kasus Urgent</div>
            </div>

            @if($countL3 > 0)
            <div class="priority-cards">
                @foreach($topL3ForCards as $s)
                <a href="{{ route('counselor.detail', $s->nim) }}" class="p-card">
                    <div class="p-card-top">
                        <div class="p-card-name">{{ $s->name }}</div>
                        <div class="p-card-badge">SIAGA TINGGI</div>
                    </div>
                    <div class="p-card-meta">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                        {{ $s->nim }}
                    </div>
                    <div class="p-card-meta">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        +62 812-3456-7890 <!-- Placeholder for design matching -->
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div style="padding: 20px; text-align: center; color: var(--text-3);">
                ✅ Tidak ada kasus urgent saat ini.
            </div>
            @endif

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <button class="btn-primary" style="background: white; color: var(--text-1); border: 1px solid var(--border);" id="btnRefresh" onclick="runScan()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/></svg>
                    Pindai Ulang
                </button>
                @if($countL3 > 0)
                <a href="{{ route('counselor.prioritas') ?? '#' }}" class="btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    Buat Laporan
                </a>
                @endif
            </div>
        </div>

        <!-- Charts & Stats Layout -->
        <div class="charts-stats-grid">
            <!-- Left: Charts -->
            <div class="chart-column" id="printChartArea">
                <!-- Mood Chart -->
                <div class="card-box">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Grafik Tren Suasana Hati</div>
                            <div class="card-subtitle">Perkembangan psikologis mingguan</div>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <select class="filter-dropdown" onchange="loadChartData(this.value)">
                                <option value="14d">14 Hari terakhir</option>
                                <option value="1m">1 Bulan terakhir</option>
                                <option value="4m">4 Bulan terakhir</option>
                            </select>
                            <button class="btn-icon" onclick="printElementToPDF('printChartArea', 'Laporan_Feelings_Trend.pdf')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            </button>
                        </div>
                    </div>
                    <div style="height: 200px; position: relative;">
                        <canvas id="moodTrendChart"></canvas>
                    </div>
                </div>

                <!-- Feelings Chart -->
                <div class="card-box">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Grafik Tren Suasana Perasaan</div>
                            <div class="card-subtitle">Distribusi emosi dari waktu ke waktu</div>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <select class="filter-dropdown" onchange="loadChartData(this.value)">
                                <option value="14d">14 Hari terakhir</option>
                                <option value="1m">1 Bulan terakhir</option>
                                <option value="4m">4 Bulan terakhir</option>
                            </select>
                            <button class="btn-icon" onclick="printElementToPDF('feelingsTrendChart', 'Laporan_Feelings_Trend.pdf')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            </button>
                        </div>
                    </div>
                    <div style="height: 200px; position: relative;">
                        <canvas id="feelingsTrendChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Right: Stats -->
            <div class="card-box" id="emotionDistributionArea">
                <div class="card-header" style="margin-bottom: 20px;">
                    <div class="card-title">Rincian Statistik</div>
                </div>
                
                <div class="stats-section-title" style="margin-top: 24px;">DISTRIBUSI MOOD</div>
                
                <!-- Placeholder bars matching design. In real app, calculate these. -->
                <div class="progress-item">
                    <div class="progress-header">
                        <span>Senang</span>
                        <strong>65%</strong>
                    </div>
                    <div class="progress-bar-bg"><div class="progress-fill" style="width: 65%; background: #059669;"></div></div>
                </div>
                <div class="progress-item">
                    <div class="progress-header">
                        <span>Antusias</span>
                        <strong style="color: #059669;">20%</strong>
                    </div>
                    <div class="progress-bar-bg"><div class="progress-fill" style="width: 20%; background: #6ee7b7;"></div></div>
                </div>
                <div class="progress-item">
                    <div class="progress-header">
                        <span>Netral</span>
                        <strong>15%</strong>
                    </div>
                    <div class="progress-bar-bg"><div class="progress-fill" style="width: 15%; background: var(--red);"></div></div>
                </div>
                <div class="progress-item">
                    <div class="progress-header">
                        <span>Terkejut</span>
                        <strong>15%</strong>
                    </div>
                    <div class="progress-bar-bg"><div class="progress-fill" style="width: 15%; background: var(--red);"></div></div>
                </div>
                <div class="progress-item">
                    <div class="progress-header">
                        <span>Sedih</span>
                        <strong>15%</strong>
                    </div>
                    <div class="progress-bar-bg"><div class="progress-fill" style="width: 15%; background: var(--red);"></div></div>
                </div>
                <div class="progress-item">
                    <div class="progress-header">
                        <span>Takut</span>
                        <strong>15%</strong>
                    </div>
                    <div class="progress-bar-bg"><div class="progress-fill" style="width: 15%; background: var(--red);"></div></div>
                </div>
                <div class="progress-item">
                    <div class="progress-header">
                        <span>Marah</span>
                        <strong>15%</strong>
                    </div>
                    <div class="progress-bar-bg"><div class="progress-fill" style="width: 15%; background: var(--red);"></div></div>
                </div>

                <div class="card-header" style="margin-top: 32px; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
                    <div class="stats-section-title" style="margin: 0;">PERASAAN UMUM</div>
                    <select class="filter-dropdown" id="feelingFilter" style="width: auto;">
                        <option value="all">Semua Perasaan</option>
                        <optgroup label="Positif">
                            <option>Gembira</option>
                            <option>Bangga</option>
                            <option>Bersyukur</option>
                            <option>Ceria</option>
                            <option>Semangat</option>
                            <option>Energik</option>
                            <option>Kagum</option>
                            <option>Bergairah</option>
                        </optgroup>
                        <optgroup label="Netral / Stabil">
                            <option>Biasa Saja</option>
                            <option>Stabil</option>
                            <option>Tenang</option>
                            <option>Santai</option>
                        </optgroup>
                        <optgroup label="Penasaran / Terkejut">
                            <option>Tercengang</option>
                            <option>Penasaran</option>
                            <option>Tertarik</option>
                            <option>Gelagapan</option>
                        </optgroup>
                        <optgroup label="Sedih / Putus Asa">
                            <option>Pilu</option>
                            <option>Depresi</option>
                            <option>Kesepian</option>
                            <option>Putus Asa</option>
                        </optgroup>
                        <optgroup label="Cemas / Panik">
                            <option>Cemas</option>
                            <option>Khawatir</option>
                            <option>Panik</option>
                            <option>Gelisah</option>
                        </optgroup>
                        <optgroup label="Kesal / Marah">
                            <option>Kesal</option>
                            <option>Jengkel</option>
                            <option>Benci</option>
                            <option>Kecewa</option>
                        </optgroup>
                    </select>
                </div>
                <div class="feelings-list" id="distList" style="max-height: 500px; overflow-y: auto; padding-right: 8px;">
                    <!-- Placeholders while loading -->
                    <div class="progress-item">
                        <div class="progress-header">
                            <span>Tenang</span>
                            <strong>67%</strong>
                        </div>
                        <div class="progress-bar-bg"><div class="progress-fill" style="width: 67%; background: #059669;"></div></div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-header">
                            <span>Kagum</span>
                            <strong style="color: #059669;">33%</strong>
                        </div>
                        <div class="progress-bar-bg"><div class="progress-fill" style="width: 33%; background: #6ee7b7;"></div></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-area">
            <div class="table-header">
                <div>
                    <div class="card-title">Pratinjau Direktori Mahasiswa</div>
                    <div class="card-subtitle">Profil mahasiswa aktif terbaru dan informasi akademik.</div>
                </div>
                <a href="{{ route('counselor.semua-mahasiswa') ?? '#' }}" class="btn-link">Lihat Selengkapnya <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
            </div>
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>NAME</th>
                        <th>PROGRAM STUDI</th>
                        <th>TINGKATAN</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody id="topStudentsBody">
                    <!-- Static placeholders to match design for empty state or before load -->
                    <tr><td colspan="4" style="text-align:center; padding: 32px;"><div class="spin" style="margin:0 auto; border-top-color:var(--accent);"></div></td></tr>
                </tbody>
            </table>
        </div>

    </div>
</main>

<div id="toast"></div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function showToast(msg, isError = false) {
        const t = document.getElementById('toast');
        t.innerHTML = msg;
        t.style.background = isError ? 'var(--red)' : 'var(--text-1)';
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 3500);
    }

    function printElementToPDF(elementId, filename) {
        showToast('⏳ Menyusun dokumen PDF...');
        const element = document.getElementById(elementId);

        const opt = {
            margin:       10,
            filename:     filename,
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true, backgroundColor: '#ffffff' },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
        };

        html2pdf().set(opt).from(element).save().then(() => {
            showToast('✅ Berhasil mengunduh PDF');
        }).catch(err => {
            console.error(err);
            showToast('⚠️ Gagal menyusun PDF', true);
        });
    }

    function runScan() {
        const btn = document.getElementById('btnRefresh');
        btn.disabled = true;
        btn.innerHTML = '<div class="spin"></div> Memindai…';

        fetch('{{ route("counselor.scan") }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(res => {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.json();
        })
        .then(data => {
            showToast('✅ ' + (data.message ?? 'Scan selesai!'));
            setTimeout(() => location.reload(), 1200);
        })
        .catch(err => {
            showToast('⚠️ Scan gagal: ' + err.message, true);
            btn.disabled = false;
            btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/></svg> Pindai Ulang`;
        });
    }

    let moodChartInstance = null;
    function renderChart(labels, data) {
        const ctx = document.getElementById('moodTrendChart');
        if(!ctx) return;

        if (moodChartInstance) {
            moodChartInstance.data.labels = labels;
            moodChartInstance.data.datasets[0].data = data;
            moodChartInstance.update();
            return;
        }

        const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(5, 150, 105, 0.2)'); // Emerald light
        gradient.addColorStop(1, 'rgba(5, 150, 105, 0)');

        moodChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Rata-rata Skor Mood',
                    data: data,
                    borderColor: '#059669', // Emerald
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#059669',
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { 
                        display: true, 
                        min: 1, 
                        max: 5,
                        ticks: {
                            callback: function(value) {
                                if(value === 5) return '🤩 Senang (5)';
                                if(value === 4) return '🤫 Biasa (4)';
                                if(value === 3) return '😐 Netral (3)';
                                if(value === 2) return '😨 Takut (2)';
                                if(value === 1) return '🤬 Marah/Sedih (1)';
                                return null;
                            },
                            stepSize: 1,
                            font: { size: 11, family: 'Inter' },
                            color: 'var(--text-2)'
                        },
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        border: { display: false }
                    },
                    x: { 
                        display: true,
                        grid: { display: false },
                        border: { display: false },
                        ticks: { font: { size: 11, family: 'Inter' }, color: 'var(--text-2)' }
                    }
                },
                plugins: { legend: { display: false } }
            }
        });
    }
    
    let feelingsChartInstance = null;
    function renderFeelingsTrendChart(labels, seriesData) {
        const ctx = document.getElementById('feelingsTrendChart');
        if(!ctx) return;

        if (feelingsChartInstance) {
            feelingsChartInstance.data.labels = labels;
            feelingsChartInstance.data.datasets[0].data = seriesData;
            feelingsChartInstance.update();
            return;
        }
        
        const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
        gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

        feelingsChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Trend Dominan',
                    data: seriesData,
                    borderColor: '#10b981', // Lighter emerald
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#10b981',
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { 
                        display: true, 
                        min: 1, 
                        max: 5,
                        ticks: {
                            callback: function(value) {
                                if(value === 5) return '🔥 Semangat (5)';
                                if(value === 4) return '😌 Tenang (4)';
                                if(value === 3) return '😐 Netral (3)';
                                if(value === 2) return '🥱 Lelah (2)';
                                if(value === 1) return '🤬 Cemas/Kesal (1)';
                                return null;
                            },
                            stepSize: 1,
                            font: { size: 11, family: 'Inter' },
                            color: 'var(--text-2)'
                        },
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        border: { display: false }
                    },
                    x: { 
                        display: true,
                        grid: { display: false },
                        border: { display: false },
                        ticks: { font: { size: 11, family: 'Inter' }, color: 'var(--text-2)' }
                    }
                },
                plugins: { legend: { display: false } }
            }
        });
    }

    let globalDistribution = [];
    function updateDistList(feeling = 'all') {
        const container = document.getElementById('distList');
        if(!container) return;

        let html = '';
        let itemsToDisplay = feeling === 'all' 
            ? globalDistribution 
            : globalDistribution.filter(item => item.name.toLowerCase().includes(feeling.toLowerCase()));

        if (itemsToDisplay.length === 0) {
            container.innerHTML = `<div style="padding: 20px; text-align: center; color: var(--text-3); font-size: 0.9rem;">Tidak ada data untuk "${feeling}"</div>`;
            return;
        }

        itemsToDisplay.forEach(item => {
            let isDanger = ['pilu', 'depresi', 'kesepian', 'putus asa', 'cemas', 'khawatir', 'panik', 'gelisah', 'kesal', 'jengkel', 'benci', 'kecewa', 'takut', 'marah', 'sedih'].some(w => item.name.toLowerCase().includes(w));
            let dangerClass = isDanger ? 'danger' : '';
            let colorStyle = isDanger ? 'color: var(--red);' : '';
            
            html += `
                <div class="progress-item">
                    <div class="progress-header">
                        <span>${item.name}</span>
                        <strong style="${colorStyle}">${item.percentage}%</strong>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-fill" style="width: ${item.percentage}%; background: ${isDanger ? 'var(--red)' : '#059669'};"></div>
                    </div>
                </div>
            `;
        });
        container.innerHTML = html;
    }

    function loadChartData(range = '14d') {
        fetch('{{ route("counselor.chart-data") }}?range=' + range)
            .then(res => res.json())
            .then(data => {
                renderChart(data.labels, data.data);
                renderFeelingsTrendChart(data.labels, data.feelingsTrend);

                if(data.distribution && data.distribution.length > 0) {
                    globalDistribution = data.distribution;
                    updateDistList(document.getElementById('feelingFilter').value);
                }
            })
            .catch(err => console.error("Gagal memuat data grafik:", err));
    }

    function loadTopStudents(prodi = 'Semua') {
        const tbody = document.getElementById('topStudentsBody');
        
        fetch('{{ route("counselor.top-students") }}?prodi=' + prodi)
            .then(res => res.json())
            .then(res => {
                const students = res.data;
                if (!students || students.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="4" style="text-align:center; padding: 24px; color: var(--text-3);">Belum ada mahasiswa.</td></tr>`;
                    return;
                }

                let html = '';
                // Limit to 4 to match design size roughly
                students.slice(0, 4).forEach(s => {
                    let sem = "Semester " + (Math.floor(Math.random() * 8) + 1); // Mock semester
                    let prodiName = s.prodi || "Sistem Informasi";
                    
                    html += `
                        <tr>
                            <td>
                                <div style="font-weight: 500; color: var(--text-1);">${s.name}</div>
                                <div style="font-size: 0.75rem; color: var(--text-3); margin-top: 2px;">NIM: ${s.nim}</div>
                            </td>
                            <td style="color: var(--text-2);">${prodiName}</td>
                            <td style="color: var(--text-2);">${sem}</td>
                            <td>
                                <a href="/konselor/detail/${s.nim}" class="action-link">Profile</a>
                            </td>
                        </tr>
                    `;
                });
                tbody.innerHTML = html;
            })
            .catch(err => {
                console.error(err);
                tbody.innerHTML = '<tr><td colspan="4" style="text-align:center; color: var(--red);">Gagal memuat data.</td></tr>';
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadChartData('14d');
        loadTopStudents('Semua');

        // Search Filter
        const searchInput = document.getElementById('globalSearch');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const val = e.target.value.toLowerCase();
                
                // Filter priority cards
                const cards = document.querySelectorAll('.p-card');
                cards.forEach(card => {
                    const text = card.textContent.toLowerCase();
                    card.style.display = text.includes(val) ? '' : 'none';
                });

                // Filter table rows
                const rows = document.querySelectorAll('#topStudentsBody tr');
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(val) ? '' : 'none';
                });
            });
        }
        // Feeling Filter
        const feelingFilter = document.getElementById('feelingFilter');
        if (feelingFilter) {
            feelingFilter.addEventListener('change', function() {
                updateDistList(this.value);
            });
        }
    });

    function printElementToPDF(elementId, filename) {
        const canvas = document.getElementById(elementId);
        if (!canvas) {
            alert("Elemen tidak ditemukan!");
            return;
        }
        
        // Membuka gambar dalam tab baru untuk pencetakan yang bersih
        const dataUrl = canvas.toDataURL('image/png');
        const win = window.open('', '_blank');
        win.document.write(`
            <html>
                <head>
                    <title>${filename}</title>
                    <style>
                        body { margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f0f0f0; font-family: 'Inter', sans-serif; }
                        .container { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; }
                        img { max-width: 100%; height: auto; border: 1px solid #ddd; margin-top: 20px; }
                        h2 { color: #064e3b; margin: 0; }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <h2>Laporan Tren Suasana Perasaan</h2>
                        <p style="color: #666; font-size: 14px;">Dicetak pada: ${new Date().toLocaleString('id-ID')}</p>
                        <img src="${dataUrl}" />
                        <p style="margin-top: 20px; font-size: 12px; color: #999;">WebKonselor Management Suite</p>
                    </div>
                    <script>
                        window.onload = function() {
                            window.print();
                            // window.close(); // Optional: close after print
                        };
                    <\/script>
                </body>
            </html>
        `);
        win.document.close();
    }
</script>

</body>
</html>
