<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account;
use App\Models\TransactionType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Default transaction types

        TransactionType::create([
            'name' => 'Income',
            'type' => 'income',
        ]);

        TransactionType::create([
            'name' => 'Expense',
            'type' => 'expense',
        ]);

        TransactionType::create([
            'name' => 'Transfer',
            'type' => 'transfer',
        ]);
    }
}
