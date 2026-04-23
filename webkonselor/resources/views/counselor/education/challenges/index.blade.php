<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manajemen Challenge – WebKonselor</title>
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
        .topbar-logo .dot { width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, var(--accent), #8b5cf6); display: flex; align-items: center; justify-content: center; font-size: 0.9rem; }

        .container { max-width: 1100px; margin: 0 auto; padding: 40px 32px; }

        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; flex-wrap: wrap; gap: 16px; }
        .page-header div h1 { font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 700; letter-spacing: -0.02em; }
        .page-header div p { color: var(--text-3); font-size: 0.9rem; margin-top: 4px; }

        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 20px; border-radius: var(--radius-md); font-size: 0.85rem; font-weight: 600;
            text-decoration: none; transition: 0.2s; cursor: pointer; border: none;
        }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-back { background: var(--bg-glass); color: var(--text-2); border: 1px solid var(--border); }
        .btn-back:hover { background: var(--accent-dim); color: var(--accent); border-color: rgba(167,139,250,0.3); }

        .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; }
        .table-wrap { width: 100%; overflow-x: auto; }
        table { width: 100%; border-collapse: separate; border-spacing: 0; }
        th { text-align: left; padding: 16px 24px; font-size: 0.73rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-3); border-bottom: 1px solid var(--border); background: rgba(255,255,255,0.01); }
        td { padding: 18px 24px; font-size: 0.9rem; border-bottom: 1px solid rgba(255,255,255,0.03); vertical-align: middle; }
        
        .badge-status { padding: 4px 10px; border-radius: 99px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
        .badge-active { background: rgba(52,211,153,0.1); color: var(--green); }
        .badge-inactive { background: rgba(248,113,113,0.1); color: var(--red); }

        .actions { display: flex; gap: 8px; }
        .btn-icon { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px; border: 1px solid var(--border); background: var(--bg-glass); color: var(--text-2); transition: 0.2s; text-decoration: none; }
        .btn-icon:hover { color: #fff; border-color: var(--text-2); }
        .btn-icon.edit:hover { color: #fbbf24; border-color: #fbbf24; }
        .btn-icon.delete:hover { color: var(--red); border-color: var(--red); }

        .alert { padding: 14px 20px; border-radius: var(--radius-md); margin-bottom: 24px; font-size: 0.88rem; font-weight: 500; }
        .alert-success { background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.2); color: var(--green); }
    </style>
</head>
<body>

<header class="topbar">
    <a href="{{ route('counselor.dashboard') }}" class="topbar-logo">
        <div class="dot">🎓</div>
        WebKonselor
    </a>
    <div style="display: flex; gap: 20px;">
        <a href="{{ route('counselor.education.index') }}" class="btn btn-back">← Kembali ke Menu</a>
    </div>
</header>

<main class="container">
    <div class="page-header">
        <div>
            <h1>🎮 Manajemen Challenge</h1>
            <p>Kelola kuis dan tantangan interaktif untuk mahasiswa.</p>
        </div>
        <a href="{{ route('counselor.education.challenges.create') }}" class="btn btn-primary">+ Tambah Challenge</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Challenge</th>
                        <th>Status</th>
                        <th>Soal</th>
                        <th>Reward</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($challenges as $c)
                    <tr>
                        <td>
                            <div style="font-weight: 600; color: var(--text-1);">{{ $c->title }}</div>
                            <div style="font-size: 0.77rem; color: var(--text-3); margin-top: 2px;">{{ Str::limit($c->description, 60) }}</div>
                        </td>
                        <td>
                            <span class="badge-status {{ $c->status ? 'badge-active' : 'badge-inactive' }}">
                                {{ $c->status ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td style="font-weight: 500;">{{ $c->total_questions }} Soal</td>
                        <td style="font-family: 'Outfit', sans-serif; font-weight: 600; color: var(--accent);">{{ $c->reward_point }} Pts</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('counselor.education.challenges.edit', $c->id) }}" class="btn-icon edit" title="Edit">
                                    ✏️
                                </a>
                                <form action="{{ route('counselor.education.challenges.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus challenge ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon delete" title="Hapus">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 60px; color: var(--text-3);">
                            Belum ada challenge yang dibuat.
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
