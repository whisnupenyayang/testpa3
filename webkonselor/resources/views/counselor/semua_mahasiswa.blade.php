<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Seluruh Mahasiswa – WebKonselor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-base:    #f8fafc;
            --bg-card:    #ffffff;
            --border:     #e2e8f0;
            --accent:     #059669;
            --accent-dim: #ecfdf5;
            --green:      #059669;
            --amber:      #d97706;
            --red:        #dc2626;
            --blue:       #2563eb;
            --text-1:     #1e293b;
            --text-2:     #475569;
            --text-3:     #94a3b8;
            --radius-lg:  16px;
            --radius-md:  10px;
            --radius-sm:  6px;
            --shadow-sm:  0 1px 3px rgba(0,0,0,0.05);
        }

        body { font-family: 'Inter', sans-serif; background: var(--bg-base); color: var(--text-1); min-height: 100vh; }

        .topbar {
            position: sticky; top: 0; z-index: 50;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 32px; height: 64px;
            background: rgba(255,255,255,0.9); backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
        }
        .topbar-logo { display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 1.1rem; text-decoration: none; color: var(--text-1); }
        .topbar-logo .dot {
            width: 32px; height: 32px; border-radius: 8px;
            background: linear-gradient(135deg, #10b981, #059669);
            display: flex; align-items: center; justify-content: center; font-size: 0.85rem; color: white;
        }

        .container { max-width: 1100px; margin: 0 auto; padding: 40px 32px; }

        .page-header { margin-bottom: 32px; display: flex; align-items: center; gap: 16px; }
        .page-header h1 {
            font-size: 1.5rem; font-weight: 700; letter-spacing: -0.03em;
            color: var(--text-1); margin: 0;
        }

        .btn-back {
            display: inline-flex; align-items: center; justify-content: center;
            width: 40px; height: 40px; border-radius: var(--radius-md);
            background: #fff; border: 1px solid var(--border);
            color: var(--text-2); text-decoration: none; transition: 0.2s;
        }
        .btn-back:hover { background: var(--bg-base); color: var(--text-1); border-color: #cbd5e1; }

        .btn-print {
            display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px;
            border-radius: var(--radius-md); font-size: 0.85rem; font-weight: 600;
            background: #fff; color: var(--text-1); border: 1px solid var(--border); cursor: pointer; text-decoration: none;
            transition: 0.2s;
        }
        .btn-print:hover { background: var(--bg-base); border-color: #cbd5e1; }
        .btn-print svg { color: var(--text-2); }

        .premium-table {
            width: 100%; border-collapse: collapse; text-align: left;
            background: var(--bg-card); border-radius: var(--radius-lg); overflow: hidden;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }
        .premium-table thead {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }
        .premium-table th {
            padding: 16px 20px; font-size: 0.75rem; font-weight: 700; color: #059669;
            text-transform: uppercase; letter-spacing: 0.05em; white-space: nowrap;
        }
        .premium-table td {
            padding: 16px 20px; border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }
        .premium-table tr:last-child td { border-bottom: none; }
        .premium-table tbody tr { transition: background 0.2s; }
        .premium-table tbody tr:hover { background: #f8fafc; }

        .student-cell { display: flex; align-items: center; gap: 14px; }
        .avatar {
            width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.9rem;
            background: linear-gradient(135deg, #f87171, #ef4444); color: #fff;
        }
        .avatar.l2 { background: linear-gradient(135deg, var(--amber), #d97706); }
        .avatar.l1 { background: linear-gradient(135deg, var(--blue), #2563eb); }
        .avatar.l0 { background: linear-gradient(135deg, var(--green), #059669); }

        .name-wrapper { display: flex; flex-direction: column; }
        .name-wrapper .name { font-weight: 600; font-size: 0.9rem; color: var(--text-1); }
        .name-wrapper .red-flag { font-size: 0.7rem; color: var(--red); font-weight: 600; margin-top: 4px; display: flex; align-items: center; gap: 4px; text-transform: uppercase; letter-spacing: 0.05em; }

        .pill-status {
            display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px;
            border-radius: 999px; font-size: 0.7rem; font-weight: 700; white-space: nowrap;
            text-transform: uppercase; letter-spacing: 0.02em;
        }
        .pill-status.l3 { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .pill-status.l2 { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
        .pill-status.l1 { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
        .pill-status.l0 { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
        .ldot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        .ldot.anim { animation: pulse 1.8s ease-in-out infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.35} }

        .conf-wrap { display: flex; flex-direction: column; gap: 4px; }
        .conf-bar { width: 100px; height: 6px; border-radius: 999px; background: #e2e8f0; overflow: hidden; }
        .conf-fill { height: 100%; border-radius: 999px; }
        .conf-fill.l3 { background: var(--red); }
        .conf-fill.l2 { background: var(--amber); }
        .conf-fill.l1 { background: var(--blue); }
        .conf-fill.l0 { background: var(--green); }
        .conf-val { font-size: 0.75rem; color: var(--text-2); font-weight: 600; }

        .btn-detail {
            display: inline-flex; align-items: center; padding: 6px 12px;
            border-radius: 6px; font-size: 0.75rem; font-weight: 600;
            text-decoration: none; background: #fff;
            border: 1px solid var(--border); color: var(--text-2);
            transition: 0.2s; white-space: nowrap;
        }
        .btn-detail:hover { background: var(--bg-base); color: var(--text-1); border-color: #cbd5e1; }

        #toast {
            position: fixed; bottom: 28px; right: 28px; z-index: 999;
            display: none; align-items: center; gap: 10px;
            padding: 12px 18px; border-radius: var(--radius-md);
            background: #fff; border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            font-size: 0.84rem; color: var(--text-1); font-weight: 500;
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
            <h1>📑 Daftar Seluruh Mahasiswa</h1>
        </div>
        
        <button class="btn-print" onclick="printElementToPDF('printLevel3Area', 'Daftar_Seluruh_Mahasiswa.pdf')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7"></path><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            Cetak Laporan PDF
        </button>
    </div>

    @if($students->isEmpty())
        <div style="text-align: center; padding: 60px 20px; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); color: var(--text-3);">
            <div style="font-size: 2.5rem; margin-bottom: 16px;">✅</div>
            <p>Belum ada mahasiswa yang masuk dalam rekam data AI.</p>
        </div>
    @else
        <div id="printLevel3Area" style="background: var(--bg-card); border-radius: var(--radius-lg); border: 1px solid var(--border); box-shadow: var(--shadow-sm); overflow: auto;">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>MAHASISWA</th>
                        <th>NIM</th>
                        <th>GENDER & JURNAL</th>
                        <th>STATUS</th>
                        <th>PREDIKSI AI</th>
                        <th style="text-align: right;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $s)
                    @php
                        $lvlClass = $s->mental_level === 3 ? 'l3' : ($s->mental_level === 2 ? 'l2' : ($s->mental_level === 1 ? 'l1' : 'l0'));
                    @endphp
                    <tr>
                        <td>
                            <div class="student-cell">
                                <div class="avatar {{ $lvlClass }}">{{ substr($s->name, 0, 1) }}</div>
                                <div class="name-wrapper">
                                    <span class="name">{{ $s->name }}</span>
                                    @if($s->mental_red_flag)
                                        <span class="red-flag">🚨 Red Flag Terdeteksi</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="color: var(--text-2); font-size: 0.85rem; font-weight: 500;">
                            {{ $s->nim }}
                        </td>
                        <td style="color: var(--text-2); font-size: 0.85rem;">
                            <div style="font-weight: 500;">{{ $s->gender }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-3); margin-top: 2px;">{{ $s->journal_texts_count }} jurnal</div>
                        </td>
                        <td>
                            <span class="pill-status {{ $lvlClass }}">
                                <span class="ldot {{ $s->mental_level === 3 ? 'anim' : '' }}"></span>
                                {{ $s->mental_label }}
                            </span>
                        </td>
                        <td>
                            <div class="conf-wrap">
                                <span class="conf-val">{{ round($s->mental_confidence) }}%</span>
                                <div class="conf-bar"><div class="conf-fill {{ $lvlClass }}" style="width:{{ round($s->mental_confidence) }}%"></div></div>
                            </div>
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('counselor.detail', $s->nim) }}" class="btn-detail" data-html2canvas-ignore="true">Lihat Riwayat</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
                backgroundColor: '#ffffff',
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
