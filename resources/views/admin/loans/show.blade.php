@extends('layouts.app', ['title' => 'Detail Peminjaman'])

@section('content')
    <div class="card" style="margin-bottom: 1rem;">
        <div class="row" style="justify-content: space-between; align-items: flex-start;">
            <div>
                <h1>Detail Peminjaman {{ $loan->loan_code }}</h1>
                <p class="muted">Status saat ini: <span class="badge {{ $loan->status }}">{{ strtoupper($loan->status) }}</span></p>
            </div>
            <a href="{{ route('admin.loans.index') }}" class="btn btn-soft">Kembali ke Daftar</a>
        </div>

        <div class="grid cols-2">
            <div>
                <p><strong>Nama:</strong> {{ $loan->borrower_name }}</p>
                <p><strong>NIM:</strong> {{ $loan->borrower_id_number }}</p>
                <p><strong>Prodi:</strong> {{ $loan->borrower_program ?: '-' }}</p>
                <p><strong>No HP:</strong> {{ $loan->borrower_phone ?: '-' }}</p>
            </div>
            <div>
                <p><strong>Waktu Pinjam:</strong> {{ $loan->borrowed_at->format('d M Y H:i') }}</p>
                <p><strong>Jatuh Tempo:</strong> {{ $loan->due_at->format('d M Y H:i') }}</p>
                <p><strong>Waktu Kembali:</strong> {{ $loan->returned_at?->format('d M Y H:i') ?: '-' }}</p>
            </div>
        </div>

        <p><strong>Keperluan:</strong> {{ $loan->purpose ?: '-' }}</p>

        <h3>Daftar Barang</h3>
        <table>
            <thead>
            <tr>
                <th>Barang</th>
                <th>Jumlah Pinjam</th>
                <th>Jumlah Kembali</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($loan->loanItems as $loanItem)
                <tr>
                    <td>{{ $loanItem->item->name }}</td>
                    <td>{{ $loanItem->quantity }}</td>
                    <td>{{ $loanItem->returned_quantity }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @if ($loan->status === 'pending')
        <div class="grid cols-2" style="margin-bottom: 1rem;">
            <div class="card">
                <h3>ACC Peminjaman</h3>
                <p class="muted">Setujui pengajuan ini bila stok siap dipinjam. Stok barang akan otomatis berkurang saat di-ACC.</p>
                <form method="POST" action="{{ route('admin.loans.approve', $loan) }}">
                    @csrf
                    @method('PATCH')
                    <div class="field">
                        <label for="admin_notes_approve">Catatan Admin (opsional)</label>
                        <textarea id="admin_notes_approve" name="admin_notes" rows="3">{{ old('admin_notes', $loan->admin_notes) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">ACC Pengajuan</button>
                </form>
            </div>

            <div class="card">
                <h3>Tolak Peminjaman</h3>
                <p class="muted">Tolak pengajuan bila barang tidak dapat dipinjam. Mohon isi alasan agar peminjam mendapat informasi jelas.</p>
                <form method="POST" action="{{ route('admin.loans.reject', $loan) }}">
                    @csrf
                    @method('PATCH')
                    <div class="field">
                        <label for="admin_notes_reject">Alasan Penolakan</label>
                        <textarea id="admin_notes_reject" name="admin_notes" rows="3" required>{{ old('admin_notes', $loan->admin_notes) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Tolak Pengajuan</button>
                </form>
            </div>
        </div>
    @elseif (in_array($loan->status, ['borrowed', 'overdue'], true))
        <div class="card">
            <h3>Proses Pengembalian</h3>
            <p class="muted">Klik tombol di bawah untuk menandai semua barang pada transaksi ini sudah kembali ke LAB.</p>
            <form method="POST" action="{{ route('admin.loans.returned', $loan) }}">
                @csrf
                @method('PATCH')
                <div class="field">
                    <label for="admin_notes">Catatan Admin (opsional)</label>
                    <textarea id="admin_notes" name="admin_notes" rows="3">{{ old('admin_notes', $loan->admin_notes) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Tandai Sudah Dikembalikan</button>
            </form>
        </div>
    @elseif ($loan->status === 'rejected')
        <div class="card">
            <h3>Pengajuan Ditolak</h3>
            <p class="muted">Pengajuan ini sudah ditolak oleh admin.</p>
            <p><strong>Alasan / Catatan Admin:</strong> {{ $loan->admin_notes ?: '-' }}</p>
        </div>
    @endif
@endsection
