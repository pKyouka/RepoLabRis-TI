@extends('layouts.app', ['title' => 'Peminjaman Berhasil'])

@section('content')
    <div class="card">
        <h1>Pengajuan Berhasil Disimpan</h1>
        <p class="muted">Silakan simpan kode peminjaman berikut untuk proses monitoring dan pengembalian.</p>

        <div class="metric" style="margin-bottom: 1rem;">
            <div class="label">Kode Peminjaman</div>
            <div class="value">{{ $loan->loan_code }}</div>
        </div>

        <div class="grid cols-2">
            <div>
                <p><strong>Nama:</strong> {{ $loan->borrower_name }}</p>
                <p><strong>NIM:</strong> {{ $loan->borrower_id_number }}</p>
            </div>
            <div>
                <p><strong>Waktu pinjam:</strong> {{ $loan->borrowed_at->format('d M Y H:i') }}</p>
                <p><strong>Batas kembali:</strong> {{ $loan->due_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        <h3>Barang Dipinjam</h3>
        <table>
            <thead>
            <tr>
                <th>Barang</th>
                <th>Jumlah</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($loan->loanItems as $loanItem)
                <tr>
                    <td>{{ $loanItem->item->name }}</td>
                    <td>{{ $loanItem->quantity }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="row" style="margin-top: 1rem;">
            <a class="btn btn-primary" href="{{ route('loan_requests.create') }}">Buat Peminjaman Baru</a>
            @auth
                @if (auth()->user()->is_admin)
                    <a class="btn btn-soft" href="{{ route('admin.loans.show', $loan) }}">Lihat di Panel Admin</a>
                @endif
            @endauth
        </div>
    </div>
@endsection
