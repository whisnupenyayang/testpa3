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
            --radius-lg:  16px;
            --radius-md:  10px;
            --radius-sm:  6px;
            --shadow-sm:  0 1px 3px rgba(0,0,0,0.05);
            --shadow-md:  0 4px 6px -1px rgba(0,0,0,0.05);
        }

        body { font-family: 'Inter', sans-serif; background: var(--bg-base); color: var(--text-1); min-height: 100vh; display: flex; }

        /* ── Sidebar ── */
        .sidebar {
            width: 280px;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            padding: 32px 24px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            height: 100vh;
            position: sticky;
            top: 0;
        }
        .sidebar-header {
            margin-bottom: 40px;
            text-align: center;
        }
        .sidebar-header::before {
            content: ''; display: block; width: 16px; height: 2px; background: #60a5fa; margin: 0 auto 12px auto; border-radius: 2px;
        }
        .sidebar-header::after {
            content: ''; display: block; width: 16px; height: 2px; background: #f472b6; margin: 24px auto 0 auto; border-radius: 2px;
        }
        .sidebar-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #064e3b;
            margin-bottom: 6px;
        }
        .sidebar-subtitle {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-2);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 24px;
            border-radius: var(--radius-md);
            text-decoration: none;
            color: var(--accent);
            font-weight: 600;
            font-size: 1.05rem;
            transition: all 0.2s;
        }
        .nav-item:hover {
            background: rgba(16, 185, 129, 0.1);
        }
        .nav-item.active {
            background: var(--accent-light);
            color: #064e3b;
            font-weight: 700;
        }
        .nav-item svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

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

        /* ── Layout ── */
        .container { max-width: 1000px; margin: 0 auto; width: 100%; padding: 40px 32px; }

        .page-header { margin-bottom: 48px; text-align: center; }
        .page-header h1 { font-family: 'Outfit', sans-serif; font-size: 2.6rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 12px; color: var(--text-1); }
        .page-header p { color: var(--text-2); font-size: 1.1rem; max-width: 600px; margin: 0 auto; line-height: 1.6; }

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
            box-shadow: var(--shadow-sm);
        }

        .choice-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at top right, rgba(5, 150, 105, 0.05), transparent 60%);
            opacity: 0; transition: opacity 0.3s;
        }

        .choice-card:hover {
            transform: translateY(-8px);
            border-color: rgba(5, 150, 105, 0.4);
            box-shadow: var(--shadow-md);
        }

        .choice-card:hover::before { opacity: 1; }

        .icon-box {
            width: 80px; height: 80px;
            background: var(--bg-sidebar);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem;
            margin-bottom: 24px;
            border: 1px solid var(--accent-light);
            transition: transform 0.3s;
        }

        .choice-card:hover .icon-box { transform: scale(1.1) rotate(5deg); background: var(--accent-light); }

        .choice-title { font-size: 1.5rem; font-weight: 800; font-family: 'Outfit', sans-serif; margin-bottom: 12px; color: var(--text-1); }
        .choice-desc { color: var(--text-2); font-size: 0.95rem; line-height: 1.6; margin-bottom: 24px; }

        .badge {
            background: var(--bg-sidebar); color: var(--accent);
            padding: 6px 16px; border-radius: 999px;
            font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
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
                <div class="badge">{{ $moduleCount ?? 0 }} Terdaftar</div>
            </a>

            <!-- Challenge Choice -->
            <a href="{{ route('counselor.education.challenges.index') }}" class="choice-card">
                <div class="icon-box">🎮</div>
                <div class="choice-title">Manajemen Challenge</div>
                <div class="choice-desc">Kembangkan kuis dan tantangan interaktif berhadiah poin untuk memotivasi mahasiswa tetap aktif menjaga diri.</div>
                <div class="badge">{{ $challengeCount ?? 0 }} Terdaftar</div>
            </a>
        </div>
    </div>
</main>

</body>
</html>
