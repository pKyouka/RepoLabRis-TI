@extends('layouts.app', ['title' => 'Data Barang'])

@section('content')
    <div class="card">
        <div class="row" style="justify-content: space-between;">
            <div>
                <h1>Data Barang LAB</h1>
                <p class="muted">Atur stok barang untuk kebutuhan peminjaman. Nanti data bisa diisi dari file Excel Anda.</p>
            </div>
            <a class="btn btn-primary" href="{{ route('admin.items.create') }}">Tambah Barang</a>
        </div>

        <table>
            <thead>
            <tr>
                <th>Nama</th>
                <th>Kode</th>
                <th>Total</th>
                <th>Tersedia</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse ($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->code ?: '-' }}</td>
                    <td>{{ $item->total_stock }}</td>
                    <td>{{ $item->available_stock }}</td>
                    <td>{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                    <td>
                        <div class="row" style="justify-content: flex-end;">
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
                    <td colspan="6" class="muted">Belum ada data barang.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div style="margin-top: 1rem;">
            {{ $items->links() }}
        </div>
    </div>
@endsection
