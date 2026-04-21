@extends('layouts.app', ['title' => $isEdit ? 'Edit Barang' : 'Tambah Barang'])

@section('content')
    <div class="card">
        <h1>{{ $isEdit ? 'Edit Barang LAB' : 'Tambah Barang LAB' }}</h1>

        <form method="POST" action="{{ $isEdit ? route('admin.items.update', $item) : route('admin.items.store') }}">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="grid cols-2">
                <div class="field">
                    <label for="name">Nama Barang</label>
                    <input id="name" name="name" value="{{ old('name', $item->name) }}" required>
                </div>
                <div class="field">
                    <label for="code">Kode Barang (opsional)</label>
                    <input id="code" name="code" value="{{ old('code', $item->code) }}">
                </div>
                <div class="field">
                    <label for="total_stock">Total Stok</label>
                    <input id="total_stock" type="number" min="0" name="total_stock" value="{{ old('total_stock', $item->total_stock ?? 0) }}" required>
                </div>
                <div class="field">
                    <label for="available_stock">Stok Tersedia</label>
                    <input id="available_stock" type="number" min="0" name="available_stock" value="{{ old('available_stock', $item->available_stock ?? ($item->total_stock ?? 0)) }}" {{ $isEdit ? 'required' : 'readonly' }}>
                    @if (! $isEdit)
                        <small class="muted">Saat tambah data baru, stok tersedia otomatis sama dengan total stok.</small>
                    @endif
                </div>
            </div>

            <div class="field">
                <label for="description">Keterangan (opsional)</label>
                <textarea id="description" name="description" rows="3">{{ old('description', $item->description) }}</textarea>
            </div>

            <div class="field">
                <label class="row" style="gap: 0.5rem;">
                    <input type="checkbox" name="is_active" value="1" style="width:auto;" @checked(old('is_active', $item->is_active ?? true))>
                    Barang aktif dipinjam
                </label>
            </div>

            <div class="row">
                <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Barang' }}</button>
                <a href="{{ route('admin.items.index') }}" class="btn btn-soft">Batal</a>
            </div>
        </form>
    </div>
@endsection
