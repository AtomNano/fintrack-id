<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $categories = Category::all();

        foreach ($users as $user) {
            $accounts = Account::where('user_id', $user->id)->get();
            // 30 transaksi acak per user
            for ($i = 0; $i < 30; $i++) {
                $type = Arr::random(['income', 'expense']);
                $category = $categories->where('type', $type)->random();
                $account = $accounts->random();
                $amount = $type === 'income' ? rand(50000, 5000000) : rand(10000, 2000000);
                $desc = $type === 'income' ? 'Pemasukan ' . $category->name : 'Pengeluaran ' . $category->name;
                Transaction::create([
                    'user_id' => $user->id,
                    'account_id' => $account->id,
                    'category_id' => $category->id,
                    'amount' => $amount,
                    'type' => $type,
                    'description' => $desc,
                    'transaction_date' => Carbon::now()->subDays(rand(0, 60)),
                ]);
            }
        }
    }
} 