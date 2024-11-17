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
        $userId = Auth::id();
        $accounts = Account::where('user_id', $userId)->get();
        $transactions = Transaction::with(['account', 'transactionType'])
            ->where('user_id', $userId)
            ->get();
        $transactionTypes = TransactionType::all();
        $totalBalance = $accounts->sum('balance');
        return view('dashboard', compact('accounts', 'transactions', 'transactionTypes', 'totalBalance'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userId = Auth::id();
        $accounts = Account::where('user_id', $userId)->get();
        $transactionTypes = TransactionType::all();
        return view('transactions.create', compact('accounts', 'transactionTypes'));
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
    
        $transaction = new Transaction($request->all());
        $transaction->user_id = Auth::id();
        $transaction->save();
    
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
        $transaction = Transaction::findOrFail($id);
        $accounts = Account::all();
        $transactionTypes = TransactionType::all();
        return view('transactions.edit', compact('transaction', 'accounts', 'transactionTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'transaction_type_id' => 'required|exists:transaction_types,id',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'created_at' => 'required|date_format:Y-m-d\TH:i',
        ]);
    
        $transaction = Transaction::findOrFail($id);
        $transaction->account_id = $request->account_id;
        $transaction->transaction_type_id = $request->transaction_type_id;
        $transaction->description = $request->description;
        $transaction->amount = $request->amount;
        $transaction->created_at = $request->created_at;
        $transaction->save();
    
        return redirect()->route('dashboard')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function sort(Request $request)
    {
        $userId = Auth::id();
        $column = $request->get('column', 'id');
        $direction = $request->get('direction', 'asc');
    
        $transactions = Transaction::with(['account', 'transactionType'])
            ->where('user_id', $userId) // Ensure transactions are filtered by user_id
            ->orderBy($column, $direction)
            ->get();
    
        return view('partials.transactions-table', compact('transactions'))->render();
    }
}
