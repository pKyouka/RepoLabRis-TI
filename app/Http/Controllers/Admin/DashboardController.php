<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Loan;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $totalItems = Item::count();
        $totalStock = Item::sum('total_stock');
        $availableStock = Item::sum('available_stock');
        $borrowedStock = $totalStock - $availableStock;

        $activeLoans = Loan::whereIn('status', ['borrowed', 'overdue'])->count();
        $overdueLoans = Loan::where('status', 'overdue')->count();

        $recentLoans = Loan::query()
            ->with('loanItems.item')
            ->latest('borrowed_at')
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact(
            'totalItems',
            'totalStock',
            'availableStock',
            'borrowedStock',
            'activeLoans',
            'overdueLoans',
            'recentLoans'
        ));
    }
}
