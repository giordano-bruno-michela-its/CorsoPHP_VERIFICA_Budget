<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $account = new Account($request->all());
        $account->user_id = Auth::user()->id;
        $account->save();

        return redirect()->route('settings')->with('success', 'Account created successfully.');
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
        $account = Account::findOrFail($id);
        return view('accounts.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $account = Account::findOrFail($id);
        $account->update($request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]));

        return redirect()->route('settings')->with('status', 'Account updated successfully!');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $account = Account::findOrFail($id);

        if ($account->user_id !== Auth::id()) {
            return redirect()->route('settings')->with('error', '=== UNAUTHORIZED ===');
        }

        return view('accounts.delete', compact('account'));
    }

    public function destroy(string $id)
    {
        $account = Account::findOrFail($id);

        if ($account->user_id !== Auth::id()) {
            return redirect()->route('settings')->with('error', '=== UNAUTHORIZED ===');
        }

        $account->delete();

        return redirect()->route('settings')->with('success', 'Account deleted successfully.');
    }
}
