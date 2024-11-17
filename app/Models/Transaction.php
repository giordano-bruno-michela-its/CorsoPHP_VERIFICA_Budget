<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'account_id',
        'transaction_type_id',
        'description',
        'amount',
        'to_account_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function toAccount()
    {
        return $this->belongsTo(Account::class, 'to_account_id');
    }

    public function setAmountAttribute($value)
    {
        if ($this->transactionType->type === 'expense' && $value > 0) {
            $this->attributes['amount'] = -$value;
        } else {
            $this->attributes['amount'] = $value;
        }
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($transaction) {
            if ($transaction->transactionType->type === 'transfer') {
                $fromAccount = $transaction->account;
                $toAccount = $transaction->toAccount;

                $createdAt = $transaction->created_at ?? now();

                // Create an expense transaction for the origin account
                $expenseTransaction = new Transaction();
                $expenseTransaction->user_id = $transaction->user_id;
                $expenseTransaction->account_id = $fromAccount->id;
                $expenseTransaction->transaction_type_id = TransactionType::where('type', 'expense')->first()->id;
                $expenseTransaction->description = $transaction->description;
                $expenseTransaction->amount = -abs($transaction->amount);
                $expenseTransaction->created_at = $createdAt;

                // Create an income transaction for the destination account
                $incomeTransaction = new Transaction();
                $incomeTransaction->user_id = $transaction->user_id;
                $incomeTransaction->account_id = $toAccount->id;
                $incomeTransaction->transaction_type_id = TransactionType::where('type', 'income')->first()->id;
                $incomeTransaction->description = $transaction->description;
                $incomeTransaction->amount = abs($transaction->amount);
                $incomeTransaction->created_at = $createdAt;

                DB::transaction(function () use ($expenseTransaction, $incomeTransaction) {
                    $expenseTransaction->save();
                    $incomeTransaction->save();
                });

                // Prevent the original transfer transaction from being saved
                return false;
            }
        });
    }
}
