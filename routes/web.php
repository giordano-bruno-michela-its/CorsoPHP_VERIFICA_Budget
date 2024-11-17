<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionTypeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [TransactionController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::get('/transactions/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::patch('/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/sort', [TransactionController::class, 'sort'])->name('transactions.sort');

    Route::get('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');

    Route::get('/transaction-types/create', [TransactionTypeController::class, 'create'])->name('transaction-types.create');
    Route::post('/transaction-types', [TransactionTypeController::class, 'store'])->name('transaction-types.store');
    Route::get('/transaction-types/{id}/edit', [TransactionTypeController::class, 'edit'])->name('transaction-types.edit');
    Route::patch('/transaction-types/{id}', [TransactionTypeController::class, 'update'])->name('transaction-types.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
