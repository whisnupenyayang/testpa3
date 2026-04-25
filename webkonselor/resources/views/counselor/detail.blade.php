<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $student->name }} – Detail Jurnal | WebKonselor</title>
    <meta name="description" content="Detail jurnal kesehatan mental mahasiswa {{ $student->name }}." />
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
            --accent-dim: #d1fae5;
            --text-1:     #1e293b;
            --text-2:     #475569;
            --text-3:     #94a3b8;
            --green:      #059669;
            --red:        #dc2626;
            --red-dim:    #fef2f2;
            --amber:      #d97706;
            --blue:       #2563eb;
            --radius-lg:  16px;
            --radius-md:  10px;
            --radius-sm:  6px;
            --shadow-sm:  0 1px 3px rgba(0,0,0,0.05);
            --shadow-md:  0 4px 6px -1px rgba(0,0,0,0.05);
        }

        body { font-family: 'Inter', sans-serif; background: var(--bg-base); color: var(--text-1); min-height: 100vh; display: flex; }

        /* ── Sidebar ── */
        .sidebar {
            width: 280px; background: var(--bg-sidebar); border-right: 1px solid var(--border);
            padding: 32px 24px; display: flex; flex-direction: column; flex-shrink: 0;
            height: 100vh; position: sticky; top: 0;
        }
        .sidebar-header { margin-bottom: 40px; text-align: center; }
        .sidebar-header::before { content: ''; display: block; width: 16px; height: 2px; background: #60a5fa; margin: 0 auto 12px auto; border-radius: 2px; }
        .sidebar-header::after { content: ''; display: block; width: 16px; height: 2px; background: #f472b6; margin: 24px auto 0 auto; border-radius: 2px; }
        .sidebar-title { font-size: 1.5rem; font-weight: 800; color: #064e3b; margin-bottom: 6px; }
        .sidebar-subtitle { font-size: 0.9rem; font-weight: 600; color: var(--text-2); text-transform: uppercase; letter-spacing: 0.05em; }
        .sidebar-nav { display: flex; flex-direction: column; gap: 8px; }
        .nav-item { display: flex; align-items: center; gap: 16px; padding: 16px 24px; border-radius: var(--radius-md); text-decoration: none; color: var(--accent); font-weight: 600; font-size: 1.05rem; transition: all 0.2s; }
        .nav-item:hover { background: rgba(16, 185, 129, 0.1); }
        .nav-item.active { background: var(--accent-dim); color: #064e3b; font-weight: 700; }
        .nav-item svg { width: 20px; height: 20px; flex-shrink: 0; }

        /* ── Main Content Area ── */
        .main-wrapper { flex: 1; display: flex; flex-direction: column; min-width: 0; }

        /* ── Top Bar ── */
        .topbar {
            position: sticky; top: 0; z-index: 50;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 32px; height: 72px;
            background: rgba(248, 250, 252, 0.8); backdrop-filter: blur(12px);
        }
        .search-container {
            position: relative; width: 400px;
        }
        .search-container svg {
            position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
            color: var(--text-3); width: 18px; height: 18px;
        }
        .search-input {
            width: 100%; padding: 12px 16px 12px 48px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: #f8fafc;
            font-size: 1rem; color: var(--text-1);
            outline: none; transition: all 0.2s;
        }
        .search-input:focus { border-color: var(--accent); background: #ffffff; box-shadow: 0 0 0 4px var(--accent-light); }
        
        .topbar-right { display: flex; align-items: center; gap: 24px; }
        .user-profile { display: flex; align-items: center; gap: 12px; cursor: pointer; padding: 4px 8px; border-radius: 12px; transition: background 0.2s; }
        .user-profile:hover { background: #f8fafc; }
        .user-info { display: flex; flex-direction: column; align-items: flex-end; }
        .user-name { font-size: 1rem; font-weight: 700; color: var(--text-1); }
        .user-role { font-size: 0.8rem; font-weight: 700; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.05em; }
        .user-avatar { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; background: var(--border); border: 2px solid #f8fafc; }
        
        .btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; border-radius: var(--radius-md); font-size: 0.95rem; font-weight: 600; text-decoration: none; color: var(--text-2); transition: 0.2s; }
        .btn-back:hover { color: var(--accent); }

        /* ── Layout ── */
        .container { max-width: 1200px; margin: 0 auto; padding: 32px; width: 100%; }

        .grid-layout { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 24px; }
        @media (max-width: 900px) { .grid-layout { grid-template-columns: 1fr; } }

        /* ── Profile Card ── */
        .profile-card {
            display: flex; align-items: flex-start; justify-content: space-between;
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 24px 28px;
            margin-bottom: 24px; box-shadow: var(--shadow-sm);
        }
        .profile-left h1 { font-size: 1.5rem; font-weight: 800; color: var(--text-1); margin-bottom: 6px; display: flex; align-items: center; gap: 12px; }
        .profile-left p { color: var(--text-2); font-size: 1rem; margin-bottom: 10px; }
        .profile-left .tags { display: flex; gap: 16px; font-size: 1rem; font-weight: 600; color: var(--accent); }

        .pill { font-size: 0.85rem; font-weight: 700; padding: 6px 12px; border-radius: 999px; white-space: nowrap; }
        .pill-L { background: #dbeafe; color: var(--blue); }
        .pill-P { background: var(--accent-dim); color: var(--accent); }

        /* ── Cards ── */
        .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 24px; box-shadow: var(--shadow-sm); }
        .card-title { font-size: 1.1rem; font-weight: 700; color: var(--text-1); display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }

        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 24px; }
        .stat-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 16px; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; gap: 4px; }
        .stat-card .label { font-size: 0.85rem; font-weight: 700; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.05em; }
        .stat-card .value { font-size: 1.5rem; font-weight: 700; color: var(--text-1); display: flex; align-items: center; gap: 6px; }

        /* ── Insight Card ── */
        .insight-card { background: #0f766e; color: #fff; border-radius: var(--radius-lg); padding: 24px; display: flex; flex-direction: column; height: 100%; justify-content: space-between; }
        .insight-card .header { display: flex; align-items: center; gap: 10px; font-size: 1.1rem; font-weight: 700; margin-bottom: 16px; }
        .insight-card p { font-size: 1rem; line-height: 1.6; color: #ccfbf1; margin-bottom: 24px; flex-grow: 1; }
        .score-bar { background: rgba(255,255,255,0.2); height: 6px; border-radius: 999px; width: 100%; margin-top: 8px; overflow: hidden; }
        .score-fill { background: #fff; height: 100%; border-radius: 999px; }
        
        .btn-white { background: #fff; color: #0f766e; border: none; padding: 12px 18px; border-radius: var(--radius-md); font-weight: 700; font-size: 0.95rem; cursor: pointer; text-align: center; display: flex; justify-content: center; align-items: center; gap: 6px; width: 100%; }
        .btn-white:hover { background: #f8fafc; }

        /* ── Table Area ── */
        .table-area { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 24px; box-shadow: var(--shadow-sm); }
        .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        
        .premium-table { width: 100%; border-collapse: collapse; text-align: left; }
        .premium-table th {
            padding: 14px 16px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase;
            color: var(--text-3); border-bottom: 1px solid var(--border);
        }
        .premium-table td { padding: 18px 16px; font-size: 1rem; border-bottom: 1px solid var(--border); vertical-align: top; }
        .premium-table tr:last-child td { border-bottom: none; }
        
        .btn-outline {
            padding: 10px 18px; border: 1px solid var(--border); border-radius: var(--radius-sm);
            background: #fff; color: var(--text-2); font-size: 0.95rem; font-weight: 600; cursor: pointer;
            transition: all 0.2s;
        }
        .btn-outline:hover { border-color: var(--accent); color: var(--accent); }

        .action-link { 
            display: inline-flex; align-items: center; justify-content: center;
            padding: 8px 16px; border-radius: var(--radius-sm);
            background: var(--accent-dim); color: var(--accent);
            font-weight: 700; text-decoration: none; font-size: 0.9rem;
            transition: all 0.2s;
        }
        .action-link:hover { background: var(--accent); color: white; transform: translateY(-1px); }

        .no-journals {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 80px 40px; text-align: center; color: var(--text-3);
        }
        .no-journals svg { width: 120px; height: 120px; margin-bottom: 24px; opacity: 0.05; color: var(--text-1); }
        .no-journals p { font-size: 1.1rem; font-weight: 500; }

        /* ── Badges & Alerts ── */
        .risk-alert { background: var(--red-dim); border: 1px solid #fca5a5; border-radius: var(--radius-lg); padding: 24px 28px; margin-bottom: 24px; display: flex; align-items: flex-start; gap: 16px; }
        .risk-alert .title { color: var(--red); font-weight: 800; font-size: 1.1rem; margin-bottom: 6px; display: flex; align-items: center; gap: 8px; }
        
        .emotion-tag { display: inline-flex; align-items: center; gap: 6px; font-weight: 600; color: var(--text-1); }
        .ai-none { color: var(--text-3); font-style: italic; }

        /* ── Modal ── */
        .modal-backdrop { display: none; position: fixed; inset: 0; z-index: 200; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 24px; }
        .modal-backdrop.show { display: flex; }
        .modal { background: var(--bg-card); border-radius: var(--radius-lg); box-shadow: var(--shadow-md); width: 100%; max-width: 560px; overflow: hidden; }
        .modal-header { display: flex; align-items: center; justify-content: space-between; padding: 20px 24px; border-bottom: 1px solid var(--border); background: #f8fafc; }
        .modal-header h2 { font-size: 1.3rem; font-weight: 800; color: var(--text-1); }
        .modal-close { background: none; border: none; font-size: 1.5rem; color: var(--text-3); cursor: pointer; }
        .modal-body { padding: 24px; }
        .summary-box { background: var(--bg-base); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 24px; min-height: 120px; font-size: 1.05rem; line-height: 1.6; color: var(--text-2); }
        .spin { width: 18px; height: 18px; border: 2px solid rgba(5, 150, 105, 0.2); border-top-color: var(--accent); border-radius: 50%; animation: spin 0.8s linear infinite; display: inline-block; }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-title">Portal Konselor</div>
        <div class="sidebar-subtitle">Management Suite</div>
    </div>
    
    <nav class="sidebar-nav">
        <a href="{{ route('counselor.dashboard') }}" class="nav-item {{ request()->routeIs('counselor.dashboard') || request()->routeIs('counselor.detail') ? 'active' : '' }}">
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
            <input type="text" name="search" class="search-input" placeholder="Cari data mahasiswa..." />
        </form>
        <div class="topbar-right">
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
    <a href="{{ route('counselor.dashboard') }}" class="btn-back" style="margin-bottom: 24px;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Kembali ke Daftar Mahasiswa
    </a>

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-left">
            <div>
                <h1>
                    {{ $student->name }}
                    <span class="pill {{ $student->gender === 'Laki-laki' ? 'pill-L' : 'pill-P' }}">
                        {{ $student->gender }}
                    </span>
                </h1>
                <p>NIM: {{ $student->nim }} • Teknologi Rekayasa Perangkat Lunak</p>
                <div class="tags">
                    <span>🎓 Semester 6</span>
                    <span>📅 Angkatan 2023</span>
                </div>
            </div>
        </div>
        <div style="display: flex; gap: 12px; align-items: center;">
            <div style="display: flex; flex-direction: column; align-items: flex-end;">
                <span style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; color: var(--text-3); margin-bottom: 6px;">Koreksi Status</span>
                <select id="statusSelect" style="border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 8px 12px; font-size: 0.85rem; outline: none; background: #fff; cursor: pointer; color: var(--text-1);">
                    <option value="0" {{ $student->mental_level == 0 ? 'selected' : '' }}>Level 0 (Positif)</option>
                    <option value="1" {{ $student->mental_level == 1 ? 'selected' : '' }}>Level 1 (Ringan)</option>
                    <option value="2" {{ $student->mental_level == 2 ? 'selected' : '' }}>Level 2 (Pantau)</option>
                    <option value="3" {{ $student->mental_level == 3 ? 'selected' : '' }}>Level 3 (Krisis)</option>
                </select>
            </div>
            <button onclick="updateStatus('{{ $student->nim }}', event)" style="background: var(--green); color: white; border: none; padding: 10px 16px; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.85rem; cursor: pointer; align-self: flex-end; display: flex; align-items: center; gap: 6px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                Simpan
            </button>
        </div>
    </div>

    @if($student->mental_red_flag && $student->mental_level == 3)
    <div class="risk-alert">
        <div style="font-size: 1.5rem;">🚨</div>
        <div>
            <div class="title">
                TEMUAN KRISIS (AI RISK ANALYSIS)
                <span class="pill" style="background: var(--red); color: white; font-size: 0.8rem;">URGENT</span>
            </div>
            <div style="color: var(--text-1); font-size: 0.9rem; line-height: 1.5;">
                {{ $student->mental_red_flag }}
            </div>
            <div style="margin-top: 10px; font-size: 0.85rem; color: var(--text-3); font-weight: 500;">
                *Alasan ini dideteksi otomatis berdasarkan pola Jurnal dan Tren Mood mahasiswa selama 14 hari terakhir.
            </div>
        </div>
    </div>
    @endif

    <div class="grid-layout">
        <!-- Left Column -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Tren Mood (dummy) -->
            <div class="card" style="padding: 20px;">
                <div class="card-title">
                    <span style="font-size: 1.2rem;">🙂</span> Tren Mood
                    <div style="margin-left: auto; background: var(--bg-base); padding: 6px 12px; border-radius: var(--radius-sm); font-size: 0.75rem; font-weight: 600; border: 1px solid var(--border); color: var(--text-2);">7 Hari Terakhir ⌄</div>
                </div>
                <div style="height: 180px; display: flex; align-items: center; justify-content: center; color: var(--text-3); font-size: 0.85rem; border-bottom: 2px dashed var(--accent);">[Grafik Tren Mood akan tampil di sini]</div>
            </div>

            <!-- Tren Perasaan (dummy) -->
            <div class="card" style="padding: 20px;">
                <div class="card-title">
                    <span style="font-size: 1.2rem;">📍</span> Tren Perasaan
                </div>
                <div style="height: 180px; display: flex; align-items: center; justify-content: center; color: var(--text-3); font-size: 0.85rem; border-bottom: 2px dashed var(--text-3);">[Grafik Tren Perasaan akan tampil di sini]</div>
            </div>

            <!-- Stats -->
            <div class="stats-grid" style="margin-top: 0;">
                <div class="stat-card">
                    <div class="label">Total Jurnal</div>
                    <div class="value">📄 {{ $student->journalTexts->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="label">Cek-in Harian</div>
                    <div class="value" style="color: var(--accent);">📅 {{ $student->dailyCheckins->count() }} <div style="width: 8px; height: 8px; border-radius: 50%; background: var(--accent);"></div></div>
                </div>
                <div class="stat-card">
                    <div class="label">Pembaruan Terakhir</div>
                    <div class="value" style="font-size: 1.1rem; color: var(--text-2);">
                        ⏱️ 
                        @if($student->journalTexts->first())
                            {{ $student->journalTexts->first()->created_at->isoFormat('DD MMM YYYY') }}
                        @else
                            —
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column (Insight Analisis Jurnal) -->
        <div>
            <div class="insight-card">
                <div>
                    <div class="header">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center;">✨</div>
                        Insight Analisis Jurnal
                    </div>
                    <p id="insightText">
                        Insight otomatis dari jurnal mahasiswa belum digenerate. Klik tombol Ringkas Jurnal di bawah untuk menggunakan AI merangkum kondisi psikologis mahasiswa ini berdasarkan seluruh riwayat jurnalnya.
                    </p>
                </div>
                
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.8rem; font-weight: 600; margin-bottom: 6px;">
                        <span>82%</span>
                    </div>
                    <div class="score-bar">
                        <div class="score-fill" style="width: 82%;"></div>
                    </div>

                    @if($student->journalTexts->count() > 0)
                    <button class="btn-white" style="margin-top: 24px;" id="btnSummary" onclick="openSummary('{{ $student->nim }}', '{{ $student->name }}')">
                        📄 Ringkas Jurnal
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Journal Table -->
    <div class="table-area">
        <div class="table-header">
            <span style="font-weight: 600; font-size: 1rem; color: var(--text-1);">Riwayat Log Jurnal</span>
            <div style="display: flex; gap: 8px;">
                <button class="btn-outline">Filter</button>
                <button class="btn-outline">Ekspor PDF</button>
            </div>
        </div>

        @if($student->journalTexts->count() === 0)
            <div class="no-journals">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
                <p>Mahasiswa ini belum mengisi jurnal.</p>
            </div>
        @else
            <table class="premium-table">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">#</th>
                        <th style="width: 160px;">Tanggal & Waktu</th>
                        <th style="width: 180px;">Mood Utama</th>
                        <th>Isi Jurnal & Analisis AI</th>
                        <th style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student->journalTexts as $i => $journal)
                    @php
                        // Cari checkin pada hari yang sama
                        $checkin = $student->dailyCheckins->filter(function($c) use ($journal) {
                            return $c->created_at->format('Y-m-d') === $journal->created_at->format('Y-m-d');
                        })->first();
                    @endphp
                    <tr>
                        <td style="color:var(--text-3); font-size:0.8rem; font-weight: 500; vertical-align: top; padding-top: 20px;">
                            {{ $i + 1 }}
                        </td>
                        <td style="color:var(--text-1); font-size:0.85rem; vertical-align: top; padding-top: 20px;">
                            {{ $journal->created_at->isoFormat('DD MMM YYYY, HH:mm') }}
                        </td>
                        <td style="vertical-align: top; padding-top: 20px;">
                            @if($checkin)
                                <div style="font-weight: 600; color: var(--text-1); margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                                    Mood: {{ $checkin->mood->mood_name }}
                                </div>
                                <div style="font-size: 0.75rem; color: var(--text-3);">
                                    Feeling: {{ $checkin->feeling->feeling_name }}
                                </div>
                            @else
                                <span class="ai-none">—</span>
                            @endif
                        </td>
                        <td style="vertical-align: top; padding-top: 20px; padding-right: 32px;">
                            <div style="line-height: 1.6; color: var(--text-2); font-size: 0.85rem; margin-bottom: 12px;">
                                {{ $journal->description }}
                            </div>
                            @if($checkin && $checkin->aiAnalysis)
                                <div style="background: var(--bg-base); border-left: 3px solid var(--accent); padding: 10px 14px; border-radius: 0 8px 8px 0; margin-top: 12px;">
                                    <div style="font-size: 0.7rem; font-weight: 700; color: var(--accent); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Analisis AI</div>
                                    <div style="font-size: 0.8rem; color: var(--text-2); line-height: 1.5; font-style: italic;">
                                        "{{ $checkin->aiAnalysis->text_analysis }}"
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td style="vertical-align: top; padding-top: 20px;">
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                @if($checkin && $checkin->aiAnalysis)
                                    <span style="color: var(--green); font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Sudah dianalisis</span>
                                @else
                                    <span style="color: var(--text-3); font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Belum ada analisis</span>
                                @endif
                                <a href="#" class="action-link" style="font-size: 0.8rem; margin-top: 4px;">Lihat Detail</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    </div>
</main>

<!-- AI Summary Modal -->
<div class="modal-backdrop" id="summaryModal" onclick="closeModal(event)">
    <div class="modal" role="dialog" aria-modal="true">
        <div class="modal-header">
            <h2>✨ Ringkasan Jurnal oleh AI</h2>
            <button class="modal-close" onclick="closeSummaryModal()" title="Tutup">&times;</button>
        </div>
        <div class="modal-body">
            <div class="summary-box loading" id="summaryBox">
                <div class="spin"></div> Memuat ringkasan dari AI…
            </div>
            <div class="modal-meta" id="summaryMeta" style="display:none">
                <span class="dot"></span> Dihasilkan oleh AI Summarizer
            </div>
        </div>
    </div>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function updateStatus(nim, event) {
        const level = document.getElementById('statusSelect').value;
        const btn = event.target;
        btn.disabled = true;
        btn.innerText = 'Menyimpan...';

        fetch(`/konselor/update-status/${nim}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ mental_level: level })
        })
        .then(res => res.json())
        .then(data => {
            alert('✅ ' + data.message);
            location.reload();
        })
        .catch(err => {
            alert('⚠️ Gagal memperbarui status. Pastikan format divalidasi dengan benar.');
            btn.disabled = false;
            btn.innerText = 'Simpan';
        });
    }

    function openSummary(nim, name) {
        const modal  = document.getElementById('summaryModal');
        const box    = document.getElementById('summaryBox');
        const metaEl = document.getElementById('summaryMeta');
        const btn    = document.getElementById('btnSummary');

        box.className  = 'summary-box loading';
        box.innerHTML  = '<div class="spin"></div> Memuat ringkasan dari AI…';
        metaEl.style.display = 'none';
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';

        if (btn) { btn.disabled = true; btn.innerHTML = '<div class="spin"></div> Memuat…'; }

        fetch('{{ route("counselor.summary") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ nim })
        })
        .then(res => res.json())
        .then(data => {
            const text   = data.summary ?? data.message ?? JSON.stringify(data);
            const total  = data.total_jurnal ?? '';
            const periode = data.periode ?? '';

            box.className   = 'summary-box success';
            box.textContent = text;
            metaEl.style.display = 'flex';
            if (total || periode) {
                metaEl.innerHTML = `<span class="dot"></span> Dihasilkan dari <strong>${total} jurnal</strong>${periode ? ' bulan <strong>' + periode + '</strong>' : ''}`;
            }
        })
        .catch(() => {
            box.className   = 'summary-box error';
            box.textContent = '⚠️ Gagal menghubungi AI. Pastikan server Python berjalan di port 8001.';
        })
        .finally(() => {
            if (btn) { btn.disabled = false; btn.innerHTML = '✨ Ringkas Semua Jurnal'; }
        });
    }

    function closeSummaryModal() {
        document.getElementById('summaryModal').classList.remove('show');
        document.body.style.overflow = '';
    }

    function closeModal(e) {
        if (e.target.id === 'summaryModal') closeSummaryModal();
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeSummaryModal();
    });
</script>

</body>
</html>
