<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mahasiswa Prioritas – WebKonselor</title>
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
            --text-1:     #f1f5f9;
            --text-2:     #94a3b8;
            --text-3:     #64748b;
            --radius-lg:  16px;
            --radius-md:  10px;
            --radius-sm:  6px;
            --shadow-red:  0 0 40px rgba(248,113,113,0.15);
        }

        body { font-family: 'Inter', sans-serif; background: var(--bg-base); color: var(--text-1); min-height: 100vh; }

        .topbar {
            position: sticky; top: 0; z-index: 50;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 32px; height: 64px;
            background: rgba(13,15,26,0.88); backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
        }
        .topbar-logo { display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 1.1rem; text-decoration: none; color: var(--text-1); }
        .topbar-logo .dot {
            width: 32px; height: 32px; border-radius: 8px;
            background: linear-gradient(135deg, var(--accent), #a78bfa);
            display: flex; align-items: center; justify-content: center; font-size: 0.85rem;
        }
        
        .container { max-width: 900px; margin: 0 auto; padding: 40px 32px; }

        .page-header { margin-bottom: 32px; display: flex; align-items: center; gap: 16px; }
        .page-header h1 {
            font-size: 1.6rem; font-weight: 700; letter-spacing: -0.03em;
            color: var(--text-1); margin: 0;
        }

        .btn-back {
            display: inline-flex; align-items: center; justify-content: center;
            width: 40px; height: 40px; border-radius: var(--radius-md);
            background: var(--bg-glass); border: 1px solid var(--border);
            color: var(--text-2); text-decoration: none; transition: 0.2s;
        }
        .btn-back:hover { background: var(--accent-dim); color: var(--text-1); border-color: rgba(124,111,247,0.4); }

        .btn-print {
            display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px;
            border-radius: var(--radius-md); font-size: 0.85rem; font-weight: 600;
            background: var(--accent); color: white; border: none; cursor: pointer; text-decoration: none;
            transition: opacity 0.2s;
        }
        .btn-print:hover { opacity: 0.9; }

        .student-grid { display: flex; flex-direction: column; gap: 12px; margin-top: 20px; }
        .student-row {
            display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
            background: var(--bg-card);
            border: 1px solid rgba(248,113,113,0.2);
            border-radius: var(--radius-lg); padding: 16px 20px;
            text-decoration: none; color: inherit;
            transition: border-color 0.2s, box-shadow 0.2s, transform 0.15s;
        }
        .student-row:hover { border-color: rgba(248,113,113,0.5); box-shadow: var(--shadow-red); transform: translateY(-1px); }

        .avatar {
            width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 1rem;
            background: linear-gradient(135deg, #f87171, #ef4444); color: #fff;
        }

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
            background: var(--red-dim); color: var(--red);
        }
        .ldot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; animation: pulse 1.8s ease-in-out infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.35} }

        .conf-wrap { display: flex; align-items: center; gap: 7px; flex-shrink: 0; }
        .conf-bar { width: 72px; height: 5px; border-radius: 999px; background: rgba(255,255,255,0.07); overflow: hidden; }
        .conf-fill { height: 100%; border-radius: 999px; background: var(--red); }
        .conf-val { font-size: 0.73rem; color: var(--text-3); width: 32px; text-align: right; }

        .btn-detail {
            display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px;
            border-radius: var(--radius-md); font-size: 0.76rem; font-weight: 600;
            text-decoration: none; background: var(--bg-glass);
            border: 1px solid var(--border); color: var(--text-2); flex-shrink: 0;
            transition: background 0.2s, color 0.2s, border-color 0.2s;
        }
        .btn-detail:hover { background: var(--accent-dim); color: var(--accent); border-color: rgba(124,111,247,0.4); }

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
    </style>
</head>
<body>

<header class="topbar">
    <a href="{{ route('counselor.dashboard') }}" class="topbar-logo">
        <div class="dot">🎓</div>
        WebKonselor
    </a>
</header>

<main class="container">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div class="page-header" style="margin: 0;">
            <a href="{{ route('counselor.dashboard') }}" class="btn-back" title="Kembali">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <h1>🚨 Daftar Seluruh Mahasiswa Prioritas (Level 3)</h1>
        </div>
        
        <button class="btn-print" onclick="printElementToPDF('printLevel3Area', 'Daftar_Seluruh_Mahasiswa_Prioritas.pdf')">
            Cetak seluruh mahasiswa
        </button>
    </div>

    @if($students->isEmpty())
        <div style="text-align: center; padding: 60px 20px; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); color: var(--text-3);">
            <div style="font-size: 2.5rem; margin-bottom: 16px;">✅</div>
            <p>Tidak ada mahasiswa dengan status prioritas (Level 3) saat ini.</p>
        </div>
    @else
        <div id="printLevel3Area" style="background: var(--bg-card); padding: 32px; border-radius: var(--radius-lg); border: 1px solid var(--border);">
            <h2 style="font-size: 1.1rem; margin-bottom: 8px;" data-html2canvas-ignore="true">Total: {{ $students->count() }} Mahasiswa</h2>
            <p style="color: var(--text-3); font-size: 0.85rem; margin-bottom: 24px;" data-html2canvas-ignore="true">
                Berikut adalah daftar mahasiswa yang terdeteksi membutuhkan penanganan cepat berdasarkan AI.
            </p>

            <div class="student-grid">
                @foreach($students as $s)
                <a class="student-row" href="{{ route('counselor.detail', $s->nim) }}">
                    <div class="avatar">{{ substr($s->name, 0, 1) }}</div>
                    <div class="row-info">
                        <div class="name">{{ $s->name }}</div>
                        <div class="meta">
                            <span>{{ $s->nim }}</span>
                            <span>{{ $s->gender }}</span>
                            <span>{{ $s->journal_texts_count }} jurnal</span>
                            @if($s->mental_scanned_at)
                                <span>Scan: {{ $s->mental_scanned_at->isoFormat('DD MMM, HH:mm') }}</span>
                            @endif
                        </div>
                        @if($s->mental_red_flag)
                        <div class="red-flag-row">⚠️ Red Flag: <strong>"{{ $s->mental_red_flag }}"</strong></div>
                        @endif
                    </div>
                    <span class="level-badge"><span class="ldot"></span>{{ $s->mental_label }}</span>
                    <div class="conf-wrap">
                        <div class="conf-bar"><div class="conf-fill" style="width:{{ round($s->mental_confidence) }}%"></div></div>
                        <span class="conf-val">{{ round($s->mental_confidence) }}%</span>
                    </div>
                    <span class="btn-detail" data-html2canvas-ignore="true">Lihat Jurnal →</span>
                </a>
                @endforeach
            </div>
        </div>
    @endif

</main>

<div id="toast"></div>

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
                scrollY: 0,
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
</script>

</body>
</html>
