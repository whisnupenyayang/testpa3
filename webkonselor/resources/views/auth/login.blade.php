<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Campus Care</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #f0f4f8;
            overflow: hidden;
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            width: 55%;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            overflow: hidden;
        }

        .left-panel img.bg-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        /* Gradient overlay */
        .left-panel::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(6, 78, 59, 0.35) 0%,
                rgba(6, 78, 59, 0.80) 100%
            );
            z-index: 1;
        }

        .left-content {
            position: relative;
            z-index: 2;
            padding: 48px;
            color: white;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 40px;
        }

        .brand-logo img {
            width: 52px;
            height: 52px;
            object-fit: contain;
            filter: drop-shadow(0 2px 8px rgba(0,0,0,0.3));
        }

        .brand-logo .brand-text h1 {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.3px;
            line-height: 1.2;
        }

        .brand-logo .brand-text p {
            font-size: 12px;
            font-weight: 300;
            opacity: 0.85;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .left-tagline h2 {
            font-size: 36px;
            font-weight: 700;
            line-height: 1.25;
            margin-bottom: 16px;
            text-shadow: 0 2px 12px rgba(0,0,0,0.2);
        }

        .left-tagline p {
            font-size: 15px;
            font-weight: 300;
            opacity: 0.88;
            line-height: 1.7;
            max-width: 380px;
        }

        .features-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 32px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            opacity: 0.9;
        }

        .feature-item .icon-wrap {
            width: 32px;
            height: 32px;
            background: rgba(255,255,255,0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
            flex-shrink: 0;
        }

        /* ── RIGHT PANEL ── */
        .right-panel {
            width: 45%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            background: #ffffff;
            position: relative;
        }

        .right-panel::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(95, 175, 159, 0.12) 0%, transparent 70%);
            border-radius: 50%;
        }

        .right-panel::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(6, 78, 59, 0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 1;
        }

        .login-header {
            margin-bottom: 36px;
        }

        .login-header .welcome-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(95, 175, 159, 0.12);
            color: #5FAF9F;
            font-size: 12px;
            font-weight: 600;
            padding: 5px 14px;
            border-radius: 100px;
            margin-bottom: 16px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .login-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
            margin-bottom: 8px;
        }

        .login-header p {
            font-size: 14px;
            color: #64748b;
            line-height: 1.6;
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 15px;
            transition: color 0.2s;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            color: #0f172a;
            background: #fafafa;
            transition: all 0.2s ease;
            outline: none;
        }

        .input-wrapper input:focus {
            border-color: #5FAF9F;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(95, 175, 159, 0.12);
        }

        .input-wrapper input:focus + i,
        .input-wrapper:has(input:focus) i {
            color: #5FAF9F;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            cursor: pointer;
            font-size: 15px;
            transition: color 0.2s;
            background: none;
            border: none;
            padding: 0;
        }

        .toggle-password:hover { color: #5FAF9F; }

        /* Error */
        .error-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            font-size: 13px;
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        /* Hint */
        .input-hint {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 6px;
        }

        /* Submit */
        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #5FAF9F 0%, #064E3B 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 8px;
            letter-spacing: 0.3px;
            box-shadow: 0 4px 15px rgba(95, 175, 159, 0.35);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(95, 175, 159, 0.45);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0 20px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            font-size: 12px;
            color: #94a3b8;
            white-space: nowrap;
        }

        /* Info box */
        .info-box {
            background: linear-gradient(135deg, rgba(95, 175, 159, 0.08), rgba(6, 78, 59, 0.05));
            border: 1px solid rgba(95, 175, 159, 0.25);
            border-radius: 12px;
            padding: 14px 16px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .info-box i {
            color: #5FAF9F;
            font-size: 15px;
            margin-top: 1px;
            flex-shrink: 0;
        }

        .info-box p {
            font-size: 12.5px;
            color: #475569;
            line-height: 1.6;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 28px;
            font-size: 12px;
            color: #94a3b8;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; padding: 32px 24px; }
        }
    </style>
</head>

<body>

    <!-- ── LEFT PANEL ── -->
    <div class="left-panel">
        <img class="bg-img" src="{{ asset('img/bg.png') }}" alt="Background">

        <div class="left-content">
            <!-- Brand -->
            <div class="brand-logo">
                <img src="{{ asset('img/logo.png') }}" alt="Logo Campus Care">
                <div class="brand-text">
                    <h1>Campus Care</h1>
                    <p>IT Del · Mental Health</p>
                </div>
            </div>

            <!-- Tagline -->
            <div class="left-tagline">
                <h2>Platform Konseling<br>Digital Terpadu</h2>
                <p>Layanan bimbingan dan konseling berbasis data untuk mendukung kesehatan mental mahasiswa Institut Teknologi Del.</p>
            </div>

            <!-- Features -->
            <div class="features-list">
                <div class="feature-item">
                    <div class="icon-wrap">
                        <i class="fa-solid fa-shield-heart" style="color:white; font-size:13px;"></i>
                    </div>
                    <span>Privasi & kerahasiaan terjaga</span>
                </div>
                <div class="feature-item">
                    <div class="icon-wrap">
                        <i class="fa-solid fa-brain" style="color:white; font-size:13px;"></i>
                    </div>
                    <span>Analisis AI untuk deteksi dini</span>
                </div>
                <div class="feature-item">
                    <div class="icon-wrap">
                        <i class="fa-solid fa-calendar-check" style="color:white; font-size:13px;"></i>
                    </div>
                    <span>Jadwal konseling fleksibel</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ── RIGHT PANEL ── -->
    <div class="right-panel">
        <div class="login-box">

            <!-- Header -->
            <div class="login-header">
                <div class="welcome-badge">
                    <i class="fa-solid fa-circle-dot" style="font-size:8px;"></i>
                    Selamat Datang
                </div>
                <h2>Masuk ke Akun Anda</h2>
                <p>Gunakan kredensial CIS Institut Teknologi Del untuk mengakses platform.</p>
            </div>

            <!-- Error -->
            @if ($errors->any())
                <div class="error-alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="form-group">
                    <label for="username">Username CIS</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user"></i>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="contoh: johannes / if420086"
                            autocomplete="username"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password CIS Anda"
                            autocomplete="current-password"
                        >
                        <button type="button" class="toggle-password" onclick="togglePassword()" id="toggleBtn">
                            <i class="fa-solid fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    Masuk Sekarang
                </button>
            </form>

            <div class="divider">
                <span>Informasi Akun</span>
            </div>

            <div class="info-box">
                <i class="fa-solid fa-circle-info"></i>
                <p>Gunakan <strong>username</strong> dan <strong>password</strong> CIS (Campus Information System) yang sama dengan portal akademik IT Del.</p>
            </div>

            <div class="login-footer">
                &copy; {{ date('Y') }} Campus Care · Institut Teknologi Del
            </div>

        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>

</body>
</html>