<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\LoanRequestController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/peminjaman');

Route::get('/peminjaman', [LoanRequestController::class, 'create'])->name('loan_requests.create');
Route::post('/peminjaman', [LoanRequestController::class, 'store'])->name('loan_requests.store');
Route::get('/peminjaman/{loan}/sukses', [LoanRequestController::class, 'success'])->name('loan_requests.success');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::get('/loans/{loan}', [LoanController::class, 'show'])->name('loans.show');
    Route::patch('/loans/{loan}/returned', [LoanController::class, 'markReturned'])->name('loans.returned');
    Route::resource('items', ItemController::class)->except(['show']);
});
