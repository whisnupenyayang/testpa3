<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ isset($challenge) ? 'Edit Challenge' : 'Tambah Challenge' }} – WebKonselor</title>
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
            --red:        #dc2626;
            --red-dim:    #fef2f2;
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
        .sidebar-header { margin-bottom: 40px; text-align: center; }
        .sidebar-header::before { content: ''; display: block; width: 16px; height: 2px; background: #60a5fa; margin: 0 auto 12px auto; border-radius: 2px; }
        .sidebar-header::after { content: ''; display: block; width: 16px; height: 2px; background: #f472b6; margin: 24px auto 0 auto; border-radius: 2px; }
        .sidebar-title { font-size: 1.5rem; font-weight: 800; color: #064e3b; margin-bottom: 6px; }
        .sidebar-subtitle { font-size: 0.9rem; font-weight: 600; color: var(--text-2); text-transform: uppercase; letter-spacing: 0.05em; }
        .sidebar-nav { display: flex; flex-direction: column; gap: 8px; }
        .nav-item { display: flex; align-items: center; gap: 16px; padding: 16px 24px; border-radius: var(--radius-md); text-decoration: none; color: var(--accent); font-weight: 600; font-size: 1.05rem; transition: all 0.2s; }
        .nav-item:hover { background: rgba(16, 185, 129, 0.1); }
        .nav-item.active { background: var(--accent-light); color: #064e3b; font-weight: 700; }
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
        .topbar-left { display: flex; align-items: center; gap: 16px; }
        .btn-back-link { display: flex; align-items: center; gap: 6px; color: var(--text-2); text-decoration: none; font-size: 0.95rem; font-weight: 600; transition: color 0.2s; padding: 10px 16px; border-radius: 8px; }
        .btn-back-link:hover { background: #f8fafc; color: var(--accent); }

        .user-profile { display: flex; align-items: center; gap: 12px; cursor: pointer; padding: 4px 8px; border-radius: 12px; transition: background 0.2s; }
        .user-profile:hover { background: #f8fafc; }
        .user-info { display: flex; flex-direction: column; align-items: flex-end; }
        .user-name { font-size: 1rem; font-weight: 700; color: var(--text-1); }
        .user-role { font-size: 0.8rem; font-weight: 700; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.05em; }
        .user-avatar { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; background: var(--border); border: 2px solid #f8fafc; }

        /* ── Layout ── */
        .container { max-width: 900px; margin: 0 auto; width: 100%; padding: 32px; }

        .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 40px; box-shadow: var(--shadow-sm); }
        .form-title { font-family: 'Outfit', sans-serif; font-size: 2.2rem; font-weight: 800; color: var(--text-1); margin-bottom: 40px; text-align: center; }

        .form-group { margin-bottom: 24px; }
        .label { display: block; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-3); margin-bottom: 12px; }
        
        input[type="text"], input[type="number"], textarea, select {
            width: 100%; background: #fcfcfc; border: 1px solid var(--border); border-radius: var(--radius-md);
            padding: 16px 20px; color: var(--text-1); font-family: inherit; font-size: 1.05rem; outline: none; transition: all 0.2s;
        }
        input:focus, textarea:focus, select:focus { border-color: var(--accent); background: #fff; box-shadow: 0 0 0 4px var(--accent-light); }

        textarea { min-height: 140px; resize: vertical; }

        .btn-primary {
            display: inline-flex; align-items: center; justify-content: center; gap: 10px;
            padding: 14px 28px; border-radius: var(--radius-md);
            background: var(--accent); color: white;
            font-weight: 800; font-size: 1.15rem; text-decoration: none;
            transition: all 0.2s; border: none; cursor: pointer; width: 100%;
            margin-top: 20px;
        }
        .btn-primary:hover { background: #047857; transform: translateY(-1px); box-shadow: var(--shadow-md); }

        .error-msg { color: var(--red); font-size: 0.9rem; margin-top: 8px; font-weight: 600; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-title">Portal Konselor</div>
        <div class="sidebar-subtitle">Management Suite</div>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('counselor.dashboard') }}" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            Dashboard
        </a>
        <a href="{{ route('counselor.education.index') }}" class="nav-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
            Edukasi
        </a>
    </nav>
</aside>

<main class="main-wrapper">
    <header class="topbar">
        <div class="topbar-left">
            <a href="{{ route('counselor.education.challenges.index') }}" class="btn-back-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Batal & Kembali ke Daftar
            </a>
        </div>
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
        <div class="card">
            <h1 class="form-title">{{ isset($challenge) ? '📝 Edit Challenge' : '✨ Buat Challenge Baru' }}</h1>

            <form action="{{ isset($challenge) ? route('counselor.education.challenges.update', $challenge->id) : route('counselor.education.challenges.store') }}" method="POST">
                @csrf
                @if(isset($challenge)) @method('PUT') @endif

                <div class="form-group">
                    <label class="label">Judul Challenge</label>
                    <input type="text" name="title" value="{{ old('title', $challenge->title ?? '') }}" placeholder="Contoh: Kuis Manajemen Stres Dasar" required>
                    @error('title') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="label">Deskripsi / Aturan Kuis</label>
                    <textarea name="description" placeholder="Jelaskan tentang kuis ini dan apa yang akan didapatkan mahasiswa..." required>{{ old('description', $challenge->description ?? '') }}</textarea>
                    @error('description') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div class="form-group">
                        <label class="label">Total Pertanyaan</label>
                        <input type="number" name="total_questions" value="{{ old('total_questions', $challenge->total_questions ?? 10) }}" min="1" required>
                        @error('total_questions') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="label">Reward Point</label>
                        <input type="number" name="reward_point" value="{{ old('reward_point', $challenge->reward_point ?? 100) }}" min="0" required>
                        @error('reward_point') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="label">Status Publis</label>
                    <select name="status" required>
                        <option value="1" {{ old('status', $challenge->status ?? 1) == 1 ? 'selected' : '' }}>Aktif (Publis)</option>
                        <option value="0" {{ old('status', $challenge->status ?? 1) == 0 ? 'selected' : '' }}>Nonaktif (Draft)</option>
                    </select>
                </div>

                <button type="submit" class="btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    {{ isset($challenge) ? 'Simpan Perubahan' : 'Terbitkan Challenge' }}
                </button>
            </form>
        </div>
    </div>
</main>

</body>
</html>y>
</html>
