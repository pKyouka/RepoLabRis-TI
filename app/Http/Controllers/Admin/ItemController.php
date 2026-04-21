<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(): View
    {
        $items = Item::query()->latest()->paginate(15);

        return view('admin.items.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.items.form', [
            'item' => new Item(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:100', 'unique:items,code'],
            'total_stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Item::create([
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'total_stock' => $validated['total_stock'],
            'available_stock' => $validated['total_stock'],
            'description' => $validated['description'] ?? null,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.items.index')->with('status', 'Barang berhasil ditambahkan.');
    }

    public function edit(Item $item): View
    {
        return view('admin.items.form', [
            'item' => $item,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Item $item): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:100', 'unique:items,code,' . $item->id],
            'total_stock' => ['required', 'integer', 'min:0'],
            'available_stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $availableStock = min($validated['available_stock'], $validated['total_stock']);

        $item->update([
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'total_stock' => $validated['total_stock'],
            'available_stock' => $availableStock,
            'description' => $validated['description'] ?? null,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.items.index')->with('status', 'Data barang berhasil diperbarui.');
    }

    public function destroy(Item $item): RedirectResponse
    {
        if ($item->loanItems()->exists()) {
            return back()->with('status', 'Barang tidak bisa dihapus karena sudah punya riwayat peminjaman.');
        }

        $item->delete();

        return redirect()->route('admin.items.index')->with('status', 'Barang berhasil dihapus.');
    }
}
