<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Account;
use App\Models\Transfer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $accounts = Account::where('user_id', $userId)->get();
        $transactions = Transaction::with(['account', 'transactionType'])
            ->where('user_id', $userId)
            ->get();
        $transactionTypes = TransactionType::all();
        $totalBalance = $accounts->sum('balance');

        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $periodBalance = Transaction::where('user_id', $userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->sum(function ($transaction) {
                return $transaction->transactionType->type === 'expense' ? -$transaction->amount : $transaction->amount;
            });

        return view('dashboard', compact('accounts', 'transactions', 'transactionTypes', 'totalBalance', 'periodBalance'));
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
            'to_account_id' => 'required_if:transaction_type_id,3|exists:accounts,id'
        ]);

        if ($request->transaction_type_id == 3) {
            // Handle transfer
            DB::transaction(function () use ($request) {
                $transfer = Transfer::create([
                    'user_id' => Auth::id(),
                    'from_account_id' => $request->account_id,
                    'to_account_id' => $request->to_account_id,
                    'amount' => $request->amount,
                    'description' => $request->description,
                ]);

                // Create a single transaction record for the transfer
                Transaction::create([
                    'user_id' => Auth::id(),
                    'account_id' => $request->account_id,
                    'transaction_type_id' => $request->transaction_type_id,
                    'description' => $request->description,
                    'amount' => -$request->amount, // Negative amount for debit
                    'to_account_id' => $request->to_account_id, // Store the destination account ID
                ]);

                // Create a corresponding transaction for the destination account (credit)
                Transaction::create([
                    'user_id' => Auth::id(),
                    'account_id' => $request->to_account_id,
                    'transaction_type_id' => $request->transaction_type_id,
                    'description' => $request->description,
                    'amount' => $request->amount, // Positive amount for credit
                ]);
            });
        } else {
            // Handle regular transaction
            Transaction::create([
                'user_id' => Auth::id(),
                'account_id' => $request->account_id,
                'transaction_type_id' => $request->transaction_type_id,
                'description' => $request->description,
                'amount' => $request->amount,
            ]);
        }

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
        $userId = Auth::id();
        $accounts = Account::where('user_id', $userId)->get();
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
            'to_account_id' => 'required_if:transaction_type_id,3|exists:accounts,id',
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
     * Show the form for deleting the specified resource.
     */
    public function delete(string $id)
    {
        $transaction = Transaction::findOrFail($id);

        // Ensure the transaction belongs to the authenticated user
        if ($transaction->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to delete this transaction.');
        }

        return view('transactions.delete', compact('transaction'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    { {
            $transaction = Transaction::findOrFail($id);

            // Ensure the transaction belongs to the authenticated user
            if ($transaction->user_id !== Auth::id()) {
                return redirect()->route('dashboard')->with('error', 'You are not authorized to delete this transaction.');
            }

            $transaction->delete();

            return redirect()->route('dashboard')->with('success', 'Transaction deleted successfully.');
        }
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
