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
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #edf2fb;
            --bg-strong: #e2eaf8;
            --surface: rgba(255, 255, 255, 0.88);
            --surface-solid: #ffffff;
            --surface-soft: #edf4ff;
            --surface-strong: #dfe9fb;
            --text: #172233;
            --muted: #62708a;
            --primary: #173f7a;
            --primary-strong: #0f2a52;
            --accent: #e4ac2b;
            --accent-strong: #c58612;
            --accent-soft: #fff5d7;
            --success: #166534;
            --warning: #92400e;
            --danger: #b91c1c;
            --ring: rgba(23, 63, 122, 0.22);
            --radius: 18px;
            --radius-lg: 24px;
            --shadow: 0 18px 42px rgba(16, 47, 94, 0.12);
            --shadow-lg: 0 28px 60px rgba(16, 47, 94, 0.16);
        }

        * { box-sizing: border-box; }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 100% -5%, rgba(219, 233, 255, 0.95) 0%, transparent 30%),
                radial-gradient(circle at 0% 100%, rgba(231, 238, 251, 0.95) 0%, transparent 26%),
                linear-gradient(180deg, var(--bg) 0%, var(--bg-strong) 100%);
            min-height: 100vh;
        }

        .container {
            position: relative;
            width: min(1180px, calc(100% - 2rem));
            margin: 1.5rem auto 2.5rem;
        }

        .container::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(255,255,255,0.22) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.22) 1px, transparent 1px);
            background-size: 42px 42px;
            opacity: 0.18;
            mask-image: linear-gradient(180deg, rgba(0,0,0,0.65), rgba(0,0,0,0.1));
        }

        .topbar {
            display: flex;
            flex-direction: column;
            gap: 0;
            margin-bottom: 1rem;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            backdrop-filter: blur(14px);
        }

        .contact-strip {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 1rem;
            background: linear-gradient(135deg, #091a33, #173f7a 55%, #2f5cad);
            color: #e5edfb;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .site-head {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: space-between;
            align-items: center;
            background: var(--surface);
            border: 1px solid rgba(216, 226, 242, 0.95);
            border-top: none;
            padding: 0.95rem 1rem;
            backdrop-filter: blur(14px);
        }

        .brand-wrap {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .brand {
            font-family: 'Space Grotesk', 'Manrope', sans-serif;
            font-weight: 800;
            letter-spacing: 0.02em;
            color: var(--primary-strong);
            font-size: 1.08rem;
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
            color: #31435f;
            background: rgba(255, 255, 255, 0.86);
            border: 1px solid #d5dfef;
            padding: 0.52rem 0.95rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.9rem;
            transition: transform 140ms ease, box-shadow 140ms ease, background 140ms ease, color 140ms ease;
        }

        .tab.active {
            color: #fff;
            background: var(--primary);
            border-color: var(--primary);
            box-shadow: 0 12px 22px rgba(23, 63, 122, 0.18);
        }

        .tab:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(16, 47, 94, 0.08);
        }

        .card {
            background: linear-gradient(180deg, rgba(255,255,255,0.94), rgba(248,251,255,0.9));
            border: 1px solid rgba(220, 228, 242, 0.95);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            padding: 1.25rem;
            backdrop-filter: blur(12px);
        }

        h1, h2, h3 {
            margin-top: 0;
            line-height: 1.2;
            font-family: 'Space Grotesk', 'Manrope', sans-serif;
            letter-spacing: -0.03em;
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
            position: relative;
            overflow: hidden;
            background: linear-gradient(140deg, rgba(249,251,255,0.96), rgba(233,241,255,0.96));
            border: 1px solid #d5e0f6;
            border-radius: 18px;
            padding: 1rem;
            box-shadow: 0 12px 28px rgba(16, 47, 94, 0.06);
        }

        .metric::after {
            content: '';
            position: absolute;
            inset: auto -1.5rem -1.5rem auto;
            width: 6rem;
            height: 6rem;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(23,63,122,0.08), transparent 68%);
        }

        .metric .label {
            color: var(--muted);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 800;
            margin-bottom: 0.3rem;
        }

        .metric .value {
            font-family: 'Space Grotesk', 'Manrope', sans-serif;
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary-strong);
            letter-spacing: -0.03em;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.3rem 0.65rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            border: 1px solid transparent;
            letter-spacing: 0.03em;
            white-space: nowrap;
        }

        .badge::before {
            content: '';
            width: 0.4rem;
            height: 0.4rem;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.85;
        }

        .badge.borrowed {
            background: #fffbeb;
            color: #92400e;
            border-color: #fcd34d;
        }

        .badge.pending {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #93c5fd;
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

        .badge.rejected {
            background: #fff1f2;
            color: #be123c;
            border-color: #fda4af;
        }

        .badge.info {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        .badge.success,
        .badge.completed {
            background: #ecfdf3;
            color: #166534;
            border-color: #bbf7d0;
        }

        .badge.warning {
            background: #fffbeb;
            color: #92400e;
            border-color: #fde68a;
        }

        .badge.default {
            background: #f8fafc;
            color: #334155;
            border-color: #cbd5e1;
        }

        .row {
            display: flex;
            gap: 0.65rem;
            flex-wrap: wrap;
            align-items: center;
        }

        input, select, textarea {
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid #cbd7ea;
            border-radius: 14px;
            padding: 0.72rem 0.84rem;
            font: inherit;
            color: var(--text);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.4);
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--ring), 0 10px 24px rgba(16,47,94,0.08);
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
            border-radius: 14px;
            padding: 0.72rem 1rem;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            transition: transform 140ms ease, box-shadow 140ms ease, background 140ms ease, border-color 140ms ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), #214f97);
            color: #fff;
            box-shadow: 0 12px 24px rgba(23, 63, 122, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-strong), #173f7a);
            box-shadow: 0 16px 30px rgba(23, 63, 122, 0.24);
        }

        .btn-soft {
            background: rgba(237, 244, 255, 0.92);
            color: var(--text);
            border: 1px solid #d0dcf0;
            box-shadow: 0 8px 18px rgba(16, 47, 94, 0.05);
        }

        .btn-soft:hover {
            background: #e7f0ff;
        }

        .btn-danger {
            background: #fff1f2;
            color: var(--danger);
            border: 1px solid #fecaca;
        }

        .btn-danger:hover {
            background: #ffe4e6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0.8rem;
            background: transparent;
        }

        th, td {
            border-bottom: 1px solid #e4eaf5;
            text-align: left;
            padding: 0.65rem 0.5rem;
            vertical-align: top;
            font-size: 0.93rem;
        }

        th {
            color: var(--muted);
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 800;
        }

        thead th {
            position: sticky;
            top: 0;
            background: linear-gradient(180deg, rgba(247, 250, 255, 0.98), rgba(239, 244, 255, 0.98));
            z-index: 1;
        }

        tr:hover td {
            background: rgba(239, 244, 255, 0.52);
        }

        .flash {
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #eff6ff, #e0ebff);
            border: 1px solid #9ebbf0;
            color: #1f3b77;
            border-radius: 14px;
            padding: 0.8rem 0.95rem;
            font-weight: 600;
            box-shadow: 0 10px 24px rgba(16, 47, 94, 0.08);
        }

        .errors {
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #fff1f2, #ffe4e6);
            border: 1px solid #fca5a5;
            color: #7f1d1d;
            border-radius: 14px;
            padding: 0.8rem 0.95rem;
            box-shadow: 0 10px 24px rgba(153, 27, 27, 0.08);
        }

        .errors ul { margin: 0.2rem 0 0; padding-left: 1rem; }

        .muted { color: var(--muted); }

        .page-hero {
            position: relative;
            overflow: hidden;
            margin-bottom: 1rem;
            padding: 1.2rem 1.25rem;
            border-radius: var(--radius-lg);
            background:
                radial-gradient(circle at top right, rgba(228, 172, 43, 0.18), transparent 26%),
                linear-gradient(135deg, rgba(15, 42, 82, 0.98), rgba(23, 63, 122, 0.94));
            color: #edf4ff;
            box-shadow: var(--shadow-lg);
        }

        .page-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.14), transparent 60%);
            pointer-events: none;
        }

        .page-hero .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.32rem 0.7rem;
            border-radius: 999px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.15);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.78rem;
            font-weight: 800;
        }

        .page-hero h1,
        .page-hero h2,
        .page-hero h3 {
            margin-bottom: 0.35rem;
        }

        .page-hero .page-copy {
            margin: 0;
            max-width: 68ch;
            color: rgba(237, 244, 255, 0.84);
            line-height: 1.65;
        }

        .panel {
            position: relative;
            overflow: hidden;
            background: var(--surface);
            border: 1px solid rgba(220, 228, 242, 0.95);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            padding: 1.15rem;
            backdrop-filter: blur(12px);
        }

        .panel-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .panel-title {
            margin: 0;
            font-family: 'Space Grotesk', 'Manrope', sans-serif;
            font-size: 1.35rem;
            letter-spacing: -0.03em;
        }

        .panel-subtitle {
            margin: 0.3rem 0 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
        }

        .kpi-card {
            position: relative;
            overflow: hidden;
            padding: 1rem;
            border-radius: 18px;
            background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(240,246,255,0.95));
            border: 1px solid #dbe4f3;
            box-shadow: 0 12px 26px rgba(16, 47, 94, 0.08);
        }

        .kpi-card::after {
            content: '';
            position: absolute;
            inset: auto -1rem -1rem auto;
            width: 5rem;
            height: 5rem;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(23,63,122,0.08), transparent 68%);
        }

        .kpi-card .kpi-label {
            color: var(--muted);
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.25rem;
        }

        .kpi-card .kpi-value {
            font-family: 'Space Grotesk', 'Manrope', sans-serif;
            font-size: 1.9rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: var(--primary-strong);
        }

        .surface-soft {
            background: rgba(237, 244, 255, 0.88);
            border: 1px solid #d6e2f5;
            border-radius: 16px;
            padding: 0.95rem;
        }

        .empty-state {
            padding: 1rem;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(239,244,255,0.98));
            border: 1px dashed #c8d6ee;
            color: var(--muted);
        }

        @media (max-width: 900px) {
            .grid.cols-3 { grid-template-columns: 1fr; }
            .grid.cols-2 { grid-template-columns: 1fr; }
            .kpi-grid { grid-template-columns: 1fr; }
            .container { width: min(1180px, calc(100% - 1rem)); }
            .contact-strip { flex-direction: column; align-items: flex-start; }
            .site-head { padding: 0.9rem; }
            .tabs { width: 100%; }
            .tab { width: 100%; text-align: center; justify-content: center; }
            .page-hero { padding: 1rem; }
        }
    </style>
    @stack('styles')
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
@stack('scripts')
</body>
</html>
