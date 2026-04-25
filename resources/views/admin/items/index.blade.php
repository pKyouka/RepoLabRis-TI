@extends('layouts.app', ['title' => 'Data Barang'])

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.dataTables.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <style>
        .items-page {
            position: relative;
            overflow: hidden;
            padding: 0.2rem;
        }

        .items-page::before,
        .items-page::after {
            content: '';
            position: absolute;
            inset: auto;
            width: 20rem;
            height: 20rem;
            border-radius: 50%;
            filter: blur(12px);
            opacity: 0.65;
            pointer-events: none;
        }

        .items-page::before {
            top: -9rem;
            right: -8rem;
            background: radial-gradient(circle, rgba(23, 63, 122, 0.18), transparent 70%);
        }

        .items-page::after {
            bottom: -10rem;
            left: -10rem;
            background: radial-gradient(circle, rgba(228, 172, 43, 0.16), transparent 70%);
        }

        .items-shell {
            position: relative;
            z-index: 1;
            display: grid;
            gap: 1rem;
        }

        .hero-panel {
            position: relative;
            overflow: hidden;
            padding: 1.5rem;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.45);
            background:
                linear-gradient(135deg, rgba(15, 42, 82, 0.97), rgba(23, 63, 122, 0.92) 52%, rgba(50, 99, 181, 0.88)),
                linear-gradient(135deg, #173f7a, #3263b5);
            box-shadow: 0 22px 50px rgba(16, 47, 94, 0.24);
            color: #edf4ff;
        }

        .hero-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, 0.22), transparent 34%),
                radial-gradient(circle at bottom left, rgba(228, 172, 43, 0.22), transparent 24%);
            pointer-events: none;
        }

        .hero-grid {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: minmax(0, 1.6fr) minmax(280px, 0.9fr);
            gap: 1rem;
            align-items: stretch;
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            width: fit-content;
            padding: 0.38rem 0.8rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .hero-title {
            margin: 0.85rem 0 0.65rem;
            font-family: 'Space Grotesk', 'Manrope', sans-serif;
            font-size: clamp(2rem, 4vw, 3.25rem);
            line-height: 0.98;
            letter-spacing: -0.04em;
        }

        .hero-copy {
            max-width: 54rem;
            margin: 0;
            color: rgba(237, 244, 255, 0.86);
            font-size: 1rem;
            line-height: 1.7;
        }

        .hero-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-top: 1.25rem;
        }

        .hero-visual {
            display: grid;
            gap: 0.8rem;
            align-content: space-between;
            min-height: 100%;
            padding: 1rem;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.16);
            backdrop-filter: blur(10px);
        }

        .hero-visual .mini-label {
            font-size: 0.82rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(237, 244, 255, 0.72);
        }

        .hero-visual .mini-value {
            font-family: 'Space Grotesk', 'Manrope', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.04em;
        }

        .hero-visual .mini-note {
            color: rgba(237, 244, 255, 0.8);
            line-height: 1.6;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
        }

        .stat-card {
            position: relative;
            overflow: hidden;
            padding: 1rem;
            border-radius: 18px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.94), rgba(244, 248, 255, 0.98));
            border: 1px solid #dbe4f3;
            box-shadow: 0 12px 30px rgba(16, 47, 94, 0.08);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            inset: auto -2rem -2rem auto;
            width: 7rem;
            height: 7rem;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(23, 63, 122, 0.08), transparent 68%);
        }

        .stat-label {
            margin-bottom: 0.45rem;
            color: var(--muted);
            font-size: 0.84rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .stat-value {
            font-family: 'Space Grotesk', 'Manrope', sans-serif;
            font-size: clamp(1.7rem, 3vw, 2.4rem);
            line-height: 1;
            font-weight: 700;
            color: var(--primary-strong);
            letter-spacing: -0.04em;
        }

        .stat-footnote {
            margin-top: 0.65rem;
            color: var(--muted);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .content-panel {
            padding: 1.45rem;
            border-radius: 28px;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.9), rgba(247, 250, 255, 0.92)),
                rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(214, 224, 241, 0.95);
            box-shadow:
                0 18px 42px rgba(16, 47, 94, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(10px);
        }

        .section-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .section-title {
            margin: 0;
            font-family: 'Space Grotesk', 'Manrope', sans-serif;
            font-size: 1.45rem;
            letter-spacing: -0.03em;
        }

        .section-subtitle {
            margin: 0.35rem 0 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .toolbar {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.5rem 0.8rem;
            border-radius: 999px;
            background: #f2f6ff;
            border: 1px solid #d8e2f4;
            color: var(--primary-strong);
            font-size: 0.9rem;
            font-weight: 700;
        }

        .chip::before {
            content: '';
            width: 0.45rem;
            height: 0.45rem;
            border-radius: 999px;
            background: #1d4ed8;
            box-shadow: 0 0 0 4px rgba(29, 78, 216, 0.14);
        }

        .table-shell {
            overflow: hidden;
            padding: 0.8rem;
            border-radius: 24px;
            border: 1px solid rgba(219, 228, 243, 0.92);
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.9), rgba(247, 250, 255, 0.98));
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.8),
                0 10px 26px rgba(16, 47, 94, 0.05);
        }

        .table-shell .table-wrap {
            overflow: hidden;
            border-radius: 18px;
            border: 1px solid rgba(223, 231, 244, 0.9);
            background: rgba(255, 255, 255, 0.92);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.75);
        }

        .items-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .items-table thead th {
            background: linear-gradient(180deg, #f6f9ff, #eef4ff);
            color: #294368;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.75rem;
            padding: 0.95rem 1rem;
            border-bottom: 1px solid #dbe4f3;
            white-space: nowrap;
        }

        .items-table tbody td {
            padding: 1rem;
            border-bottom: 1px solid #edf2fa;
            vertical-align: top;
        }

        .items-table tbody tr:hover {
            background: rgba(239, 244, 255, 0.72);
        }

        .items-table tbody tr:last-child td {
            border-bottom: none;
        }

        .item-name {
            font-weight: 800;
            color: var(--primary-strong);
            margin-bottom: 0.25rem;
        }

        .item-meta {
            color: var(--muted);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .code-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.32rem 0.62rem;
            border-radius: 999px;
            background: #f2f6ff;
            color: #27406a;
            border: 1px solid #d8e2f4;
            font-size: 0.84rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .stock-stack {
            display: grid;
            gap: 0.35rem;
            min-width: 10rem;
        }

        .stock-bar {
            position: relative;
            height: 0.5rem;
            overflow: hidden;
            border-radius: 999px;
            background: #e8eef8;
        }

        .stock-bar span {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #1d4ed8, #4f8cff);
        }

        .stock-stack.low .stock-bar span {
            background: linear-gradient(90deg, #f59e0b, #fbbf24);
        }

        .stock-stack.empty .stock-bar span {
            background: linear-gradient(90deg, #ef4444, #f87171);
        }

        .stock-stack .stock-text {
            font-size: 0.88rem;
            color: var(--muted);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.7rem;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 800;
            letter-spacing: 0.03em;
            border: 1px solid transparent;
            white-space: nowrap;
        }

        .status-badge::before {
            content: '';
            width: 0.45rem;
            height: 0.45rem;
            border-radius: 999px;
            background: currentColor;
            opacity: 0.9;
        }

        .status-badge.active {
            color: #166534;
            background: #ecfdf3;
            border-color: #bbf7d0;
        }

        .status-badge.inactive {
            color: #9f1239;
            background: #fff1f2;
            border-color: #fecdd3;
        }

        .status-badge.warning {
            color: #92400e;
            background: #fffbeb;
            border-color: #fde68a;
        }

        .actions-cell .row {
            gap: 0.5rem;
        }

        .actions-cell .btn {
            min-width: 5rem;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            width: auto;
            min-width: 96px;
            min-height: 2.5rem;
            border: 1px solid #cbd7ea;
            border-radius: 999px;
            padding: 0.55rem 0.9rem;
            font: inherit;
            color: var(--text);
            background: #fff;
            box-shadow: 0 8px 20px rgba(16, 47, 94, 0.06);
        }

        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.2rem 0.25rem;
            line-height: 1;
            white-space: nowrap;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info {
            color: var(--muted);
            font-weight: 600;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin: 0;
        }

        .dataTables_wrapper .dt-controls {
            display: flex;
            gap: 1rem;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            margin-bottom: 1rem;
            padding: 0.8rem 0.9rem;
            border-radius: 18px;
            background: linear-gradient(180deg, rgba(246, 249, 255, 0.98), rgba(255, 255, 255, 0.98));
            border: 1px solid rgba(223, 231, 244, 0.95);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.85);
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 0;
        }

        .dataTables_wrapper .dt-footer {
            display: flex;
            gap: 1rem;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 1rem;
            padding: 0.9rem 1rem;
            border: 1px solid #e4ebf7;
            border-radius: 18px;
            background: linear-gradient(180deg, rgba(246, 249, 255, 0.95), rgba(255, 255, 255, 0.95));
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9);
        }

        .dataTables_wrapper .dt-footer .dataTables_info,
        .dataTables_wrapper .dt-footer .dataTables_paginate {
            padding-top: 0;
            border-top: 0;
        }

        .dataTables_wrapper .dt-footer .dataTables_info {
            padding-left: 0.15rem;
        }

        .dataTables_wrapper .dataTables_paginate {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.35rem;
        }

        .dataTables_wrapper .dataTables_info {
            float: none;
            padding-top: 0;
        }

        .dataTables_wrapper .dataTables_paginate {
            float: none;
            text-align: right;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            min-width: 2.35rem;
            min-height: 2.35rem;
            margin: 0 0.08rem;
            padding: 0.42rem 0.8rem !important;
            border-radius: 999px !important;
            border: 1px solid #d5dfef !important;
            background: #fff !important;
            color: var(--text) !important;
            box-shadow: 0 6px 16px rgba(16, 47, 94, 0.04);
            line-height: 1;
            cursor: pointer;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--primary) !important;
            border-color: var(--primary) !important;
            color: #fff !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--surface-soft) !important;
            border-color: #d0dcf0 !important;
            color: var(--primary-strong) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
        .dataTables_wrapper .dataTables_paginate .paginate_button.next,
        .dataTables_wrapper .dataTables_paginate .paginate_button.first,
        .dataTables_wrapper .dataTables_paginate .paginate_button.last {
            padding-inline: 0.9rem !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            opacity: 0.45 !important;
            background: #f8fafc !important;
            border-color: #e2e8f0 !important;
            color: #94a3b8 !important;
            box-shadow: none;
            cursor: not-allowed;
        }

        @media (max-width: 1024px) {
            .hero-grid,
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 720px) {
            .hero-grid,
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .content-panel,
            .hero-panel {
                padding: 1rem;
                border-radius: 20px;
            }

            .table-shell {
                padding: 0.55rem;
            }

            .hero-actions,
            .toolbar {
                width: 100%;
            }

            .hero-actions .btn,
            .toolbar .btn,
            .toolbar .chip {
                width: 100%;
                justify-content: center;
            }

            .actions-cell .row {
                flex-direction: column;
                align-items: stretch;
            }

            .actions-cell .btn {
                width: 100%;
            }

            .dataTables_wrapper .dt-controls,
            .dataTables_wrapper .dt-footer {
                gap: 0.75rem;
            }

            .dataTables_wrapper .dt-footer {
                padding: 0.8rem;
            }

            .dataTables_wrapper .dataTables_paginate {
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $totalItems = $items->count();
        $activeItems = $items->where('is_active', true)->count();
        $inactiveItems = $totalItems - $activeItems;
        $totalStock = $items->sum('total_stock');
        $availableStock = $items->sum('available_stock');
        $lowStockItems = $items->filter(function ($item) {
            return $item->total_stock > 0 && $item->available_stock <= max(1, (int) ceil($item->total_stock * 0.2));
        })->count();
    @endphp

    <div class="items-page">
        <div class="items-shell">
            <div class="hero-panel">
                <div class="hero-grid">
                    <div>
                        <div class="hero-kicker">Inventory Command Center</div>
                        <h1 class="hero-title">Data Barang LAB yang terasa seperti panel kontrol modern.</h1>
                        <p class="hero-copy">
                            Kelola stok, status, dan ketersediaan barang dengan tampilan yang lebih tegas, futuristik, dan mudah dipindai.
                            Semua elemen di halaman ini disusun untuk memberi kesan premium tanpa mengorbankan kecepatan kerja.
                        </p>

                        <div class="hero-actions">
                            <a class="btn btn-primary" href="{{ route('admin.items.create') }}">Tambah Barang</a>
                            <div class="chip">{{ $activeItems }} aktif dari {{ $totalItems }} item</div>
                        </div>
                    </div>

                    <div class="hero-visual">
                        <div>
                            <div class="mini-label">Kondisi stok saat ini</div>
                            <div class="mini-value">{{ $availableStock }}</div>
                        </div>
                        <div class="mini-note">
                            Total {{ $totalStock }} unit tercatat, dengan {{ $lowStockItems }} item masuk zona stok rendah.
                            Ini memberi sinyal cepat untuk prioritas pengadaan.
                        </div>
                    </div>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Total Jenis Barang</div>
                    <div class="stat-value">{{ $totalItems }}</div>
                    <div class="stat-footnote">Seluruh item yang tersimpan di katalog admin.</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Barang Aktif</div>
                    <div class="stat-value">{{ $activeItems }}</div>
                    <div class="stat-footnote">Siap dipinjam dan bisa muncul di alur peminjaman.</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Stok Tersedia</div>
                    <div class="stat-value">{{ $availableStock }}</div>
                    <div class="stat-footnote">Unit yang bisa langsung digunakan hari ini.</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Stok Rendah</div>
                    <div class="stat-value">{{ $lowStockItems }}</div>
                    <div class="stat-footnote">Item yang sudah mendekati batas minimum aman.</div>
                </div>
            </div>

            <div class="content-panel">
                <div class="section-head">
                    <div>
                        <h2 class="section-title">Daftar Barang LAB</h2>
                        <p class="section-subtitle">Cari, urutkan, dan kelola data dengan tampilan yang lebih tajam dan premium.</p>
                    </div>

                    <div class="toolbar">
                        <div class="chip">{{ $inactiveItems }} nonaktif</div>
                        <a class="btn btn-soft" href="{{ route('admin.items.create') }}">Tambah cepat</a>
                    </div>
                </div>

                <div class="table-shell">
                    <div class="table-wrap">
                        <table id="itemsTable" class="items-table">
                            <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kode</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Kondisi</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($items as $item)
                                @php
                                    $availabilityRatio = $item->total_stock > 0 ? ($item->available_stock / $item->total_stock) : 0;
                                    $stockClass = $item->available_stock <= 0
                                        ? 'empty'
                                        : ($availabilityRatio <= 0.2 ? 'low' : 'healthy');
                                @endphp
                                <tr>
                                    <td>
                                        <div class="item-name">{{ $item->name }}</div>
                                        <div class="item-meta">{{ $item->description ?: 'Tidak ada deskripsi.' }}</div>
                                    </td>
                                    <td>
                                        <span class="code-pill">{{ $item->code ?: '—' }}</span>
                                    </td>
                                    <td>
                                        <div class="stock-stack {{ $stockClass }}">
                                            <strong>{{ $item->available_stock }} / {{ $item->total_stock }}</strong>
                                            <div class="stock-bar"><span style="width: {{ max(0, min(100, round($availabilityRatio * 100))) }}%"></span></div>
                                            <div class="stock-text">Tersedia dari total stok</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $item->is_active ? 'active' : 'inactive' }}">{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                    </td>
                                    <td>
                                        @if ($item->available_stock <= 0)
                                            <span class="status-badge inactive">Habis</span>
                                        @elseif ($availabilityRatio <= 0.2)
                                            <span class="status-badge warning">Perlu Restock</span>
                                        @else
                                            <span class="status-badge active">Sehat</span>
                                        @endif
                                    </td>
                                    <td class="actions-cell">
                                        <div class="row" style="justify-content: flex-start;">
                                            <a class="btn btn-soft" href="{{ route('admin.items.edit', $item) }}">Edit</a>
                                            <form method="POST" action="{{ route('admin.items.destroy', $item) }}" onsubmit="return confirm('Hapus barang ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="muted" style="padding: 1.5rem; text-align: center;">Belum ada data barang.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script>
        $(function () {
            $('#itemsTable').DataTable({
                pageLength: 15,
                dom: '<"dt-controls"lf>rt<"dt-footer"ip>',
                pagingType: 'simple_numbers',
                order: [[0, 'asc']],
                columnDefs: [
                    { orderable: false, searchable: false, targets: -1 }
                ],
                language: {
                    decimal: '',
                    emptyTable: 'Belum ada data barang.',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Menampilkan 0 sampai 0 dari 0 data',
                    infoFiltered: '(difilter dari _MAX_ total data)',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    loadingRecords: 'Memuat...',
                    processing: 'Memproses...',
                    search: 'Cari:',
                    zeroRecords: 'Data tidak ditemukan',
                    paginate: {
                        first: 'Pertama',
                        last: 'Terakhir',
                        next: 'Berikutnya',
                        previous: 'Sebelumnya'
                    }
                }
            });
        });
    </script>
@endpush
