<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Sistem Peminjaman LAB' }}</title>
    <link rel="icon" type="image/jpeg" sizes="32x32" href="{{ asset('favicon-psti.jpg') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon-psti.jpg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f3f6fb;
            --surface: #ffffff;
            --surface-soft: #eef3ff;
            --text: #1f2937;
            --muted: #5b6473;
            --primary: #173f7a;
            --primary-strong: #102f5e;
            --accent: #e4ac2b;
            --accent-soft: #fff6dc;
            --danger: #b91c1c;
            --warning: #b45309;
            --ring: rgba(23, 63, 122, 0.2);
            --radius: 14px;
            --shadow: 0 10px 26px rgba(16, 47, 94, 0.1);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 100% -5%, #dbe9ff 0%, transparent 32%),
                radial-gradient(circle at 0% 100%, #e7eefb 0%, transparent 28%),
                var(--bg);
        }

        .container {
            width: min(1080px, calc(100% - 2rem));
            margin: 2rem auto 3rem;
        }

        .topbar {
            display: flex;
            flex-direction: column;
            gap: 0;
            margin-bottom: 1.25rem;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .contact-strip {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.75rem;
            padding: 0.48rem 1rem;
            background: linear-gradient(90deg, #0f2a52, #173f7a);
            color: #e5edfb;
            font-size: 0.84rem;
            font-weight: 600;
        }

        .site-head {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: space-between;
            align-items: center;
            background: var(--surface);
            border: 1px solid #d8e2f2;
            border-top: none;
            padding: 0.85rem 1rem;
        }

        .brand-wrap {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .brand {
            font-weight: 800;
            letter-spacing: 0.2px;
            color: var(--primary-strong);
        }

        .brand-sub {
            font-size: 0.83rem;
            color: var(--muted);
            font-weight: 600;
        }

        .tabs {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .tab {
            text-decoration: none;
            color: #2f3f59;
            background: var(--surface);
            border: 1px solid #d5dfef;
            padding: 0.5rem 0.9rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.92rem;
        }

        .tab.active {
            color: #fff;
            background: var(--primary);
            border-color: var(--primary);
        }

        .card {
            background: var(--surface);
            border: 1px solid #dce4f2;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 1.2rem;
        }

        h1, h2, h3 {
            margin-top: 0;
            line-height: 1.2;
        }

        .grid {
            display: grid;
            gap: 1rem;
        }

        .grid.cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .grid.cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .metric {
            background: linear-gradient(140deg, #f9fbff, #edf3ff);
            border: 1px solid #d5e0f6;
            border-radius: 12px;
            padding: 0.9rem;
        }

        .metric .label {
            color: var(--muted);
            font-size: 0.88rem;
            margin-bottom: 0.3rem;
        }

        .metric .value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-strong);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.5rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
            border: 1px solid transparent;
        }

        .badge.borrowed {
            background: #fffbeb;
            color: #92400e;
            border-color: #fcd34d;
        }

        .badge.overdue {
            background: #fef2f2;
            color: #991b1b;
            border-color: #fca5a5;
        }

        .badge.returned {
            background: #ecfdf3;
            color: #166534;
            border-color: #86efac;
        }

        .row {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            align-items: center;
        }

        input, select, textarea {
            width: 100%;
            background: #fff;
            border: 1px solid #cbd7ea;
            border-radius: 10px;
            padding: 0.62rem 0.74rem;
            font: inherit;
            color: var(--text);
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--ring);
        }

        label {
            display: block;
            font-size: 0.88rem;
            font-weight: 700;
            margin-bottom: 0.35rem;
            color: var(--muted);
        }

        .field { margin-bottom: 0.9rem; }

        .btn {
            border: none;
            border-radius: 10px;
            padding: 0.62rem 0.95rem;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-strong); }
        .btn-soft { background: var(--surface-soft); color: var(--text); border: 1px solid #d0dcf0; }
        .btn-danger { background: #fef2f2; color: var(--danger); border: 1px solid #fecaca; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0.8rem;
        }

        th, td {
            border-bottom: 1px solid #e4eaf5;
            text-align: left;
            padding: 0.65rem 0.5rem;
            vertical-align: top;
            font-size: 0.93rem;
        }

        th { color: var(--muted); font-size: 0.83rem; text-transform: uppercase; letter-spacing: 0.5px; }

        .flash {
            margin-bottom: 1rem;
            background: #f0f6ff;
            border: 1px solid #9ebbf0;
            color: #1f3b77;
            border-radius: 10px;
            padding: 0.7rem 0.8rem;
            font-weight: 600;
        }

        .errors {
            margin-bottom: 1rem;
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #7f1d1d;
            border-radius: 10px;
            padding: 0.7rem 0.8rem;
        }

        .errors ul { margin: 0.2rem 0 0; padding-left: 1rem; }

        .muted { color: var(--muted); }

        @media (max-width: 900px) {
            .grid.cols-3 { grid-template-columns: 1fr; }
            .grid.cols-2 { grid-template-columns: 1fr; }
            .container { width: min(1080px, calc(100% - 1rem)); }
            .contact-strip { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="topbar">
        <div class="contact-strip">
            <span>Program Studi Teknologi Informasi - Universitas 'Aisyiyah Yogyakarta</span>
            <span>teknologiinformasi@unisayogya.ac.id</span>
        </div>
        <div class="site-head">
            <div class="brand-wrap">
                <div class="brand">Sistem Peminjaman LAB</div>
                <div class="brand-sub">Selaras dengan layanan internal PSTI UNISA</div>
            </div>

            <nav class="tabs">
                <a class="tab {{ request()->routeIs('loan_requests.*') ? 'active' : '' }}" href="{{ route('loan_requests.create') }}">Form Peminjaman</a>
                @auth
                    @if (auth()->user()->is_admin)
                        <a class="tab {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                        <a class="tab {{ request()->routeIs('admin.loans.*') ? 'active' : '' }}" href="{{ route('admin.loans.index') }}">Data Peminjaman</a>
                        <a class="tab {{ request()->routeIs('admin.items.*') ? 'active' : '' }}" href="{{ route('admin.items.index') }}">Data Barang</a>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button class="tab" type="submit">Logout Admin</button>
                        </form>
                    @endif
                @else
                    <a class="tab {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login Admin</a>
                @endauth
            </nav>
        </div>
    </div>

    @if (session('status'))
        <div class="flash">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="errors">
            <strong>Periksa kembali input:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</div>
</body>
</html>
