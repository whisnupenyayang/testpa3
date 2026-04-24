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
            --bg-base:    #0d0f1a;
            --bg-card:    #131627;
            --bg-glass:   rgba(255,255,255,0.04);
            --border:     rgba(255,255,255,0.08);
            --accent:     #7c6ff7;
            --accent-dim: rgba(124,111,247,0.15);
            --green:      #34d399;
            --amber:      #fbbf24;
            --red:        #f87171;
            --red-dim:    rgba(248,113,113,0.12);
            --blue:       #60a5fa;
            --pink:       #f472b6;
            --text-1:     #f1f5f9;
            --text-2:     #94a3b8;
            --text-3:     #64748b;
            --radius-lg:  16px;
            --radius-md:  10px;
            --radius-sm:  6px;
            --shadow-glow: 0 0 40px rgba(124,111,247,0.12);
            --shadow-red:  0 0 40px rgba(248,113,113,0.15);
        }

        body { font-family: 'Inter', sans-serif; background: var(--bg-base); color: var(--text-1); min-height: 100vh; }

        /* ── Top Bar ── */
        .topbar {
            position: sticky; top: 0; z-index: 50;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 32px; height: 64px;
            background: rgba(13,15,26,0.88); backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
        }
        .topbar-logo { display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 1.1rem; letter-spacing: -0.02em; }
        .topbar-logo .dot {
            width: 32px; height: 32px; border-radius: 8px;
            background: linear-gradient(135deg, var(--accent), #a78bfa);
            display: flex; align-items: center; justify-content: center; font-size: 0.85rem;
        }

        /* ── Layout ── */
        .container { max-width: 1280px; margin: 0 auto; padding: 40px 32px; }

        /* ── Page Header ── */
        .page-header { margin-bottom: 28px; }
        .page-header h1 {
            font-size: 1.8rem; font-weight: 700; letter-spacing: -0.03em;
            background: linear-gradient(135deg, var(--text-1) 0%, #f87171 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .page-header p { color: var(--text-2); font-size: 0.92rem; margin-top: 6px; }

        /* ── Top Action Bar ── */
        .action-bar {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 12px; margin-bottom: 28px;
        }
        .last-scan-info { font-size: 0.8rem; color: var(--text-3); display: flex; align-items: center; gap: 6px; }
        .scan-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--green); display: inline-block; }
        .scan-dot.stale { background: var(--amber); }
        .scan-dot.never { background: var(--text-3); }

        .btn-refresh {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 8px 18px; border-radius: var(--radius-md);
            font-size: 0.82rem; font-weight: 600; font-family: inherit;
            border: 1px solid rgba(248,113,113,0.35);
            background: var(--red-dim); color: var(--red);
            cursor: pointer; transition: background 0.2s, border-color 0.2s, opacity 0.2s;
        }
        .btn-refresh:hover { background: rgba(248,113,113,0.2); border-color: var(--red); }
        .btn-refresh:disabled { opacity: 0.45; cursor: not-allowed; }
        .spin {
            width: 13px; height: 13px; border-radius: 50%;
            border: 2px solid rgba(248,113,113,0.3); border-top-color: var(--red);
            animation: spin 0.7s linear infinite; flex-shrink: 0;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Stats ── */
        .stats-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 14px; margin-bottom: 32px;
        }
        .stat-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 18px 20px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-card .label { font-size: 0.7rem; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.05em; }
        .stat-card .value { font-size: 2rem; font-weight: 700; margin-top: 6px; }
        .stat-card.danger { border-color: rgba(248,113,113,0.2); }
        .stat-card.danger:hover { box-shadow: var(--shadow-red); }

        /* ── Section Title ── */
        .section-title {
            font-size: 0.75rem; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.06em; color: var(--text-3); margin-bottom: 12px;
            display: flex; align-items: center; gap: 8px;
        }
        .section-title::after { content: ''; flex: 1; height: 1px; background: var(--border); margin-right: 8px; }

        /* ── Collapse Accordion ── */
        .collapse-btn { cursor: pointer; user-select: none; transition: color 0.2s; }
        .collapse-btn:hover { color: var(--text-1); }
        .collapse-btn .chevron { transition: transform 0.3s ease; order: 2; flex-shrink: 0; }
        .collapse-btn.open .chevron { transform: rotate(180deg); }
        .student-grid.collapse-content { display: none !important; }
        .student-grid.collapse-content.show { display: flex !important; }

        /* ── Student rows ── */
        .student-grid { display: flex; flex-direction: column; gap: 12px; margin-bottom: 32px; }

        .student-row {
            display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
            background: var(--bg-card);
            border: 1px solid rgba(248,113,113,0.2);
            border-radius: var(--radius-lg); padding: 16px 20px;
            text-decoration: none; color: inherit;
            transition: border-color 0.2s, box-shadow 0.2s, transform 0.15s;
        }
        .student-row:hover { border-color: rgba(248,113,113,0.5); box-shadow: var(--shadow-red); transform: translateY(-1px); }
        .student-row.l2 { border-color: rgba(251,191,36,0.2); }
        .student-row.l2:hover { border-color: rgba(251,191,36,0.5); box-shadow: 0 0 30px rgba(251,191,36,0.12); }
        .student-row.l1 { border-color: rgba(96,165,250,0.2); }
        .student-row.l1:hover { border-color: rgba(96,165,250,0.5); box-shadow: 0 0 30px rgba(96,165,250,0.12); }
        .student-row.l0 { border-color: rgba(52,211,153,0.15); }
        .student-row.l0:hover { border-color: rgba(52,211,153,0.4); box-shadow: 0 0 30px rgba(52,211,153,0.1); }

        .avatar {
            width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 1rem;
            background: linear-gradient(135deg, #f87171, #ef4444); color: #fff;
        }
        .avatar.l2 { background: linear-gradient(135deg, var(--amber), #d97706); }
        .avatar.l1 { background: linear-gradient(135deg, var(--blue), #2563eb); }
        .avatar.l0 { background: linear-gradient(135deg, var(--green), #059669); }

        .row-info { flex: 1; min-width: 0; }
        .row-info .name { font-weight: 600; font-size: 0.95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .row-info .meta { color: var(--text-3); font-size: 0.77rem; margin-top: 3px; display: flex; gap: 12px; flex-wrap: wrap; }

        .red-flag-row {
            margin-top: 8px; padding: 6px 10px;
            background: rgba(248,113,113,0.08); border: 1px solid rgba(248,113,113,0.18);
            border-radius: var(--radius-sm); font-size: 0.77rem; color: var(--red);
            display: flex; align-items: center; gap: 6px; width: 100%;
        }

        .level-badge {
            display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px;
            border-radius: 999px; font-size: 0.73rem; font-weight: 700; white-space: nowrap; flex-shrink: 0;
        }
        .level-badge.l3 { background: var(--red-dim); color: var(--red); }
        .level-badge.l2 { background: rgba(251,191,36,0.12); color: var(--amber); }
        .level-badge.l1 { background: rgba(96,165,250,0.12); color: var(--blue); }
        .level-badge.l0 { background: rgba(52,211,153,0.12); color: var(--green); }
        .ldot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; animation: pulse 1.8s ease-in-out infinite; }
        .level-badge.l1 .ldot, .level-badge.l2 .ldot, .level-badge.l0 .ldot { animation: none; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.35} }

        .conf-wrap { display: flex; align-items: center; gap: 7px; flex-shrink: 0; }
        .conf-bar { width: 72px; height: 5px; border-radius: 999px; background: rgba(255,255,255,0.07); overflow: hidden; }
        .conf-fill { height: 100%; border-radius: 999px; transition: width 0.5s ease; }
        .conf-fill.l3 { background: var(--red); }
        .conf-fill.l2 { background: var(--amber); }
        .conf-fill.l1 { background: var(--blue); }
        .conf-fill.l0 { background: var(--green); }
        .conf-val { font-size: 0.73rem; color: var(--text-3); width: 32px; text-align: right; }

        .btn-detail {
            display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px;
            border-radius: var(--radius-md); font-size: 0.76rem; font-weight: 600;
            text-decoration: none; background: var(--bg-glass);
            border: 1px solid var(--border); color: var(--text-2); flex-shrink: 0;
            transition: background 0.2s, color 0.2s, border-color 0.2s;
        }
        .btn-detail:hover { background: var(--accent-dim); color: var(--accent); border-color: rgba(124,111,247,0.4); }

        /* ── No scan state ── */
        .no-scan-banner {
            display: flex; flex-direction: column; align-items: center; gap: 14px;
            padding: 60px 40px; text-align: center;
            background: var(--bg-card); border: 1px dashed rgba(255,255,255,0.1);
            border-radius: var(--radius-lg);
        }
        .no-scan-banner svg { width: 48px; height: 48px; opacity: 0.3; }
        .no-scan-banner .title { font-size: 1rem; font-weight: 600; color: var(--text-2); }
        .no-scan-banner p { color: var(--text-3); font-size: 0.88rem; max-width: 360px; line-height: 1.7; }

        /* ── All clear ── */
        .all-clear {
            display: flex; flex-direction: column; align-items: center; gap: 10px;
            padding: 40px; text-align: center;
            background: rgba(52,211,153,0.05); border: 1px solid rgba(52,211,153,0.15);
            border-radius: var(--radius-lg); margin-bottom: 24px;
        }
        .all-clear .icon { font-size: 2.2rem; }
        .all-clear .title { font-size: 1rem; font-weight: 700; color: var(--green); }
        .all-clear p { color: var(--text-3); font-size: 0.85rem; }

        /* ── Refresh toast ── */
        #toast {
            position: fixed; bottom: 28px; right: 28px; z-index: 999;
            display: none; align-items: center; gap: 10px;
            padding: 12px 18px; border-radius: var(--radius-md);
            background: var(--bg-card); border: 1px solid var(--border);
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
            font-size: 0.84rem; color: var(--text-1);
            animation: slideInUp 0.3s ease;
        }
        #toast.show { display: flex; }
        @keyframes slideInUp { from { transform:translateY(16px);opacity:0 } to { transform:none;opacity:1 } }

        /* ── Chart Filters ── */
        .filter-btn {
            background: var(--bg-glass);
            border: 1px solid var(--border);
            color: var(--text-2);
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            font-size: 0.75rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }
        .filter-btn:hover { background: var(--accent-dim); color: var(--text-1); border-color: rgba(124,111,247,0.4); }
        .filter-btn.active { background: var(--accent); color: #fff; border-color: var(--accent); box-shadow: 0 0 10px rgba(124,111,247,0.3); }

        /* ── Premium Table ── */
        .premium-table-wrap { width: 100%; overflow-x: auto; margin-top: 16px; }
        .premium-table { width: 100%; border-collapse: separate; border-spacing: 0; min-width: 600px; }
        .premium-table th {
            text-align: left; padding: 12px 16px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.05em; color: var(--text-3); border-bottom: 1px solid var(--border);
        }
        .premium-table td { padding: 14px 16px; font-size: 0.88rem; border-bottom: 1px solid rgba(255,255,255,0.04); vertical-align: middle; }
        .premium-table tbody tr { transition: background 0.2s; }
        .premium-table tbody tr:hover { background: rgba(255,255,255,0.02); }
        .empty-table { padding: 32px; text-align: center; color: var(--text-3); font-size: 0.88rem; }

        /* ── Emotion Distribution ── */
        .emotion-row {
            display: flex; align-items: center; justify-content: space-between;
            background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);
            border-radius: var(--radius-md); padding: 18px 24px;
            transition: transform 0.2s, background 0.2s;
        }
        .emotion-row:hover { background: rgba(255,255,255,0.05); transform: translateY(-1px); }
        .emotion-icon {
            width: 48px; height: 48px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; flex-shrink: 0; border: 1px solid rgba(255,255,255,0.05);
        }
        .emotion-info { flex: 1; margin-left: 18px; }
        .emotion-name { font-size: 1.05rem; font-weight: 700; color: var(--text-1); margin-bottom: 4px; }
        .emotion-desc { font-size: 0.85rem; color: var(--text-3); }
        .emotion-stats { text-align: right; }
        .emotion-percent { font-size: 1.5rem; font-weight: 800; color: var(--text-1); margin-bottom: 2px; }
        .emotion-logs { font-size: 0.7rem; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; }

        @media (max-width: 640px) {
            .container { padding: 24px 16px; }
            .topbar { padding: 0 16px; }
        }
    </style>
</head>
<body>

<!-- Top Bar -->
<header class="topbar">
    <div style="display: flex; align-items: center; gap: 32px;">
        <a href="{{ route('counselor.dashboard') }}" class="topbar-logo" style="text-decoration: none;">
            <div class="dot">🎓</div>
            WebKonselor
        </a>
        <nav style="display: flex; gap: 20px;">
            <a href="{{ route('counselor.dashboard') }}" style="color: {{ request()->routeIs('counselor.dashboard') ? 'var(--accent)' : 'var(--text-2)' }}; text-decoration: none; font-size: 0.85rem; font-weight: 600;">Dashboard</a>
            <a href="{{ route('counselor.education.index') }}" style="color: {{ request()->routeIs('counselor.education.*') ? 'var(--accent)' : 'var(--text-2)' }}; text-decoration: none; font-size: 0.85rem; font-weight: 600;">📚 Edukasi</a>
        </nav>
    </div>
</header>

<main class="container">

    <!-- Page Header -->
    <div class="page-header">
        <h1>🚨 Radar Kesehatan Mental</h1>
        <p>Hasil analisis AI IndoBERT diperbarui otomatis setiap kali mahasiswa mengisi jurnal baru.</p>
    </div>

    <!-- Action Bar -->
    <div class="action-bar">
        <div class="last-scan-info">
            @if($lastScan)
                <span class="scan-dot {{ $lastScan->diffInHours(now()) > 24 ? 'stale' : '' }}"></span>
                Terakhir diperbarui: <strong>{{ $lastScan->isoFormat('DD MMM YYYY, HH:mm') }}</strong>
                ({{ $lastScan->diffForHumans() }})
            @else
                <span class="scan-dot never"></span>
                Belum ada data scan. Klik <strong>Pindai Ulang</strong> untuk mulai.
            @endif
        </div>
        <button class="btn-refresh" id="btnRefresh" onclick="runScan()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M23 4v6h-6"/><path d="M1 20v-6h6"/>
                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
            </svg>
            Pindai Ulang
        </button>
    </div>

    <!-- Stats -->
    @php
        $scanned  = $students->whereNotNull('mental_level');
        $countL3  = $scanned->where('mental_level', 3)->count();
        
        // Ambil 4 mahasiswa Level 3 dari terlama hingga terbaru untuk di highlight di atas
        $topL3ForCards = $scanned->where('mental_level', 3)->sortBy('mental_scanned_at')->take(4);
    @endphp

    <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));">
        @forelse($topL3ForCards as $s)
        <a href="{{ route('counselor.detail', $s->nim) }}" class="stat-card danger" style="text-decoration: none; padding: 18px; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
                    <div class="label" style="display: flex; align-items: center; gap: 6px; color: var(--red);">
                        <span class="ldot" style="color: var(--red);"></span> PRIORITAS
                    </div>
                    <div style="font-size: 0.65rem; color: var(--text-3); font-weight: 500; text-transform: uppercase;">
                        {{ $s->mental_scanned_at ? $s->mental_scanned_at->diffForHumans() : '' }}
                    </div>
                </div>
                
                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 14px;">
                    <div class="avatar l3" style="width: 42px; height: 42px; font-size: 1rem;">{{ substr($s->name, 0, 1) }}</div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-size: 0.95rem; font-weight: 600; color: var(--text-1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $s->name }}</div>
                        <div style="font-size: 0.77rem; color: var(--text-3); margin-top: 3px;">{{ $s->nim }} • {{ $s->prodi ?? '-' }}</div>
                    </div>
                </div>
            </div>
            
            @if($s->mental_red_flag)
                <div style="font-size: 0.73rem; color: var(--red); background: rgba(248,113,113,0.08); border: 1px solid rgba(248,113,113,0.18); padding: 8px 10px; border-radius: var(--radius-sm); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $s->mental_red_flag }}">
                    ⚠️ "{{ $s->mental_red_flag }}"
                </div>
            @else
                <div style="font-size: 0.73rem; color: var(--red); background: rgba(248,113,113,0.08); border: 1px solid rgba(248,113,113,0.18); padding: 8px 10px; border-radius: var(--radius-sm); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    Tingkat Keyakinan: {{ round($s->mental_confidence) }}%
                </div>
            @endif
        </a>
        @empty
        <div class="stat-card" style="grid-column: 1 / -1; display: flex; align-items: center; justify-content: center; padding: 24px; color: var(--text-3); gap: 10px;">
            <div class="icon" style="font-size: 1.5rem;">✅</div> 
            <div style="font-size: 0.9rem;">Tidak ada mahasiswa dengan status Level 3 / Krisis saat ini.</div>
        </div>
        @endforelse
    </div>



    @if($scanned->isEmpty())
        <!-- No scan yet -->
        <div class="no-scan-banner">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <span class="title">Belum Ada Hasil Analisis</span>
            <p>Analisis akan muncul otomatis setelah mahasiswa mengisi jurnal, atau klik <strong>Pindai Ulang</strong> untuk memindai semua mahasiswa sekarang.</p>
        </div>
    @else

        @php
            $l3students = $scanned->where('mental_level', 3)->sortBy('name');
        @endphp

        {{-- All clear banner --}}
        @if($countL3 === 0)
        <div class="all-clear">
            <div class="icon">✅</div>
            <div class="title">Semua Mahasiswa Aman</div>
            <p>Tidak ada mahasiswa yang terdeteksi Level 3. Tetap pantau secara berkala.</p>
        </div>
        @endif

        {{-- Tombol Tampilkan Seluruh Mahasiswa Level 3 --}}
        @if($countL3 > 0)
        <div style="display: flex; justify-content: center; margin-bottom: 32px;" data-html2canvas-ignore="true">
            <a href="{{ route('counselor.prioritas') }}" class="btn-detail" style="padding: 12px 24px; font-size: 0.9rem; border-color: rgba(248,113,113,0.3); color: var(--red); background: var(--red-dim); cursor: pointer; text-decoration: none;">
              Buka Halaman Seluruh Mahasiswa Prioritas ({{ $countL3 }})
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left: 6px;"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
        @endif

    @endif

    <!-- Chart Trend Mood -->
    <div id="printChartArea" style="background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 24px; margin-bottom: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); position: relative;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
            <div class="section-title" style="margin-bottom: 0; font-size: 0.85rem">📈 Trend Rata-Rata Mood Mahasiswa</div>
            <div class="chart-filters" style="display: flex; gap: 8px;">
                <button class="filter-btn active" onclick="loadChartData('14d')" data-range="14d">14 Hari</button>
                <button class="filter-btn" onclick="loadChartData('1m')" data-range="1m">1 Bulan</button>
                <button class="filter-btn" onclick="loadChartData('4m')" data-range="4m">4 Bulan</button>
                <button class="filter-btn" onclick="loadChartData('1y')" data-range="1y">1 Tahun</button>
            </div>
        </div>
        <div style="height: 320px; position: relative; margin-bottom: 16px;">
            <canvas id="moodTrendChart"></canvas>
        </div>
        
        <!-- Tabel Persentase Emosi -->
        <div id="emotionDistributionArea" style="margin-top: 32px;">
            <div class="section-title" style="margin-bottom: 16px; font-size: 0.85rem">📊 Laporan Sebaran Emosi (Feelings Trend)</div>
            
            <div style="height: 280px; position: relative; margin-bottom: 32px; background: rgba(255,255,255,0.02); border-radius: var(--radius-lg); padding: 20px; border: 1px solid var(--border);">
                <canvas id="feelingsTrendChart"></canvas>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; margin-top: 24px;" data-html2canvas-ignore="true">
            <button class="btn-detail" onclick="printElementToPDF('printChartArea', 'Laporan_Feelings_Trend.pdf')" style="background: var(--accent); color: white; border: none;">
            Cetak grafik
            </button>
        </div>
    </div>

    <!-- Top Students Table -->
    <div id="printTableArea" style="background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 24px; margin-bottom: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); position: relative;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 12px;">
            <div class="section-title" style="margin-bottom: 0; font-size: 0.85rem">Daftar Mahasiswa</div>
            <div class="chart-filters" style="display: flex; gap: 8px;">
                <button class="filter-btn prodi-btn active" onclick="loadTopStudents('Semua')" data-prodi="Semua">Semua</button>
                <button class="filter-btn prodi-btn" onclick="loadTopStudents('TRPL')" data-prodi="TRPL">TRPL</button>
                <button class="filter-btn prodi-btn" onclick="loadTopStudents('IF')" data-prodi="IF">IF</button>
            </div>
        </div>
        <div class="premium-table-wrap" style="margin-bottom: 20px;">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>NIM</th>
                        <th>Jurnal</th>
                        <th>Status Mental</th>
                        <th>Keyakinan</th>
                        <th style="text-align: right;" data-html2canvas-ignore="true">Aksi</th>
                    </tr>
                </thead>
                <tbody id="topStudentsBody">
                    <tr><td colspan="6" class="empty-table">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>

        <div style="display: flex; justify-content: center; margin-top: 16px;" data-html2canvas-ignore="true">
            <a href="{{ route('counselor.semua-mahasiswa') }}" class="btn-detail" style="padding: 10px 20px; font-size: 0.85rem; border-color: rgba(124,111,247,0.4); color: var(--accent); background: var(--accent-dim); cursor: pointer; text-decoration: none;">
                Lihat Seluruh Mahasiswa →
            </a>
        </div>
    </div>

</main>

<!-- Toast Notification -->
<div id="toast"></div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function showToast(msg, color = 'var(--green)') {
        const t = document.getElementById('toast');
        t.innerHTML = `<span style="width:8px;height:8px;border-radius:50%;background:${color};display:inline-block;flex-shrink:0"></span> ${msg}`;
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 3500);
    }

    function printElementToPDF(elementId, filename) {
        showToast('⏳ Menyusun dokumen PDF...', 'var(--amber)');
        const element = document.getElementById(elementId);

        const opt = {
            margin:       10,
            filename:     filename,
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { 
                scale: 2, 
                useCORS: true, 
                backgroundColor: '#131627',
                scrollY: 0, // Fix the black bar vertical offset issue when scrolled down
                scrollX: 0
            },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
        };

        html2pdf().set(opt).from(element).save().then(() => {
            showToast('✅ Berhasil mengunduh PDF', 'var(--green)');
        }).catch(err => {
            console.error(err);
            showToast('⚠️ Gagal menyusun PDF', 'var(--red)');
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
        showToast('✅ ' + (data.message ?? 'Scan selesai!'), 'var(--green)');
        setTimeout(() => location.reload(), 1200);
    })
    .catch(err => {
        showToast('⚠️ Scan gagal: ' + err.message, 'var(--red)');
        btn.disabled = false;
        btn.innerHTML = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M23 4v6h-6"/><path d="M1 20v-6h6"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg> Pindai Ulang`;
    });
    }

    // Inisialisasi Chart Mood Trend
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

        const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(124,111,247,0.4)');
        gradient.addColorStop(1, 'rgba(124,111,247,0)');

        moodChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Rata-rata Skor Mood',
                    data: data,
                    borderColor: '#7c6ff7',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#7c6ff7',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.35
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 1,
                        max: 5,
                        ticks: {
                            color: '#94a3b8',
                            font: { family: 'Inter', size: 12 },
                            stepSize: 1,
                            callback: function(value) {
                                if(value === 5) return '😁 Senang (5)';
                                if(value === 4) return '🙂 Biasa (4)';
                                if(value === 3) return '😐 Netral (3)';
                                if(value === 2) return '😟 Takut (2)';
                                if(value === 1) return '😭 Marah/Sedih (1)';
                                return value;
                            }
                        },
                        grid: { color: 'rgba(255,255,255,0.06)' }
                    },
                    x: {
                        ticks: { color: '#94a3b8', font: { family: 'Inter' } },
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(13,15,26,0.9)',
                        titleFont: { family: 'Inter', size: 13 },
                        bodyFont: { family: 'Inter', size: 14, weight: 'bold' },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                let val = context.parsed.y;
                                let label = 'Skor Mood: ' + val;
                                if (val >= 4.5) label += ' (Sangat Baik)';
                                else if (val >= 3.5) label += ' (Baik)';
                                else if (val >= 2.5) label += ' (Normal)';
                                else if (val >= 1.5) label += ' (Cemas/Warning)';
                                else label += ' (Sedih/Kritis)';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Inisialisasi Chart Feelings Trend
    let feelingsChartInstance = null;

    function renderFeelingsTrendChart(labels, seriesData) {
        const ctx = document.getElementById('feelingsTrendChart');
        if(!ctx) return;

        const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(52,211,153,0.4)');
        gradient.addColorStop(1, 'rgba(52,211,153,0)');

        if (feelingsChartInstance) {
            feelingsChartInstance.data.labels = labels;
            feelingsChartInstance.data.datasets[0].data = seriesData;
            feelingsChartInstance.update();
            return;
        }

        feelingsChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Trend Dominan Sebaran Emosi',
                    data: seriesData,
                    borderColor: '#34d399',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#34d399',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.35
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 1,
                        max: 5,
                        ticks: { 
                            color: '#94a3b8', 
                            stepSize: 1,
                            font: { family: 'Inter', size: 12 },
                            callback: function(value) {
                                if(value === 5) return '🔥 Semangat (5)';
                                if(value === 4) return '😌 Tenang (4)';
                                if(value === 3) return '😐 Netral (3)';
                                if(value === 2) return '🥱 Lelah (2)';
                                if(value === 1) return '😰 Cemas/Kesal (1)';
                                return value;
                            }
                        },
                        grid: { color: 'rgba(255,255,255,0.06)' }
                    },
                    x: {
                        ticks: { color: '#94a3b8' },
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(13,15,26,0.95)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { family: 'Inter', size: 12 },
                        bodyFont: { family: 'Inter', size: 12, weight: 'bold' },
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                let val = context.parsed.y;
                                let label = 'Sentimen Emosi: ' + val;
                                if (val >= 4.5) label += ' (Semangat)';
                                else if (val >= 3.5) label += ' (Tenang)';
                                else if (val >= 2.5) label += ' (Netral)';
                                else if (val >= 1.5) label += ' (Lelah)';
                                else label += ' (Cemas/Kesal)';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }

    function loadChartData(range = '14d') {
        document.querySelectorAll('.filter-btn:not(.prodi-btn)').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.range === range) btn.classList.add('active');
        });

        fetch('{{ route("counselor.chart-data") }}?range=' + range)
            .then(res => res.json())
            .then(data => {
                renderChart(data.labels, data.data);
                renderFeelingsTrendChart(data.labels, data.feelingsTrend);

                let html = '';
                data.distribution.forEach(item => {
                    html += `
                        <div class="emotion-row">
                            <div class="emotion-icon" style="background: ${item.color}">${item.icon}</div>
                            <div class="emotion-info">
                                <div class="emotion-name">${item.name}</div>
                                <div class="emotion-desc">${item.desc}</div>
                            </div>
                            <div class="emotion-stats">
                                <div class="emotion-percent">${item.percentage}%</div>
                                <div class="emotion-logs">${item.count} LOGS</div>
                            </div>
                        </div>
                    `;
                });
                distList.innerHTML = html;
            })
            .catch(err => console.error("Gagal memuat data grafik:", err));
    }

    function loadTopStudents(prodi = 'Semua') {
        document.querySelectorAll('.prodi-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.prodi === prodi) btn.classList.add('active');
        });

        const tbody = document.getElementById('topStudentsBody');
        tbody.innerHTML = '<tr><td colspan="6" class="empty-table"><div class="spin" style="margin: 0 auto; border-top-color: var(--accent);"></div></td></tr>';

        fetch('{{ route("counselor.top-students") }}?prodi=' + prodi)
            .then(res => res.json())
            .then(res => {
                const students = res.data;
                if (!students || students.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="6" class="empty-table">Belum ada mahasiswa terklafisikasi di prodi ${prodi}.</td></tr>`;
                    return;
                }

                let html = '';
                students.forEach(s => {
                    let lvlClass = s.mental_level === 3 ? 'l3' : (s.mental_level === 2 ? 'l2' : (s.mental_level === 1 ? 'l1' : 'l0'));
                    let badgeColor = s.mental_level === 3 ? 'var(--red)' : (s.mental_level === 2 ? 'var(--amber)' : (s.mental_level === 1 ? 'var(--blue)' : 'var(--green)'));
                    let badgeBg = s.mental_level === 3 ? 'var(--red-dim)' : (s.mental_level === 2 ? 'rgba(251,191,36,0.12)' : (s.mental_level === 1 ? 'rgba(96,165,250,0.12)' : 'rgba(52,211,153,0.12)'));
                    
                    let dotHtml = s.mental_level === 3 ? '<span class="ldot"></span>' : '';
                    let levelBadge = `<span class="level-badge ${lvlClass}" style="background:${badgeBg};color:${badgeColor};">${dotHtml}${s.mental_label}</span>`;
                    
                    html += `
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:12px;">
                                    <div class="avatar ${lvlClass}" style="width:36px;height:36px;font-size:0.85rem">${s.name.substring(0,1).toUpperCase()}</div>
                                    <a href="/konselor/detail/${s.nim}" style="font-weight:600;color:var(--text-1);text-decoration:none;transition:color 0.2s" onmouseover="this.style.color='var(--accent)'" onmouseout="this.style.color='var(--text-1)'">${s.name}</a>
                                </div>
                            </td>
                            <td style="color:var(--text-3); font-size:0.8rem">${s.nim}</td>
                            <td style="color:var(--text-2); font-size:0.8rem">${s.journal_texts_count} entri</td>
                            <td>${levelBadge}</td>
                            <td>
                                <div class="conf-wrap">
                                    <div class="conf-bar" style="width:50px"><div class="conf-fill ${lvlClass}" style="width:${Math.round(s.mental_confidence)}%; background:${badgeColor}"></div></div>
                                    <span class="conf-val" style="font-size:0.7rem">${Math.round(s.mental_confidence)}%</span>
                                </div>
                            </td>
                            <td style="text-align: right;" data-html2canvas-ignore="true">
                                <a href="/konselor/detail/${s.nim}" class="btn-detail" style="font-size: 0.7rem; padding: 4px 10px;">Lihat Jurnal →</a>
                            </td>
                        </tr>
                    `;
                });
                tbody.innerHTML = html;
            })
            .catch(err => {
                console.error(err);
                tbody.innerHTML = '<tr><td colspan="6" class="empty-table" style="color:var(--red)">Gagal memuat data mahasiswa.</td></tr>';
            });
    }

    function toggleCollapse(id, btn) {
        const el = document.getElementById(id);
        if(!el) return;
        el.classList.toggle('show');
        btn.classList.toggle('open');
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadChartData('14d');
        loadTopStudents('Semua');
    });
</script>

</body>
</html>
