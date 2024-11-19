<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Transaction;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create a default account (old)
/*         $account = Account::create([
            'user_id' => 1,
            'name' => 'Conto base',
            'description' => 'Default account',
        ]); */

        // Create 20 fake transactions for the default account
        for ($i = 0; $i < 20; $i++) {
            Transaction::create([
                'user_id' => 1,
                'account_id' => 1,
                'transaction_type_id' => $faker->numberBetween(1, 2),
                'description' => $faker->text(20),
                'amount' => $faker->randomFloat(2, 1, 1000),
            ]);
        }
    }
}
