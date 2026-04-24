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
            --bg-base:    #0d0f1a;
            --bg-card:    #131627;
            --bg-glass:   rgba(255,255,255,0.04);
            --border:     rgba(255,255,255,0.08);
            --accent:     #7c6ff7;
            --accent-dim: rgba(124,111,247,0.15);
            --green:      #34d399;
            --amber:      #fbbf24;
            --red:        #f87171;
            --blue:       #60a5fa;
            --pink:       #f472b6;
            --text-1:     #f1f5f9;
            --text-2:     #94a3b8;
            --text-3:     #64748b;
            --radius-lg:  16px;
            --radius-md:  10px;
            --radius-sm:  6px;
            --shadow-glow: 0 0 40px rgba(124,111,247,0.12);
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
        .btn-back {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 14px; border-radius: var(--radius-md);
            font-size: 0.82rem; font-weight: 500; text-decoration: none;
            color: var(--text-2); background: var(--bg-glass); border: 1px solid var(--border);
            transition: background 0.2s, color 0.2s;
        }
        .btn-back:hover { background: var(--accent-dim); color: var(--accent); border-color: rgba(124,111,247,0.4); }

        /* ── Layout ── */
        .container { max-width: 1100px; margin: 0 auto; padding: 40px 32px; }

        /* ── Student Profile Card ── */
        .profile-card {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 20px;
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: var(--radius-lg); padding: 24px 28px;
            margin-bottom: 28px;
        }
        .profile-left { display: flex; align-items: center; gap: 16px; }
        .avatar {
            width: 58px; height: 58px; border-radius: 14px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 1.3rem;
            background: linear-gradient(135deg, var(--accent), #a78bfa); color: #fff;
        }
        .profile-meta .name { font-size: 1.2rem; font-weight: 700; letter-spacing: -0.02em; }
        .profile-meta .sub { color: var(--text-3); font-size: 0.82rem; margin-top: 4px; display: flex; gap: 14px; flex-wrap: wrap; }
        .profile-meta .sub span { display: flex; align-items: center; gap: 4px; }
        .pill {
            font-size: 0.72rem; font-weight: 600; padding: 4px 10px;
            border-radius: 999px; white-space: nowrap;
        }
        .pill-L { background: rgba(96,165,250,0.15); color: var(--blue); }
        .pill-P { background: rgba(244,114,182,0.15); color: var(--pink); }

        /* ── Stats ── */
        .stats-row {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 14px; margin-bottom: 28px;
        }
        .stat-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: var(--radius-md); padding: 16px 18px;
        }
        .stat-card .label { font-size: 0.7rem; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.05em; }
        .stat-card .value { font-size: 1.6rem; font-weight: 700; margin-top: 4px; }

        /* ── Toolbar ── */
        .toolbar {
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 20px; flex-wrap: wrap;
        }
        .btn-summary {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; border-radius: var(--radius-md);
            font-size: 0.82rem; font-weight: 600; font-family: inherit;
            border: 1px solid rgba(124,111,247,0.4); background: var(--accent-dim);
            color: var(--accent); cursor: pointer; white-space: nowrap;
            transition: background 0.2s, border-color 0.2s, transform 0.15s;
        }
        .btn-summary:hover { background: rgba(124,111,247,0.25); border-color: var(--accent); transform: translateY(-1px); }
        .btn-summary:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
        .spin {
            width: 12px; height: 12px; border-radius: 50%;
            border: 2px solid rgba(124,111,247,0.3); border-top-color: var(--accent);
            animation: spin 0.7s linear infinite; flex-shrink: 0;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Journal Table ── */
        .table-wrap {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: var(--radius-lg); overflow: hidden;
        }
        table.journal-table { width: 100%; border-collapse: collapse; font-size: 0.86rem; }
        .journal-table thead th {
            padding: 13px 16px; text-align: left; color: var(--text-3);
            font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.05em;
            font-weight: 600; border-bottom: 1px solid var(--border); white-space: nowrap;
        }
        .journal-table tbody tr { border-bottom: 1px solid var(--border); transition: background 0.15s; }
        .journal-table tbody tr:last-child { border-bottom: none; }
        .journal-table tbody tr:hover { background: var(--bg-glass); }
        .journal-table td { padding: 13px 16px; vertical-align: top; }

        .date-badge {
            display: inline-block; padding: 3px 9px; border-radius: var(--radius-sm);
            background: rgba(255,255,255,0.06); font-size: 0.78rem; white-space: nowrap; font-family: monospace;
        }
        .emotion-tag {
            display: inline-flex; align-items: center; gap: 6px; padding: 3px 10px;
            border-radius: 999px; font-size: 0.75rem; font-weight: 600;
            background: rgba(251,191,36,0.12); color: var(--amber);
        }
        .emotion-dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; }
        .journal-text-cell { max-width: 340px; color: var(--text-2); line-height: 1.6; }
        .ai-reply-cell { max-width: 280px; color: var(--green); font-size: 0.83rem; line-height: 1.6; font-style: italic; }
        .ai-none { color: var(--text-3); font-size: 0.82rem; }

        /* ── No Journals ── */
        .no-journals {
            display: flex; flex-direction: column; align-items: center; gap: 12px;
            padding: 60px 40px; text-align: center; color: var(--text-3);
        }
        .no-journals svg { width: 48px; height: 48px; opacity: 0.35; }

        /* ── Modal ── */
        .modal-backdrop {
            display: none; position: fixed; inset: 0; z-index: 200;
            background: rgba(0,0,0,0.65); backdrop-filter: blur(6px);
            align-items: center; justify-content: center; padding: 24px;
        }
        .modal-backdrop.show { display: flex; animation: fadeIn 0.2s ease; }
        @keyframes fadeIn { from { opacity:0 } to { opacity:1 } }
        .modal {
            background: var(--bg-card); border: 1px solid rgba(124,111,247,0.25);
            border-radius: var(--radius-lg); box-shadow: 0 0 60px rgba(124,111,247,0.2);
            width: 100%; max-width: 560px; animation: slideUp 0.25s ease;
        }
        @keyframes slideUp { from { transform: translateY(20px); opacity:0 } to { transform: none; opacity:1 } }
        .modal-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 20px 24px 16px; border-bottom: 1px solid var(--border);
        }
        .modal-header h2 {
            font-size: 1rem; font-weight: 700;
            background: linear-gradient(135deg, var(--text-1) 0%, #a78bfa 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .modal-close {
            width: 32px; height: 32px; border-radius: 8px;
            background: var(--bg-glass); border: 1px solid var(--border);
            color: var(--text-2); cursor: pointer; font-size: 1.1rem;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.15s, color 0.15s;
        }
        .modal-close:hover { background: rgba(248,113,113,0.1); color: var(--red); }
        .modal-body { padding: 20px 24px 24px; }
        .summary-box {
            background: var(--bg-glass); border: 1px solid var(--border);
            border-radius: var(--radius-md); padding: 16px 18px; min-height: 80px;
            font-size: 0.88rem; line-height: 1.7; color: var(--text-2);
        }
        .summary-box.loading { display: flex; align-items: center; justify-content: center; gap: 10px; color: var(--text-3); }
        .summary-box.loading .spin { width: 18px; height: 18px; border: 2px solid rgba(124,111,247,0.3); border-top-color: var(--accent); }
        .summary-box.error { color: var(--red); border-color: rgba(248,113,113,0.25); }
        .summary-box.success { color: var(--text-1); }
        .modal-meta { margin-top: 10px; font-size: 0.75rem; color: var(--text-3); display: flex; align-items: center; gap: 6px; }
        .modal-meta .dot { width: 6px; height: 6px; background: var(--green); border-radius: 50%; display: inline-block; }

        /* ── Red Flag Alert ── */
        .risk-alert {
            background: rgba(248, 113, 113, 0.1);
            border: 1px solid rgba(248, 113, 113, 0.4);
            border-radius: var(--radius-lg);
            padding: 20px 24px;
            margin-bottom: 28px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            animation: pulse-red 2s infinite;
        }
        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(248, 113, 113, 0.2); }
            70% { box-shadow: 0 0 0 10px rgba(248, 113, 113, 0); }
            100% { box-shadow: 0 0 0 0 rgba(248, 113, 113, 0); }
        }
        .risk-alert .icon {
            font-size: 1.5rem;
            flex-shrink: 0;
            padding-top: 2px;
        }
        .risk-alert .content {
            flex: 1;
        }
        .risk-alert .title {
            color: var(--red);
            font-weight: 700;
            font-size: 0.95rem;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .risk-alert .reason {
            color: var(--text-1);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        @media (max-width: 640px) {
            .container { padding: 24px 16px; }
            .topbar { padding: 0 16px; }
        }
    </style>
</head>
<body>

<!-- Top Bar -->
<header class="topbar">
    <div class="topbar-logo">
        <div class="dot">🎓</div>
        WebKonselor
    </div>
    <a href="{{ route('counselor.dashboard') }}" class="btn-back">
        ← Kembali ke Dashboard
    </a>
</header>

<main class="container">

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-left">
            <div class="avatar">{{ substr($student->name, 0, 1) }}</div>
            <div class="profile-meta">
                <div class="name">{{ $student->name }}</div>
                <div class="sub">
                    <span>📋 {{ $student->nim }}</span>
                    <span>
                        <span class="pill {{ $student->gender === 'Laki-laki' ? 'pill-L' : 'pill-P' }}">
                            {{ $student->gender === 'Laki-laki' ? '♂ Laki-laki' : '♀ Perempuan' }}
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <div class="profile-right" style="display: flex; align-items: center; gap: 10px;">
            <div style="font-size: 0.8rem; color: var(--text-2); display: flex; flex-direction: column; align-items: flex-end;">
                <span style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Koreksi Status Klasifikasi</span>
                <select id="statusSelect" style="background: var(--bg-glass); color: var(--text-1); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 6px 10px; font-size: 0.85rem; cursor: pointer; outline: none;">
                    <option value="0" {{ $student->mental_level == 0 ? 'selected' : '' }}>Level 0 (Positif / Baik)</option>
                    <option value="1" {{ $student->mental_level == 1 ? 'selected' : '' }}>Level 1 (Ekspresi Emosi Ringan)</option>
                    <option value="2" {{ $student->mental_level == 2 ? 'selected' : '' }}>Level 2 (Perlu Pemantauan)</option>
                    <option value="3" {{ $student->mental_level == 3 ? 'selected' : '' }}>Level 3 (Krisis / Prioritas)</option>
                </select>
            </div>
            <button onclick="updateStatus('{{ $student->nim }}', event)" style="background: var(--accent); color: white; border: none; padding: 8px 16px; border-radius: var(--radius-md); font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: 0.2s;">
                Simpan
            </button>
        </div>
    </div>

    @if($student->mental_red_flag && $student->mental_level == 3)
    <div class="risk-alert">
        <div class="icon">🚨</div>
        <div class="content">
            <div class="title">
                TEMUAN KRISIS (AI RISK ANALYSIS)
                <span class="pill" style="background:var(--red); color:white; font-size: 0.65rem;">URGENT</span>
            </div>
            <div class="reason">
                {{ $student->mental_red_flag }}
            </div>
            <div style="margin-top: 12px; font-size: 0.75rem; color: var(--text-3);">
                *Alasan ini dideteksi otomatis berdasarkan pola Jurnal dan Tren Mood mahasiswa selama 14 hari terakhir.
            </div>
        </div>
    </div>
    @endif

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="label">Total Jurnal</div>
            <div class="value" style="color:var(--accent)">{{ $student->journalTexts->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Cek-in Harian</div>
            <div class="value" style="color:var(--green)">{{ $student->dailyCheckins->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Pembaruan Terakhir</div>
            <div class="value" style="font-size:1rem; margin-top:8px; color:var(--text-2)">
                @if($student->journalTexts->first())
                    {{ $student->journalTexts->first()->created_at->isoFormat('DD MMM YYYY') }}
                @else
                    —
                @endif
            </div>
        </div>
    </div>

    <!-- Toolbar -->
    @if($student->journalTexts->count() > 0)
    <div class="toolbar">
        <button class="btn-summary" id="btnSummary"
                onclick="openSummary('{{ $student->nim }}', '{{ $student->name }}')">
            ✨ Ringkas Semua Jurnal
        </button>
        <span style="font-size:0.8rem; color:var(--text-3)">
            Gunakan AI untuk merangkum kondisi psikologis mahasiswa ini.
        </span>
    </div>
    @endif

    <!-- Journal Table -->
    <div class="table-wrap">
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
            <table class="journal-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Waktu</th>
                        <th>Status (Mood/Feeling)</th>
                        <th>Isi Jurnal</th>
                        <th>Analisis AI</th>
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
                        <td style="color:var(--text-3); font-size:0.76rem;">{{ $i + 1 }}</td>
                        <td>
                            <span class="date-badge">
                                {{ $journal->created_at->isoFormat('DD MMM YYYY, HH:mm') }}
                            </span>
                        </td>
                        <td>
                            @if($checkin)
                                <div class="emotion-tag" style="margin-bottom: 4px;">
                                    <span class="emotion-dot"></span>
                                    Mood: {{ $checkin->mood->mood_name }}
                                </div>
                                <div style="font-size: 0.72rem; color: var(--text-3);">
                                    Feeling: {{ $checkin->feeling->feeling_name }}
                                </div>
                            @else
                                <span class="ai-none">—</span>
                            @endif
                        </td>
                        <td class="journal-text-cell">{{ $journal->description }}</td>
                        <td>
                            @if($checkin && $checkin->aiAnalysis)
                                <span class="ai-reply-cell">"{{ $checkin->aiAnalysis->text_analysis }}"</span>
                            @else
                                <span class="ai-none">Belum ada analisis</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
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
