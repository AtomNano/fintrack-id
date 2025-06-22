<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\User;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();

        foreach ($users as $user) {
            // Bank Accounts
            Account::create([
                'user_id' => $user->id,
                'name' => 'BCA Savings',
                'type' => 'Bank',
                'balance' => rand(5000000, 50000000),
            ]);

            Account::create([
                'user_id' => $user->id,
                'name' => 'Mandiri Current',
                'type' => 'Bank',
                'balance' => rand(1000000, 20000000),
            ]);

            // E-Wallet Accounts
            Account::create([
                'user_id' => $user->id,
                'name' => 'GoPay',
                'type' => 'E-Wallet',
                'balance' => rand(50000, 500000),
            ]);

            Account::create([
                'user_id' => $user->id,
                'name' => 'OVO',
                'type' => 'E-Wallet',
                'balance' => rand(25000, 300000),
            ]);

            Account::create([
                'user_id' => $user->id,
                'name' => 'DANA',
                'type' => 'E-Wallet',
                'balance' => rand(10000, 200000),
            ]);

            // Cash Account
            Account::create([
                'user_id' => $user->id,
                'name' => 'Cash Wallet',
                'type' => 'Cash',
                'balance' => rand(100000, 1000000),
            ]);

            // Investment Accounts
            Account::create([
                'user_id' => $user->id,
                'name' => 'Reksadana',
                'type' => 'Investment',
                'balance' => rand(1000000, 10000000),
            ]);

            Account::create([
                'user_id' => $user->id,
                'name' => 'Saham Portfolio',
                'type' => 'Investment',
                'balance' => rand(5000000, 50000000),
            ]);
        }
    }
} 