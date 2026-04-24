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
        /* (keep existing root and base styles) */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-base:    #0d0f1a;
            --bg-card:    #131627;
            --bg-glass:   rgba(255,255,255,0.04);
            --border:     rgba(255,255,255,0.08);
            --accent:     #7c6ff7;
            --accent-dim: rgba(124,111,247,0.15);
            --green:      #34d399;
            --red:        #f87171;
            --text-1:     #f1f5f9;
            --text-2:     #94a3b8;
            --text-3:     #64748b;
            --radius-lg:  16px;
            --radius-md:  10px;
            --radius-sm:  6px;
        }

        body { font-family: 'Inter', sans-serif; background: var(--bg-base); color: var(--text-1); min-height: 100vh; }

        .topbar {
            position: sticky; top: 0; z-index: 50;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 40px; height: 72px;
            background: rgba(13,15,26,0.8); backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
        }
        .topbar-logo { display: flex; align-items: center; gap: 12px; font-weight: 700; font-size: 1.1rem; font-family: 'Outfit', sans-serif; color: #fff; text-decoration: none; }
        .topbar-logo .dot { width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, var(--accent), #a78bfa); display: flex; align-items: center; justify-content: center; font-size: 0.9rem; }

        .container { max-width: 800px; margin: 0 auto; padding: 40px 32px; }

        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 12px 24px; border-radius: var(--radius-md); font-size: 0.9rem; font-weight: 600;
            text-decoration: none; transition: 0.3s; cursor: pointer; border: none;
        }
        .btn-primary { background: var(--accent); color: #fff; width: 100%; margin-top: 10px; }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-back { background: var(--bg-glass); color: var(--text-2); border: 1px solid var(--border); padding: 8px 16px; font-size: 0.8rem; }
        .btn-back:hover { background: var(--accent-dim); color: var(--accent); border-color: rgba(124,111,247,0.3); }

        .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 32px; }
        .form-title { font-family: 'Outfit', sans-serif; font-size: 1.5rem; font-weight: 700; margin-bottom: 24px; text-align: center; }

        .form-group { margin-bottom: 24px; }
        .label { display: block; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-3); margin-bottom: 8px; }
        
        input[type="text"], input[type="number"], input[type="url"], input[type="file"], textarea, select {
            width: 100%; background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: var(--radius-md);
            padding: 12px 16px; color: var(--text-1); font-family: inherit; font-size: 0.95rem; outline: none; transition: 0.2s;
        }
        input:focus, textarea:focus, select:focus { border-color: var(--accent); background: rgba(255,255,255,0.05); }

        textarea { min-height: 120px; resize: vertical; }

        .error-msg { color: var(--red); font-size: 0.75rem; margin-top: 5px; font-weight: 500; }

        .input-dual { background: rgba(255,255,255,0.02); border: 1px dashed var(--border); border-radius: var(--radius-md); padding: 16px; margin-top: 4px; }
        .input-divider { text-align: center; font-size: 0.7rem; font-weight: 700; color: var(--text-3); margin: 12px 0; position: relative; }
        .input-divider::before, .input-divider::after { content: ''; position: absolute; top: 50%; width: 40%; height: 1px; background: var(--border); }
        .input-divider::before { left: 0; }
        .input-divider::after { right: 0; }

        .current-file { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; padding: 8px 12px; background: var(--accent-dim); border-radius: var(--radius-sm); border: 1px solid rgba(124,111,247,0.2); }
        .current-file span { font-size: 0.8rem; color: var(--text-1); font-weight: 500; }
        .current-file img { width: 40px; height: 40px; object-fit: cover; border-radius: 4px; }
    </style>
</head>
<body>

<header class="topbar">
    <a href="{{ route('counselor.dashboard') }}" class="topbar-logo">
        <div class="dot">🎓</div>
        WebKonselor
    </a>
    <a href="{{ route('counselor.education.modules.index') }}" class="btn btn-back">Batal & Kembali</a>
</header>

<main class="container">
    <div class="card">
        <h1 class="form-title">{{ isset($module) ? '📝 Edit Modul Pembelajaran' : '✨ Buat Modul Baru' }}</h1>

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
                                <span style="font-size: 1.2rem;">📄</span>
                                <span>File: {{ basename($module->content_url) }}</span>
                            @else
                                <span style="font-size: 1.2rem;">🔗</span>
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

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
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

            <button type="submit" class="btn btn-primary">
                {{ isset($module) ? 'Simpan Perubahan' : 'Terbitkan Modul' }}
            </button>
        </form>
    </div>
</main>

</body>
</html>
