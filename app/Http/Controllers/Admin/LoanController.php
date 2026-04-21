<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LoanController extends Controller
{
    public function index(Request $request): View
    {
        Loan::query()
            ->where('status', 'borrowed')
            ->where('due_at', '<', now())
            ->update(['status' => 'overdue']);

        $status = $request->string('status')->toString();
        $search = $request->string('q')->toString();

        $loans = Loan::query()
            ->with('loanItems.item')
            ->when(in_array($status, ['borrowed', 'returned', 'overdue'], true), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($nested) use ($search) {
                    $nested
                        ->where('loan_code', 'like', "%{$search}%")
                        ->orWhere('borrower_name', 'like', "%{$search}%")
                        ->orWhere('borrower_id_number', 'like', "%{$search}%");
                });
            })
            ->latest('borrowed_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.loans.index', compact('loans', 'status', 'search'));
    }

    public function show(Loan $loan): View
    {
        if ($loan->status !== 'returned' && $loan->due_at->isPast()) {
            $loan->update(['status' => 'overdue']);
            $loan->refresh();
        }

        $loan->load('loanItems.item');

        return view('admin.loans.show', compact('loan'));
    }

    public function markReturned(Request $request, Loan $loan)
    {
        if ($loan->status === 'returned') {
            return back()->with('status', 'Peminjaman ini sudah dikembalikan sebelumnya.');
        }

        $request->validate([
            'admin_notes' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($loan, $request) {
            $loan->load('loanItems');

            foreach ($loan->loanItems as $loanItem) {
                $item = Item::query()->lockForUpdate()->find($loanItem->item_id);
                if (! $item) {
                    continue;
                }

                $returnQty = max($loanItem->quantity - $loanItem->returned_quantity, 0);
                if ($returnQty > 0) {
                    $item->update([
                        'available_stock' => min($item->available_stock + $returnQty, $item->total_stock),
                    ]);
                    $loanItem->update(['returned_quantity' => $loanItem->quantity]);
                }
            }

            $loan->update([
                'status' => 'returned',
                'returned_at' => now(),
                'admin_notes' => $request->string('admin_notes')->toString() ?: $loan->admin_notes,
            ]);
        });

        return redirect()->route('admin.loans.show', $loan)->with('status', 'Peminjaman telah ditandai selesai dikembalikan.');
    }
}
