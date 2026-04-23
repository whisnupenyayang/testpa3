<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edukasi – WebKonselor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;600;700&display=swap" rel="stylesheet" />
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
            --text-1:     #f1f5f9;
            --text-2:     #94a3b8;
            --text-3:     #64748b;
            --radius-lg:  20px;
            --radius-md:  12px;
            --radius-sm:  8px;
        }

        body { font-family: 'Inter', sans-serif; background: var(--bg-base); color: var(--text-1); min-height: 100vh; overflow-x: hidden; }

        .topbar {
            position: sticky; top: 0; z-index: 50;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 40px; height: 72px;
            background: rgba(13,15,26,0.8); backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
        }
        .topbar-logo { display: flex; align-items: center; gap: 12px; font-weight: 700; font-size: 1.2rem; font-family: 'Outfit', sans-serif; color: #fff; text-decoration: none; }
        .topbar-logo .dot {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), #a78bfa);
            display: flex; align-items: center; justify-content: center; font-size: 1rem;
        }

        .container { max-width: 1000px; margin: 0 auto; padding: 60px 32px; }

        .page-header { margin-bottom: 48px; text-align: center; }
        .page-header h1 { font-family: 'Outfit', sans-serif; font-size: 2.2rem; font-weight: 700; letter-spacing: -0.02em; margin-bottom: 12px; }
        .page-header p { color: var(--text-3); font-size: 1rem; max-width: 500px; margin: 0 auto; }

        .choice-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-top: 20px;
        }

        .choice-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 40px;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .choice-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at top right, rgba(124, 111, 247, 0.1), transparent 60%);
            opacity: 0; transition: opacity 0.3s;
        }

        .choice-card:hover {
            transform: translateY(-8px);
            border-color: rgba(124, 111, 247, 0.4);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3), 0 0 20px rgba(124, 111, 247, 0.1);
        }

        .choice-card:hover::before { opacity: 1; }

        .icon-box {
            width: 80px; height: 80px;
            background: var(--bg-glass);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem;
            margin-bottom: 24px;
            border: 1px solid var(--border);
            transition: transform 0.3s;
        }

        .choice-card:hover .icon-box { transform: scale(1.1) rotate(5deg); background: var(--accent-dim); border-color: rgba(124, 111, 247, 0.3); }

        .choice-title { font-size: 1.5rem; font-weight: 700; font-family: 'Outfit', sans-serif; margin-bottom: 12px; }
        .choice-desc { color: var(--text-3); font-size: 0.95rem; line-height: 1.6; margin-bottom: 24px; }

        .badge {
            background: var(--bg-glass); color: var(--accent);
            padding: 6px 16px; border-radius: 99px;
            font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
        }

        .nav-links { display: flex; gap: 24px; }
        .nav-links a { text-decoration: none; color: var(--text-2); font-size: 0.9rem; font-weight: 600; transition: 0.2s; }
        .nav-links a:hover { color: var(--accent); }
    </style>
</head>
<body>

<header class="topbar">
    <div style="display: flex; align-items: center; gap: 40px;">
        <a href="{{ route('counselor.dashboard') }}" class="topbar-logo">
            <div class="dot">🎓</div>
            WebKonselor
        </a>
        <div class="nav-links">
            <a href="{{ route('counselor.dashboard') }}">Dashboard</a>
            <a href="{{ route('counselor.education.index') }}" style="color: var(--accent);">📚 Edukasi</a>
        </div>
    </div>
</header>

<main class="container">
    <div class="page-header">
        <h1>Pusat Edukasi & Intervensi</h1>
        <p>Kelola konten pembelajaran dan tantangan untuk membantu mahasiswa meningkatkan kualitas kesehatan mental mereka.</p>
    </div>

    <div class="choice-grid">
        <!-- Module Choice -->
        <a href="{{ route('counselor.education.modules.index') }}" class="choice-card">
            <div class="icon-box">📖</div>
            <div class="choice-title">Manajemen Modul</div>
            <div class="choice-desc">Buat dan kelola materi edukasi seperti artikel, tips relaksasi, atau panduan psikologis untuk mahasiswa.</div>
            <div class="badge">{{ $moduleCount }} Terdaftar</div>
        </a>

        <!-- Challenge Choice -->
        <a href="{{ route('counselor.education.challenges.index') }}" class="choice-card">
            <div class="icon-box">🎮</div>
            <div class="choice-title">Manajemen Challenge</div>
            <div class="choice-desc">Kembangkan kuis dan tantangan interaktif berhadiah poin untuk memotivasi mahasiswa tetap aktif menjaga diri.</div>
            <div class="badge">{{ $challengeCount }} Terdaftar</div>
        </a>
    </div>
</main>

</body>
</html>
