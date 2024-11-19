<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Auth;

class TransactionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactionTypes = TransactionType::where('user_id', Auth::id())->get();
        return view('transaction-types.index', compact('transactionTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transaction-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:income,expense,transfer',
        ]);

        TransactionType::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('settings')->with('success', 'Transaction type created successfully.');
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
        $transactionType = TransactionType::where('user_id', Auth::id())->findOrFail($id);
        return view('transaction-types.edit', compact('transactionType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transactionType = TransactionType::where('user_id', Auth::id())->findOrFail($id);
        $transactionType->update($request->all());

        return redirect()->route('settings')->with('success', 'Transaction Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $transactionType = TransactionType::where('user_id', Auth::id())->findOrFail($id);

        return view('transaction-types.delete', compact('transactionType'));
    }

    public function destroy(string $id)
    {
        $transactionType = TransactionType::where('user_id', Auth::id())->findOrFail($id);
        $transactionType->delete();

        return redirect()->route('settings')->with('success', 'Transaction type deleted successfully.');
    }
}
