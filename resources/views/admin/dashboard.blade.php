@extends('layouts.app', ['title' => 'Dashboard Admin'])

@section('content')
    <div class="card" style="margin-bottom: 1rem;">
        <h1>Dashboard Pengelola LAB</h1>
        <p class="muted">Pantau kondisi peminjaman dan stok barang secara real-time.</p>
    </div>

    <div class="grid cols-3" style="margin-bottom: 1rem;">
        <div class="metric">
            <div class="label">Total Jenis Barang</div>
            <div class="value">{{ $totalItems }}</div>
        </div>
        <div class="metric">
            <div class="label">Total Unit Barang</div>
            <div class="value">{{ $totalStock }}</div>
        </div>
        <div class="metric">
            <div class="label">Stok Tersedia di LAB</div>
            <div class="value">{{ $availableStock }}</div>
        </div>
    </div>

    <div class="grid cols-3" style="margin-bottom: 1rem;">
        <div class="metric">
            <div class="label">Sedang Dipinjam</div>
            <div class="value">{{ $borrowedStock }}</div>
        </div>
        <div class="metric">
            <div class="label">Transaksi Aktif</div>
            <div class="value">{{ $activeLoans }}</div>
        </div>
        <div class="metric">
            <div class="label">Terlambat Kembali</div>
            <div class="value" style="color:#991b1b;">{{ $overdueLoans }}</div>
        </div>
    </div>

    <div class="card">
        <div class="row" style="justify-content: space-between;">
            <h3 style="margin-bottom: 0;">Peminjaman Terbaru</h3>
            <a href="{{ route('admin.loans.index') }}" class="btn btn-soft">Lihat Semua</a>
        </div>
        <table>
            <thead>
            <tr>
                <th>Kode</th>
                <th>Peminjam</th>
                <th>Barang</th>
                <th>Jatuh Tempo</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse ($recentLoans as $loan)
                <tr>
                    <td>{{ $loan->loan_code }}</td>
                    <td>{{ $loan->borrower_name }}<br><span class="muted">{{ $loan->borrower_id_number }}</span></td>
                    <td>
                        @foreach ($loan->loanItems as $loanItem)
                            <div>{{ $loanItem->item->name }} x{{ $loanItem->quantity }}</div>
                        @endforeach
                    </td>
                    <td>{{ $loan->due_at->format('d M Y H:i') }}</td>
                    <td><span class="badge {{ $loan->status }}">{{ strtoupper($loan->status) }}</span></td>
                    <td><a class="btn btn-soft" href="{{ route('admin.loans.show', $loan) }}">Detail</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="muted">Belum ada transaksi peminjaman.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
