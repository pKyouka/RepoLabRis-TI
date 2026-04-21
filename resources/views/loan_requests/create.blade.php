@extends('layouts.app', ['title' => 'Form Peminjaman Barang LAB'])

@section('content')
    <div class="card">
        <h1>Form Peminjaman Barang LAB</h1>
        <p class="muted">Mahasiswa dapat meminjam barang tanpa login. Batas pengembalian otomatis 3 hari dari waktu peminjaman.</p>

        @if ($items->isEmpty())
            <div class="errors">
                <strong>Data barang belum tersedia.</strong>
                Silakan isi dulu melalui menu Data Barang, lalu form ini siap digunakan.
            </div>
        @endif

        <form method="POST" action="{{ route('loan_requests.store') }}">
            @csrf
            <div class="grid cols-2">
                <div class="field">
                    <label for="borrower_name">Nama Mahasiswa</label>
                    <input id="borrower_name" name="borrower_name" value="{{ old('borrower_name') }}" required>
                </div>
                <div class="field">
                    <label for="borrower_id_number">NIM / Identitas</label>
                    <input id="borrower_id_number" name="borrower_id_number" value="{{ old('borrower_id_number') }}" required>
                </div>
                <div class="field">
                    <label for="borrower_program">Program Studi (opsional)</label>
                    <input id="borrower_program" name="borrower_program" value="{{ old('borrower_program') }}">
                </div>
                <div class="field">
                    <label for="borrower_phone">No. HP (opsional)</label>
                    <input id="borrower_phone" name="borrower_phone" value="{{ old('borrower_phone') }}">
                </div>
            </div>

            <div class="field">
                <label for="purpose">Keperluan Peminjaman (opsional)</label>
                <textarea id="purpose" name="purpose" rows="3">{{ old('purpose') }}</textarea>
            </div>

            <h3>Barang Dipinjam</h3>
            <p class="muted">Pilih barang dan jumlah. Stok yang tampil adalah stok tersedia saat ini.</p>

            <div id="loan-items-wrapper" class="grid" style="margin-bottom: 1rem;"></div>

            <div class="row" style="margin-bottom: 1.2rem;">
                <button class="btn btn-soft" type="button" id="add-item-row" @disabled($items->isEmpty())>Tambah Baris Barang</button>
            </div>

            <button class="btn btn-primary" type="submit" @disabled($items->isEmpty())>Kirim Pengajuan Peminjaman</button>
        </form>
    </div>

    <template id="item-row-template">
        <div class="card" style="padding: 0.9rem;">
            <div class="grid cols-2">
                <div class="field" style="margin-bottom: 0;">
                    <label>Barang</label>
                    <select data-field="item_id" required>
                        <option value="">Pilih barang</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }} (stok: {{ $item->available_stock }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="field" style="margin-bottom: 0;">
                    <label>Jumlah</label>
                    <input data-field="quantity" type="number" min="1" required>
                </div>
            </div>
            <div class="row" style="justify-content: flex-end; margin-top: 0.6rem;">
                <button class="btn btn-danger" type="button" data-action="remove">Hapus Baris</button>
            </div>
        </div>
    </template>

    <script>
        const wrapper = document.getElementById('loan-items-wrapper');
        const template = document.getElementById('item-row-template');
        const addBtn = document.getElementById('add-item-row');

        let index = 0;

        function addRow() {
            const node = template.content.cloneNode(true);
            const row = node.querySelector('.card');

            row.querySelectorAll('[data-field]').forEach((input) => {
                const field = input.getAttribute('data-field');
                input.setAttribute('name', `items[${index}][${field}]`);
            });

            row.querySelector('[data-action="remove"]').addEventListener('click', () => {
                row.remove();
            });

            wrapper.appendChild(row);
            index += 1;
        }

        if (addBtn) {
            addBtn.addEventListener('click', addRow);
            if ({{ $items->count() }} > 0) {
                addRow();
            }
        }
    </script>
@endsection
