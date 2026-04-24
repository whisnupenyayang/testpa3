<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mahasiswa | WebKonselor</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --sidebar-bg: #f0fdf4;
            --primary-green: #065f46;
            --bg-body: #f9fafb;
            --border: #e5e7eb;
            --danger: #ef4444;
        }
        body { font-family: 'Inter', sans-serif; background: var(--bg-body); margin: 0; display: flex; }

        .main-content { margin-left: 260px; flex: 1; padding: 40px; }

        /* Header & Profile */
        .card-profile { background: white; border: 1px solid var(--border); border-radius: 12px; padding: 24px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .profile-left { display: flex; align-items: center; gap: 20px; }
        .avatar-lg { width: 64px; height: 64px; background: #e5e7eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold; overflow: hidden; }
        .avatar-lg img { width: 100%; height: 100%; object-fit: cover; }

        .status-fix-box { display: flex; gap: 10px; background: #f3f4f6; padding: 10px; border-radius: 8px; align-items: center; }
        .alert-crisis { border: 1px solid #f87171; background: #fef2f2; border-radius: 12px; padding: 20px; margin-bottom: 24px; display: flex; gap: 15px; }

        /* Grid Layout */
        .grid-container { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; }
        .card { background: white; border: 1px solid var(--border); border-radius: 12px; padding: 20px; margin-bottom: 20px; }
        
        /* Table Controls */
        .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .table-actions { display: flex; gap: 8px; }
        .btn-outline { display: flex; align-items: center; gap: 6px; padding: 8px 16px; background: white; border: 1px solid var(--border); border-radius: 8px; cursor: pointer; font-size: 0.85rem; font-weight: 500; color: #374151; transition: all 0.2s; }
        .btn-outline:hover { background: #f9fafb; border-color: #d1d5db; }

        /* Stats */
        .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: white; border: 1px solid var(--border); border-radius: 12px; padding: 15px; display: flex; align-items: center; gap: 12px; }

        /* Insight Card */
        .insight-card { background: var(--primary-green); color: white; border-radius: 16px; padding: 24px; }
        .progress-container { margin: 20px 0; }
        .progress-bar { background: rgba(255,255,255,0.2); height: 8px; border-radius: 4px; overflow: hidden; }
        .progress-fill { background: white; height: 100%; width: 82%; }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; font-size: 0.75rem; color: #6b7280; text-transform: uppercase; padding: 12px; border-bottom: 1px solid var(--border); }
        td { padding: 16px 12px; border-bottom: 1px solid var(--border); font-size: 0.875rem; }
    </style>
</head>
<body>

<main class="main-content">
    <div onclick="window.history.back()" style="cursor:pointer; color:#6b7280; font-size:0.9rem; margin-bottom:15px;">← Kembali ke Daftar</div>

    <div class="card-profile">
        <div class="profile-left">
            <div class="avatar-lg">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=random" alt="avatar">
            </div>
            <div>
                <h1 style="margin:0; font-size: 1.25rem;">{{ $student->name }}</h1>
                <p style="color:#6b7280; margin: 4px 0;">NIM: {{ $student->nim }} • {{ $student->gender }}</p>
                <span style="font-size: 0.8rem; color: #065f46; background: #d1fae5; padding: 2px 8px; border-radius: 10px;">Semester 6</span>
            </div>
        </div>
        <div class="status-fix-box">
            <span style="font-size: 0.75rem; font-weight: 600; color: #4b5563;">KOREKSI STATUS KLASIFIKASI:</span>
            <select id="statusSelect" style="padding: 6px; border-radius: 6px; border: 1px solid #d1d5db;">
                 <option value="0" {{ $student->mental_level == 0 ? 'selected' : '' }}>Level 0 (Aman)</option>}">
                 <option value="1" {{ $student->mental_level == 1 ? 'selected' : '' }}>Level 1 (Ringan)</option>
                 <option value="2" {{ $student->mental_level == 2 ? 'selected' : '' }}>Level 2 (Pemantauan)</option>
                 <option value="3" {{ $student->mental_level == 3 ? 'selected' : '' }}>Level 3 (Krisis)</option>
            </select>
            <button onclick="updateStatus('{{ $student->nim }}')" style="background: #6366f1; color: white; border: none; padding: 6px 15px; border-radius: 6px; cursor: pointer; font-weight: 600;">Simpan</button>
        </div>
    </div>

    @if($student->mental_level == 3)
    <div class="alert-crisis">
        <div style="font-size: 1.5rem;">🚨</div>
        <div>
            <h3 style="color:var(--danger); margin: 0 0 5px 0; font-size: 1rem;">TEMUAN KRISIS (AI RISK ANALYSIS) <span style="background:var(--danger); color:white; font-size:0.6rem; padding:2px 6px; border-radius:4px; vertical-align:middle;">URGENT</span></h3>
            <p style="margin:0; font-size:0.9rem; color: #7f1d1d;"><strong>[KOREKSI KONSELOR]:</strong> Diperbarui secara manual berdasarkan pola jurnal terbaru.</p>
            <p style="margin:5px 0 0 0; font-size:0.85rem; color: #991b1b;">{{ $student->mental_red_flag ?? 'Mahasiswa memerlukan perhatian segera.' }}</p>
        </div>
    </div>
    @endif

    <div class="grid-container">
        <div>
            <div class="card">
                <h3 style="margin-top:0; font-size: 1rem;">😊 Tren Mood (7 Hari Terakhir)</h3>
                <canvas id="moodChart" height="100"></canvas>
            </div>

            <div class="card">
                <h3 style="margin-top:0; font-size: 1rem;">📍 Tren Perasaan</h3>
                <canvas id="feelingChart" height="100"></canvas>
            </div>

            <div class="stats-row">
                <div class="stat-card">
                    <div style="background:#f3f4f6; padding:8px; border-radius:8px;">📄</div>
                    <div><div style="font-size:0.7rem; color:#6b7280;">TOTAL JURNAL</div><div style="font-weight:700;">{{ $student->journalTexts->count() }}</div></div>
                </div>
                <div class="stat-card">
                    <div style="background:#f3f4f6; padding:8px; border-radius:8px;">📅</div>
                    <div><div style="font-size:0.7rem; color:#6b7280;">CEK-IN HARIAN</div><div style="font-weight:700;">{{ $student->dailyCheckins->count() }}</div></div>
                </div>
                <div class="stat-card">
                    <div style="background:#f3f4f6; padding:8px; border-radius:8px;">🔄</div>
                    <div><div style="font-size:0.7rem; color:#6b7280;">PEMBARUAN</div><div style="font-weight:700;">21 Apr 2026</div></div>
                </div>
            </div>

            <div class="card">
                <div class="table-header">
                    <h3 style="margin:0; font-size: 1.1rem;">Riwayat Log Jurnal</h3>
                    <div class="table-actions">
                        <button class="btn-outline"><span>🔍</span> Filter</button>
                        <button class="btn-outline" onclick="exportPDF()"><span>📄</span> Ekspor PDF</button>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr><th>Waktu</th><th>Status Mood</th><th>Isi Jurnal</th><th>Analisis AI</th></tr>
                    </thead>
                    <tbody>
                        @foreach($student->journalTexts as $j)
                        <tr>
                            <td><strong>{{ $j->created_at->format('d M Y') }}</strong><br><small>{{ $j->created_at->format('H:i') }}</small></td>
                            <td><span style="background:#fef3c7; color:#92400e; padding:4px 8px; border-radius:6px; font-size:0.75rem;">🟡 Mood: Terkejut</span></td>
                            <td style="color:#4b5563;">{{ Str::limit($j->description, 60) }}</td>
                            <td><small style="color:#9ca3af;">Belum ada analisis</small></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 24px;">
            <div class="insight-card">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:15px;">
                    <div style="background:rgba(255,255,255,0.2); padding:8px; border-radius:50%;">✨</div>
                    <h3 style="margin:0; font-size:1.1rem;">Insight Analisis Jurnal</h3>
                </div>
                <p style="font-size:0.9rem; line-height:1.6; opacity:0.9;">
                    {{ $student->name }} menunjukkan tren stabil dalam mood belakangan ini. AI mendeteksi kemajuan positif pada regulasi emosi.
                </p>
                <div class="progress-container">
                    <div style="display:flex; justify-content:space-between; font-size:0.75rem; margin-bottom:5px;">
                        <span>82%</span>
                    </div>
                    <div class="progress-bar"><div class="progress-fill"></div></div>
                </div>
                <button onclick="openSummary()" style="width:100%; padding:12px; border-radius:10px; border:none; background:white; color:var(--primary-green); font-weight:700; cursor:pointer;">
                   📖 Ringkas Semua Jurnal
                </button>
            </div>
        </div>
    </div>
</main>

<script>
    // Inisialisasi Grafik
    const moodCtx = document.getElementById('moodChart').getContext('2d');
    new Chart(moodCtx, {
        type: 'line',
        data: {
            labels: ['SEN', 'SEL', 'RAB', 'KAM', 'JUM', 'SAB', 'MIN'],
            datasets: [{
                data: [3, 4, 3, 5, 4, 2, 4],
                borderColor: '#065f46',
                backgroundColor: 'rgba(6, 95, 70, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { display: false } } }
    });

    const feelingCtx = document.getElementById('feelingChart').getContext('2d');
    new Chart(feelingCtx, {
        type: 'line',
        data: {
            labels: ['SEN', 'SEL', 'RAB', 'KAM', 'JUM', 'SAB', 'MIN'],
            datasets: [{
                data: [2, 2.5, 2, 3, 4, 4.5, 4],
                borderColor: '#6b7280',
                borderDash: [5, 5],
                tension: 0.4
            }]
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { display: false } } }
    });

    function exportPDF() {
        alert('Menyiapkan dokumen PDF...');
    }

    function updateStatus(nim) {
        const level = document.getElementById('statusSelect').value;
        alert('Mengupdate NIM ' + nim + ' ke Level ' + level);
    }

    function openSummary() {
        alert('Membuka Ringkasan AI...');
    }
</script>
</body>
</html>