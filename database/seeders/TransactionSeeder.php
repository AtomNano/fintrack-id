<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $categories = Category::all();
        $days = 60; // jumlah hari ke belakang

        foreach ($users as $user) {
            $accounts = Account::where('user_id', $user->id)->get();
            foreach ($accounts as $account) {
                for ($d = $days - 1; $d >= 0; $d--) {
                    $date = Carbon::now()->subDays($d)->startOfDay();
                    // Setiap hari, 1-2 transaksi (income/expense)
                    $transCount = rand(1, 2);
                    for ($t = 0; $t < $transCount; $t++) {
                        $type = Arr::random(['income', 'expense']);
                        $cat = $categories->where('type', $type)->random();
                        $amount = $type === 'income' ? rand(50000, 3000000) : rand(10000, 1500000);
                        $desc = $type === 'income' ? 'Pemasukan ' . $cat->name : 'Pengeluaran ' . $cat->name;
                        Transaction::create([
                            'user_id' => $user->id,
                            'account_id' => $account->id,
                            'category_id' => $cat->id,
                            'amount' => $amount,
                            'type' => $type,
                            'description' => $desc,
                            'transaction_date' => $date,
                        ]);
                    }
                }
            }
        }
    }
} 