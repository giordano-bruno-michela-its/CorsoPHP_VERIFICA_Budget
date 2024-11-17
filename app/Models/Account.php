<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getBalanceAttribute()
    {
        return $this->transactions->sum(function ($transaction) {
            return $transaction->transactionType->type === 'expense' ? -abs($transaction->amount) : $transaction->amount;
        });
    }
}
