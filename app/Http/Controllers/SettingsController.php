<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $transactionTypes = TransactionType::all();
        $accounts = Account::where('user_id', Auth::id())->get();
        return view('settings', compact('transactionTypes', 'accounts'));
    }
}
