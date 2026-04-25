<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ isset($module) ? 'Edit Modul' : 'Tambah Modul' }} – WebKonselor</title>
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
            --accent-gradient: linear-gradient(135deg, #059669 0%, #10b981 100%);
            --text-1:     #1e293b;
            --text-2:     #475569;
            --text-3:     #94a3b8;
            --green:      #059669;
            --red:        #dc2626;
            --red-dim:    #fef2f2;
            --radius-lg:  24px;
            --radius-md:  12px;
            --radius-sm:  8px;
            --shadow-sm:  0 1px 3px rgba(0,0,0,0.05);
            --shadow-md:  0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
            --shadow-premium: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
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
        .sidebar-header::before { content: ''; display: block; width: 24px; height: 3px; background: #60a5fa; margin: 0 auto 12px auto; border-radius: 4px; }
        .sidebar-header::after { content: ''; display: block; width: 24px; height: 3px; background: #f472b6; margin: 24px auto 0 auto; border-radius: 4px; }
        .sidebar-title { font-size: 1.6rem; font-weight: 800; color: #064e3b; margin-bottom: 6px; font-family: 'Outfit', sans-serif; }
        .sidebar-subtitle { font-size: 0.85rem; font-weight: 700; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.1em; }
        .sidebar-nav { display: flex; flex-direction: column; gap: 8px; }
        .nav-item { display: flex; align-items: center; gap: 16px; padding: 16px 24px; border-radius: var(--radius-md); text-decoration: none; color: var(--text-2); font-weight: 600; font-size: 1.05rem; transition: all 0.2s; }
        .nav-item:hover { background: rgba(16, 185, 129, 0.05); color: var(--accent); }
        .nav-item.active { background: var(--accent-light); color: #064e3b; font-weight: 800; }
        .nav-item svg { width: 20px; height: 20px; flex-shrink: 0; opacity: 0.7; }
        .nav-item.active svg { opacity: 1; color: var(--accent); }

        /* ── Main Content Area ── */
        .main-wrapper { flex: 1; display: flex; flex-direction: column; min-width: 0; }

        /* ── Top Bar ── */
        .topbar {
            position: sticky; top: 0; z-index: 50;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 40px; height: 72px;
            background: rgba(248, 250, 252, 0.8); backdrop-filter: blur(12px);
        }
        .topbar-left { display: flex; align-items: center; gap: 16px; }
        .btn-back-link { display: flex; align-items: center; gap: 8px; color: var(--text-2); text-decoration: none; font-size: 1rem; font-weight: 700; transition: all 0.2s; padding: 12px 20px; border-radius: 99px; }
        .btn-back-link:hover { background: #f1f5f9; color: var(--text-1); }

        .user-profile { display: flex; align-items: center; gap: 14px; padding: 6px 16px; border-radius: 99px; background: #fff; border: 1px solid var(--border); cursor: pointer; transition: all 0.2s; }
        .user-profile:hover { border-color: var(--accent); background: #f8fafc; }
        .user-info { display: flex; flex-direction: column; align-items: flex-end; }
        .user-name { font-size: 1rem; font-weight: 700; color: var(--text-1); }
        .user-role { font-size: 0.8rem; font-weight: 700; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.05em; }
        .user-avatar { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid #f8fafc; background: var(--border); }

        /* ── Layout ── */
        .container { max-width: 850px; margin: 0 auto; width: 100%; padding: 48px 32px; }

        .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 56px 48px; box-shadow: var(--shadow-premium); position: relative; overflow: hidden; }
        .card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 6px; background: var(--accent-gradient); }

        .form-header { text-align: center; margin-bottom: 48px; }
        .form-icon { width: 64px; height: 64px; background: var(--accent-light); color: var(--accent); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 20px auto; transform: rotate(-5deg); }
        .form-title { font-family: 'Outfit', sans-serif; font-size: 2.5rem; font-weight: 800; color: var(--text-1); letter-spacing: -0.02em; }
        .form-subtitle { color: var(--text-3); font-size: 1.1rem; margin-top: 10px; font-weight: 600; }

        .form-group { margin-bottom: 32px; }
        .label { display: block; font-size: 0.85rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-3); margin-bottom: 12px; padding-left: 4px; }
        
        input[type="text"], input[type="number"], input[type="url"], input[type="file"], textarea, select {
            width: 100%; background: #f8fafc; border: 2px solid transparent; border-radius: var(--radius-md);
            padding: 18px 24px; color: var(--text-1); font-family: inherit; font-size: 1.1rem; outline: none; transition: all 0.2s;
        }
        input:focus, textarea:focus, select:focus { border-color: var(--accent-light); background: #fff; box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.05); }

        textarea { min-height: 160px; resize: vertical; line-height: 1.6; }

        .btn-primary {
            display: inline-flex; align-items: center; justify-content: center; gap: 12px;
            padding: 18px 36px; border-radius: var(--radius-md);
            background: var(--accent-gradient); color: white;
            font-weight: 800; font-size: 1.2rem; text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: none; cursor: pointer; width: 100%;
            margin-top: 24px; box-shadow: 0 4px 14px 0 rgba(5, 150, 105, 0.39);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(5, 150, 105, 0.45); opacity: 0.95; }
        .btn-primary:active { transform: translateY(0); }

        .error-msg { color: var(--red); font-size: 0.8rem; margin-top: 8px; font-weight: 600; display: flex; align-items: center; gap: 6px; }
        .error-msg::before { content: '⚠️'; font-size: 0.9rem; }

        /* Dual Input Styling */
        .input-dual { background: #f1f5f9; border-radius: var(--radius-md); padding: 24px; margin-top: 4px; }
        .input-divider { text-align: center; font-size: 0.7rem; font-weight: 900; color: var(--text-3); margin: 20px 0; position: relative; text-transform: uppercase; letter-spacing: 0.15em; }
        .input-divider::before, .input-divider::after { content: ''; position: absolute; top: 50%; width: 30%; height: 2px; background: var(--border); }
        .input-divider::before { left: 0; }
        .input-divider::after { right: 0; }

        .current-file { display: flex; align-items: center; gap: 16px; margin-bottom: 20px; padding: 16px; background: white; border-radius: var(--radius-md); border: 1px solid var(--border); box-shadow: var(--shadow-sm); }
        .current-file span { font-size: 0.9rem; color: var(--text-1); font-weight: 700; }
        .current-file img { width: 56px; height: 56px; object-fit: cover; border-radius: 10px; border: 1px solid var(--border); }

        input[type="file"] { padding: 12px; background: #fff; font-size: 0.9rem; }
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
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            Dashboard
        </a>
        <a href="{{ route('counselor.education.index') }}" class="nav-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
            Edukasi
        </a>
    </nav>
</aside>

<main class="main-wrapper">
    <header class="topbar">
        <div class="topbar-left">
            <a href="{{ route('counselor.education.modules.index') }}" class="btn-back-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Kembali ke Daftar Modul
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
            <div class="form-header">
                <div class="form-icon">📖</div>
                <h1 class="form-title">{{ isset($module) ? 'Edit Modul' : 'Buat Modul Baru' }}</h1>
                <p class="form-subtitle">Lengkapi detail materi edukasi untuk mahasiswa di bawah ini.</p>
            </div>

            <form action="{{ isset($module) ? route('counselor.education.modules.update', $module->id) : route('counselor.education.modules.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($module)) @method('PUT') @endif

                <div class="form-group">
                    <label class="label">Judul Modul</label>
                    <input type="text" name="title" value="{{ old('title', $module->title ?? '') }}" placeholder="Contoh: Teknik Grounding 5-4-3-2-1" required>
                    @error('title') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <!-- Thumbnail Dual Input -->
                <div class="form-group">
                    <label class="label">Gambar Sampul (Thumbnail)</label>
                    <div class="input-dual">
                        @if(isset($module) && $module->thumbnail)
                            <div class="current-file">
                                @if(Str::startsWith($module->thumbnail, 'modules/thumbnails'))
                                    <img src="{{ Storage::url($module->thumbnail) }}" alt="Current">
                                    <span>File: {{ basename($module->thumbnail) }}</span>
                                @else
                                    <img src="{{ $module->thumbnail }}" alt="Current">
                                    <span>URL Link Aktif</span>
                                @endif
                            </div>
                        @endif
                        
                        <input type="file" name="thumbnail_file" accept="image/*">
                        <div class="input-divider">ATAU MASUKKAN LINK</div>
                        <input type="url" name="thumbnail_url" value="{{ old('thumbnail_url', isset($module) && !Str::startsWith($module->thumbnail, 'modules/') ? $module->thumbnail : '') }}" placeholder="https://source.unsplash.com/...">
                    </div>
                    @error('thumbnail_file') <div class="error-msg">{{ $message }}</div> @enderror
                    @error('thumbnail_url') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="label">Deskripsi / Isi Singkat</label>
                    <textarea name="description" placeholder="Jelaskan isi modul ini..." required>{{ old('description', $module->description ?? '') }}</textarea>
                    @error('description') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <!-- Content Dual Input -->
                <div class="form-group">
                    <label class="label">Dokumen / Konten Utama</label>
                    <div class="input-dual">
                        @if(isset($module) && $module->content_url)
                            <div class="current-file">
                                @if(Str::startsWith($module->content_url, 'modules/content'))
                                    <span style="font-size: 1.5rem;">📄</span>
                                    <span>File: {{ basename($module->content_url) }}</span>
                                @else
                                    <span style="font-size: 1.5rem;">🔗</span>
                                    <span>Link Eksternal Aktif</span>
                                @endif
                            </div>
                        @endif

                        <input type="file" name="content_file" accept=".pdf">
                        <div class="input-divider">ATAU MASUKKAN LINK</div>
                        <input type="url" name="content_url" value="{{ old('content_url', isset($module) && !Str::startsWith($module->content_url, 'modules/') ? $module->content_url : '') }}" placeholder="https://youtube.com/... atau link artikel">
                    </div>
                    @error('content_file') <div class="error-msg">{{ $message }}</div> @enderror
                    @error('content_url') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div class="form-group">
                        <label class="label">Reward Point</label>
                        <input type="number" name="reward_point" value="{{ old('reward_point', $module->reward_point ?? 50) }}" min="0" required>
                        @error('reward_point') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="label">Status Publis</label>
                        <select name="status" required>
                            <option value="1" {{ old('status', $module->status ?? 1) == 1 ? 'selected' : '' }}>Aktif (Publis)</option>
                            <option value="0" {{ old('status', $module->status ?? 1) == 0 ? 'selected' : '' }}>Nonaktif (Draft)</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    {{ isset($module) ? 'Simpan Perubahan' : 'Terbitkan Modul' }}
                </button>
            </form>
        </div>
    </div>
</main>

</body>
</html>
