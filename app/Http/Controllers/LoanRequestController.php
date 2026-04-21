<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;
use App\Models\LoanItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LoanRequestController extends Controller
{
    public function create(): View
    {
        $items = Item::query()
            ->where('is_active', true)
            ->where('available_stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view('loan_requests.create', compact('items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'borrower_name' => ['required', 'string', 'max:255'],
            'borrower_id_number' => ['required', 'string', 'max:100'],
            'borrower_program' => ['nullable', 'string', 'max:255'],
            'borrower_phone' => ['nullable', 'string', 'max:50'],
            'purpose' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.item_id' => ['required', 'integer', 'distinct', 'exists:items,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $loan = DB::transaction(function () use ($validated) {
            $itemRequests = collect($validated['items'])
                ->mapWithKeys(fn (array $row) => [(int) $row['item_id'] => (int) $row['quantity']]);

            $items = Item::query()
                ->whereIn('id', $itemRequests->keys())
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($itemRequests as $itemId => $quantity) {
                $item = $items->get($itemId);
                if (! $item || ! $item->is_active) {
                    throw ValidationException::withMessages([
                        'items' => ['Ada barang yang tidak tersedia untuk dipinjam.'],
                    ]);
                }

                if ($item->available_stock < $quantity) {
                    throw ValidationException::withMessages([
                        'items' => ["Stok {$item->name} tidak mencukupi."],
                    ]);
                }
            }

            $borrowedAt = now();
            $loan = Loan::create([
                'borrower_name' => $validated['borrower_name'],
                'borrower_id_number' => $validated['borrower_id_number'],
                'borrower_program' => $validated['borrower_program'] ?? null,
                'borrower_phone' => $validated['borrower_phone'] ?? null,
                'purpose' => $validated['purpose'] ?? null,
                'borrowed_at' => $borrowedAt,
                'due_at' => $borrowedAt->copy()->addDays(3),
                'status' => 'borrowed',
            ]);

            foreach ($itemRequests as $itemId => $quantity) {
                LoanItem::create([
                    'loan_id' => $loan->id,
                    'item_id' => $itemId,
                    'quantity' => $quantity,
                ]);

                $item = $items->get($itemId);
                $item->decrement('available_stock', $quantity);
            }

            return $loan;
        });

        return redirect()->route('loan_requests.success', $loan);
    }

    public function success(Loan $loan): View
    {
        $loan->load('loanItems.item');

        return view('loan_requests.success', compact('loan'));
    }
}
