<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionType;

class SettingsController extends Controller
{
    public function index()
    {
        $transactionTypes = TransactionType::all();
        return view('settings', compact('transactionTypes'));
    }
}
