<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manajemen Modul – WebKonselor</title>
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
        .sidebar-title { font-size: 1.3rem; font-weight: 700; color: #064e3b; margin-bottom: 4px; }
        .sidebar-subtitle { font-size: 0.75rem; font-weight: 500; color: var(--text-2); text-transform: uppercase; letter-spacing: 0.05em; }
        .sidebar-nav { display: flex; flex-direction: column; gap: 8px; }
        .nav-item { display: flex; align-items: center; gap: 16px; padding: 14px 20px; border-radius: var(--radius-md); text-decoration: none; color: var(--accent); font-weight: 500; font-size: 0.95rem; transition: all 0.2s; }
        .nav-item:hover { background: rgba(16, 185, 129, 0.1); }
        .nav-item.active { background: var(--accent-light); color: #064e3b; font-weight: 600; }
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
        .btn-back-link { display: flex; align-items: center; gap: 6px; color: var(--text-2); text-decoration: none; font-size: 0.85rem; font-weight: 500; transition: color 0.2s; padding: 8px 12px; border-radius: 8px; }
        .btn-back-link:hover { background: #f8fafc; color: var(--accent); }

        .user-profile { display: flex; align-items: center; gap: 12px; cursor: pointer; padding: 4px 8px; border-radius: 12px; transition: background 0.2s; }
        .user-profile:hover { background: #f8fafc; }
        .user-info { display: flex; flex-direction: column; align-items: flex-end; }
        .user-name { font-size: 0.88rem; font-weight: 700; color: var(--text-1); }
        .user-role { font-size: 0.65rem; font-weight: 700; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.05em; }
        .user-avatar { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; background: var(--border); border: 2px solid #f8fafc; }

        /* ── Layout ── */
        .container { max-width: 1200px; margin: 0 auto; width: 100%; padding: 32px; }

        .page-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; }
        .page-header h1 { font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 700; color: var(--text-1); }
        .page-header p { color: var(--text-3); font-size: 0.9rem; margin-top: 4px; }

        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 24px; border-radius: var(--radius-md);
            background: var(--accent); color: white;
            font-weight: 600; font-size: 0.9rem; text-decoration: none;
            transition: all 0.2s; border: none; cursor: pointer;
        }
        .btn-primary:hover { background: #047857; transform: translateY(-1px); }

        /* ── Table Styling ── */
        .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden; }
        .premium-table { width: 100%; border-collapse: collapse; text-align: left; }
        .premium-table th {
            padding: 16px 24px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;
            color: var(--text-3); border-bottom: 1px solid var(--border); background: #fafafa;
        }
        .premium-table td { padding: 20px 24px; font-size: 0.88rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        .premium-table tr:last-child td { border-bottom: none; }
        
        .badge-status { padding: 4px 12px; border-radius: 99px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
        .badge-active { background: var(--accent-light); color: var(--accent); }
        .badge-inactive { background: #f1f5f9; color: var(--text-3); }

        .actions { display: flex; gap: 8px; }
        .btn-icon {
            width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;
            border-radius: 8px; border: 1px solid var(--border); background: #fff;
            color: var(--text-2); transition: all 0.2s; text-decoration: none;
        }
        .btn-icon:hover { color: var(--accent); border-color: var(--accent); background: var(--accent-light); }
        .btn-icon.delete:hover { color: var(--red); border-color: var(--red); background: var(--red-dim); }

        .alert { padding: 16px 24px; border-radius: var(--radius-md); margin-bottom: 24px; font-size: 0.9rem; font-weight: 600; }
        .alert-success { background: var(--accent-light); border: 1px solid rgba(5, 150, 105, 0.2); color: var(--accent); }
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
            <a href="{{ route('counselor.education.index') }}" class="btn-back-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Kembali ke Menu Utama
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
        <div class="page-header">
            <div>
                <h1>📖 Manajemen Modul Belajar</h1>
                <p>Kelola dan terbitkan konten edukasi psikologi untuk membantu mahasiswa.</p>
            </div>
            <a href="{{ route('counselor.education.modules.create') }}" class="btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Tambah Modul
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>Modul</th>
                        <th style="width: 140px;">Status</th>
                        <th style="width: 100px;">Point</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($modules as $m)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 16px;">
                                @if($m->thumbnail)
                                    <img src="{{ Str::startsWith($m->thumbnail, 'modules/') ? Storage::url($m->thumbnail) : $m->thumbnail }}" 
                                         alt="{{ $m->title }}" 
                                         style="width: 54px; height: 54px; border-radius: 10px; object-fit: cover; border: 1px solid var(--border);">
                                @else
                                    <div style="width: 54px; height: 54px; border-radius: 10px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; border: 1px solid var(--border);">🖼️</div>
                                @endif
                                <div>
                                    <div style="font-weight: 600; color: var(--text-1); font-size: 1rem;">{{ $m->title }}</div>
                                    <div style="font-size: 0.8rem; color: var(--text-3); margin-top: 2px;">{{ Str::limit($m->description, 60) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-status {{ $m->status ? 'badge-active' : 'badge-inactive' }}">
                                {{ $m->status ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td style="font-family: 'Outfit', sans-serif; font-weight: 700; color: var(--accent);">{{ $m->reward_point }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('counselor.education.modules.edit', $m->id) }}" class="btn-icon" title="Edit">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </a>
                                <form action="{{ route('counselor.education.modules.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon delete" title="Hapus">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 64px; color: var(--text-3);">
                            <div style="font-size: 2.5rem; margin-bottom: 16px; opacity: 0.5;">📭</div>
                            <div style="font-size: 0.95rem; font-weight: 500;">Belum ada modul yang dibuat.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

</body>
</html>
