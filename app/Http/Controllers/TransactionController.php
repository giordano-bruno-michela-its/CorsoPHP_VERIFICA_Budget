<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with(['user', 'account', 'transactionType'])->get();
        return view('dashboard', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $accounts = Account::all();
        $transactionTypes = TransactionType::all();
        return view('transactions.create', compact('users', 'accounts', 'transactionTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'transaction_type_id' => 'required|exists:transaction_types,id',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
        ]);

        // Create the transaction with the authenticated user's ID
        Transaction::create([
            'user_id' => Auth::user()->id,
            'account_id' => $request->account_id,
            'transaction_type_id' => $request->transaction_type_id,
            'description' => $request->description,
            'amount' => $request->amount,
        ]);

        return redirect()->route('dashboard')->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
