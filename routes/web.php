<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionTypeController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', [TransactionController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/settings', [SettingsController::class, 'index'])
    ->name('settings');

Route::middleware('auth')->group(function () {
    Route::get('/transactions/sort', [TransactionController::class, 'sort'])->name('transactions.sort');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::get('/transactions/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::patch('/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{id}/delete', [TransactionController::class, 'delete'])->name('transactions.delete');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    Route::get('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::get('/accounts/{id}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
    Route::patch('/accounts/{id}', [AccountController::class, 'update'])->name('accounts.update');
    Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');

    Route::get('/transaction-types/create', [TransactionTypeController::class, 'create'])->name('transaction-types.create');
    Route::get('/transaction-types/{id}/edit', [TransactionTypeController::class, 'edit'])->name('transaction-types.edit');
    Route::patch('/transaction-types/{id}', [TransactionTypeController::class, 'update'])->name('transaction-types.update');
    Route::post('/transaction-types', [TransactionTypeController::class, 'store'])->name('transaction-types.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
