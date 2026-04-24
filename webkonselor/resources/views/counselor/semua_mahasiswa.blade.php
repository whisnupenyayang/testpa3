<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Seluruh Mahasiswa – WebKonselor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-base:     #080a12;
            --bg-card:     #111422;
            --bg-glass:    rgba(255,255,255,0.03);
            --border:      rgba(255,255,255,0.06);
            --accent:      #8b5cf6; /* Violet yang lebih cerah */
            --accent-glow: rgba(139, 92, 246, 0.3);
            --green:       #10b981;
            --amber:       #f59e0b;
            --red:         #ef4444;
            --text-1:      #ffffff;
            --text-2:      #a1a1aa;
            --text-3:      #71717a;
            --radius-xl:   20px;
            --radius-lg:   14px;
            --shadow-sm:   0 4px 12px rgba(0,0,0,0.5);
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg-base); 
            color: var(--text-1); 
            line-height: 1.6;
        }

        /* Topbar yang lebih minimalis */
        .topbar {
            position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 40px; height: 70px;
            background: rgba(8, 10, 18, 0.8); backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }
        .topbar-logo { display: flex; align-items: center; gap: 12px; font-weight: 800; font-size: 1.2rem; text-decoration: none; color: white; letter-spacing: -0.5px; }
        .logo-box {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), #d946ef);
            display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
            box-shadow: 0 0 15px var(--accent-glow);
        }
        
        .container { max-width: 1100px; margin: 0 auto; padding: 40px 20px; }

        /* Header Styling */
        .page-header-wrap {
            display: flex; justify-content: space-between; align-items: flex-end;
            margin-bottom: 40px; border-bottom: 1px solid var(--border);
            padding-bottom: 24px;
        }
        .header-title h1 { font-size: 2rem; font-weight: 800; letter-spacing: -1px; margin-bottom: 4px; }
        .header-title p { color: var(--text-3); font-size: 0.95rem; }

        .btn-print {
            background: white; color: black; padding: 12px 24px;
            border-radius: var(--radius-lg); font-weight: 700; border: none;
            cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; align-items: center; gap: 10px; font-size: 0.9rem;
        }
        .btn-print:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(255,255,255,0.1); filter: brightness(0.9); }

        /* Card Student Row */
        .student-list { display: grid; gap: 16px; }
        .student-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 24px;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 24px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
        }
        .student-card:hover {
            border-color: rgba(255,255,255,0.15);
            background: #161a2d;
            transform: scale(1.01);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        /* Border khusus berdasarkan level (Glow effect) */
        .student-card.l3 { border-left: 5px solid var(--red); }
        .student-card.l2 { border-left: 5px solid var(--amber); }
        .student-card.l1 { border-left: 5px solid var(--accent); }
        .student-card.l0 { border-left: 5px solid var(--green); }

        .avatar-wrap { position: relative; }
        .avatar {
            width: 60px; height: 60px; border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; font-weight: 800; color: white;
            background: var(--bg-glass); border: 1px solid var(--border);
        }
        .avatar.l3 { background: linear-gradient(135deg, #ef4444, #991b1b); }
        .avatar.l2 { background: linear-gradient(135deg, #f59e0b, #92400e); }
        .avatar.l0 { background: linear-gradient(135deg, #10b981, #064e3b); }

        .info-main .name { font-size: 1.15rem; font-weight: 700; margin-bottom: 4px; display: block; }
        .info-main .stats { display: flex; gap: 16px; color: var(--text-3); font-size: 0.8rem; font-weight: 500; }
        .stats span { display: flex; align-items: center; gap: 5px; }

        /* Flag Alert */
        .flag-box {
            margin-top: 12px; padding: 10px 14px;
            background: rgba(239, 68, 68, 0.08);
            border-radius: var(--radius-lg);
            font-size: 0.85rem; color: #fca5a5;
            display: flex; gap: 10px; border: 1px solid rgba(239, 68, 68, 0.2);
        }

        /* Level Badge */
        .status-section { text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 10px; }
        .badge {
            padding: 6px 16px; border-radius: 100px; font-size: 0.75rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .badge.l3 { background: #fee2e2; color: #991b1b; box-shadow: 0 0 20px rgba(239, 68, 68, 0.3); }
        .badge.l0 { background: #d1fae5; color: #065f46; }

        /* Confidence Meter */
        .meter-container { width: 120px; text-align: right; }
        .meter-label { font-size: 0.7rem; color: var(--text-3); margin-bottom: 4px; display: block; font-weight: 600; }
        .meter-bar { height: 6px; background: rgba(255,255,255,0.05); border-radius: 10px; overflow: hidden; }
        .meter-fill { height: 100%; border-radius: 10px; transition: width 1s ease-in-out; }
        .meter-fill.l3 { background: var(--red); }
        .meter-fill.l0 { background: var(--green); }

        /* Detail Button Hover */
        .btn-view {
            padding: 8px 16px; background: var(--bg-glass); border: 1px solid var(--border);
            border-radius: var(--radius-md); font-size: 0.8rem; font-weight: 700; color: var(--text-2);
            transition: all 0.3s;
        }
        .student-card:hover .btn-view { background: white; color: black; border-color: white; }

        @media (max-width: 768px) {
            .student-card { grid-template-columns: 1fr; text-align: center; justify-items: center; }
            .status-section { align-items: center; }
        }
    </style>
</head>
<body>

<header class="topbar">
    <a href="#" class="topbar-logo">
        <div class="logo-box">W</div>
        WebKonselor
    </a>
</header>

<main class="container">
    <div class="page-header-wrap">
        <div class="header-title">
            <h1>Daftar Mahasiswa</h1>
            <p>Memantau rekam jejak psikologis mahasiswa melalui analisis prediktif AI.</p>
        </div>
        <button class="btn-print" onclick="window.print()">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 14h12v8H6z"/></svg>
            Cetak PDF
        </button>
    </div>

    <div class="student-list">
        @foreach($students as $s)
        @php
            $lvl = $s->mental_level;
            $class = $lvl == 3 ? 'l3' : ($lvl == 2 ? 'l2' : ($lvl == 1 ? 'l1' : 'l0'));
        @endphp
        
        <a href="{{ route('counselor.detail', $s->nim) }}" class="student-card {{ $class }}">
            <div class="avatar-wrap">
                <div class="avatar {{ $class }}">{{ substr($s->name, 0, 1) }}</div>
            </div>

            <div class="info-main">
                <span class="name">{{ $s->name }}</span>
                <div class="stats">
                    <span>🆔 {{ $s->nim }}</span>
                    <span>👤 {{ $s->gender }}</span>
                    <span>📚 {{ $s->journal_texts_count }} Jurnal</span>
                </div>
                
                @if($s->mental_red_flag)
                <div class="flag-box">
                    <span>⚠️</span>
                    <strong>Red Flag: "{{ $s->mental_red_flag }}"</strong>
                </div>
                @endif
            </div>

            <div class="status-section">
                <span class="badge {{ $class }}">{{ $s->mental_label }}</span>
                
                <div class="meter-container">
                    <span class="meter-label">AI CONFIDENCE: {{ round($s->mental_confidence) }}%</span>
                    <div class="meter-bar">
                        <div class="meter-fill {{ $class }}" style="width: {{ $s->mental_confidence }}%"></div>
                    </div>
                </div>

                <div class="btn-view">Lihat Jurnal</div>
            </div>
        </a>
        @endforeach
    </div>
</main>

</body>
</html>