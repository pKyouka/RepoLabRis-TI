@extends('layouts.app', ['title' => 'Data Peminjaman'])

@section('content')
    <div class="card">
        <div class="row" style="justify-content: space-between;">
            <div>
                <h1>Data Peminjaman</h1>
                <p class="muted">Monitoring siapa yang meminjam dan barang yang dipinjam dari awal hingga akhir.</p>
            </div>
        </div>

        <form method="GET" class="row" style="margin-bottom: 1rem; align-items: flex-end;">
            <div style="flex: 1 1 240px;">
                <label for="q">Cari</label>
                <input id="q" name="q" value="{{ $search }}" placeholder="Kode, nama, atau NIM">
            </div>
            <div style="width: 200px;">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="">Semua status</option>
                    <option value="borrowed" @selected($status === 'borrowed')>Borrowed</option>
                    <option value="overdue" @selected($status === 'overdue')>Overdue</option>
                    <option value="returned" @selected($status === 'returned')>Returned</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <table>
            <thead>
            <tr>
                <th>Kode</th>
                <th>Peminjam</th>
                <th>Barang</th>
                <th>Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse ($loans as $loan)
                <tr>
                    <td>{{ $loan->loan_code }}</td>
                    <td>{{ $loan->borrower_name }}<br><span class="muted">{{ $loan->borrower_id_number }}</span></td>
                    <td>
                        @foreach ($loan->loanItems as $loanItem)
                            <div>{{ $loanItem->item->name }} x{{ $loanItem->quantity }}</div>
                        @endforeach
                    </td>
                    <td>{{ $loan->borrowed_at->format('d M Y H:i') }}</td>
                    <td>{{ $loan->due_at->format('d M Y H:i') }}</td>
                    <td><span class="badge {{ $loan->status }}">{{ strtoupper($loan->status) }}</span></td>
                    <td><a class="btn btn-soft" href="{{ route('admin.loans.show', $loan) }}">Detail</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="muted">Belum ada data peminjaman.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div style="margin-top: 1rem;">
            {{ $loans->links() }}
        </div>
    </div>
@endsection
