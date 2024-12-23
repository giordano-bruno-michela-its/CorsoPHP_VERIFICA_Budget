<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Account;
use App\Models\Transfer;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TransactionType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $accounts = Account::where('user_id', $userId)->get();
        $transactionTypes = TransactionType::all();
        $totalBalance = $accounts->sum('balance');
        $accountId = $request->query('account_id');
        $perPage = $request->query('per_page', 10);

        $query = Transaction::with(['account', 'transactionType'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc');

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($accountId) {
            $query->where('account_id', $accountId);
        }

        $transactions = $query->paginate($perPage);

        return view('dashboard', compact('accounts', 'transactions', 'transactionTypes', 'totalBalance'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userId = Auth::id();
        $accounts = Account::where('user_id', $userId)->get();
        $transactionTypes = TransactionType::where('user_id', $userId)->get();
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
            'created_at' => 'required|date_format:Y-m-d\TH:i',
            'to_account_id' => 'required_if:transaction_type_id,3|exists:accounts,id',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $fileName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('transactions', $fileName, 'public');
        }

        if ($request->transaction_type_id == 3) {
            // Handle transfer
            DB::transaction(function () use ($request, $filePath) {
                $transfer = Transfer::create([
                    'user_id' => Auth::id(),
                    'from_account_id' => $request->account_id,
                    'to_account_id' => $request->to_account_id,
                    'amount' => $request->amount,
                    'description' => $request->description,
                ]);

                // Create a single transaction record for the transfer
                $transaction = new Transaction([
                    'user_id' => Auth::id(),
                    'account_id' => $request->account_id,
                    'transaction_type_id' => $request->transaction_type_id,
                    'description' => $request->description,
                    'amount' => -$request->amount, // Negative amount for debit
                    'to_account_id' => $request->to_account_id, // Store the destination account ID
                    'file_path' => $filePath,
                ]);
                $transaction->created_at = $request->created_at;
                $transaction->save();

                // Create a corresponding transaction for the destination account (credit)
                $transaction = new Transaction([
                    'user_id' => Auth::id(),
                    'account_id' => $request->to_account_id,
                    'transaction_type_id' => $request->transaction_type_id,
                    'description' => $request->description,
                    'amount' => $request->amount, // Positive amount for credit
                    'file_path' => $filePath,
                ]);
                $transaction->created_at = $request->created_at;
                $transaction->save();
            });
        } else {
            // Handle regular transaction
            $transaction = new Transaction([
                'user_id' => Auth::id(),
                'account_id' => $request->account_id,
                'transaction_type_id' => $request->transaction_type_id,
                'description' => $request->description,
                'amount' => $request->amount,
                'file_path' => $filePath,
            ]);
            $transaction->created_at = $request->created_at;
            $transaction->save();
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

        if ($transaction->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->withErrors(['error', '=== UNAUTHORIZED ===']);
        }

        $userId = Auth::id();
        $accounts = Account::where('user_id', $userId)->get();
        $transactionTypes = TransactionType::where('user_id', $userId)->get();
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
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
        ]);

        $transaction = Transaction::findOrFail($id);

        if ($transaction->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->withErrors(['error', '=== UNAUTHORIZED ===']);
        }
        
        $transaction->account_id = $request->account_id;
        $transaction->transaction_type_id = $request->transaction_type_id;
        $transaction->description = $request->description;
        $transaction->amount = $request->amount;
        $transaction->created_at = $request->created_at;

        if ($request->hasFile('file')) {
            // Delete the old file if it exists
            if ($transaction->file_path) {
                Storage::delete('public/' . $transaction->file_path);
            }

            // Store the new file
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $fileName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('transactions', $fileName, 'public');
            $transaction->file_path = $filePath;
        }

        $transaction->save();

        return redirect()->route('dashboard')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Show the form for deleting the specified resource.
     */
    public function delete(string $id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', '=== UNAUTHORIZED ===');
        }

        return view('transactions.delete', compact('transaction'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    { {
            $transaction = Transaction::findOrFail($id);

            if ($transaction->user_id !== Auth::id()) {
                return redirect()->route('dashboard')->with('error', '=== UNAUTHORIZED ===');
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
            ->where('user_id', $userId)
            ->orderBy($column, $direction)
            ->get();

        return view('partials.transactions-table', compact('transactions'))->render();
    }
}
