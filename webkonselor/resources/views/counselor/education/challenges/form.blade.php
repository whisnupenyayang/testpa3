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
            --bg-base:    #0d0f1a;
            --bg-card:    #131627;
            --bg-glass:   rgba(255,255,255,0.04);
            --border:     rgba(255,255,255,0.08);
            --accent:     #a78bfa;
            --accent-dim: rgba(167,139,250,0.15);
            --green:      #34d399;
            --text-1:     #f1f5f9;
            --text-2:     #94a3b8;
            --text-3:     #64748b;
            --red:        #f87171;
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
        .topbar-logo .dot { width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, var(--accent), #8b5cf6); display: flex; align-items: center; justify-content: center; font-size: 0.9rem; }

        .container { max-width: 800px; margin: 0 auto; padding: 40px 32px; }

        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 12px 24px; border-radius: var(--radius-md); font-size: 0.9rem; font-weight: 600;
            text-decoration: none; transition: 0.3s; cursor: pointer; border: none;
        }
        .btn-primary { background: var(--accent); color: #fff; width: 100%; margin-top: 10px; }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-back { background: var(--bg-glass); color: var(--text-2); border: 1px solid var(--border); padding: 8px 16px; font-size: 0.8rem; }
        .btn-back:hover { background: var(--accent-dim); color: var(--accent); border-color: rgba(167,139,250,0.3); }

        .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 32px; }
        .form-title { font-family: 'Outfit', sans-serif; font-size: 1.5rem; font-weight: 700; margin-bottom: 24px; text-align: center; }

        .form-group { margin-bottom: 20px; }
        .label { display: block; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-3); margin-bottom: 8px; }
        
        input[type="text"], input[type="number"], textarea, select {
            width: 100%; background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: var(--radius-md);
            padding: 12px 16px; color: var(--text-1); font-family: inherit; font-size: 0.95rem; outline: none; transition: 0.2s;
        }
        input:focus, textarea:focus, select:focus { border-color: var(--accent); background: rgba(255,255,255,0.05); }

        textarea { min-height: 120px; resize: vertical; }

        .error-msg { color: var(--red); font-size: 0.75rem; margin-top: 5px; font-weight: 500; }
    </style>
</head>
<body>

<header class="topbar">
    <a href="{{ route('counselor.dashboard') }}" class="topbar-logo">
        <div class="dot">🎓</div>
        WebKonselor
    </a>
    <a href="{{ route('counselor.education.challenges.index') }}" class="btn btn-back">Batal & Kembali</a>
</header>

<main class="container">
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

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
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

            <button type="submit" class="btn btn-primary">
                {{ isset($challenge) ? 'Simpan Perubahan' : 'Terbitkan Challenge' }}
            </button>
        </form>
    </div>
</main>

</body>
</html>
