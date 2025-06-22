<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Budget;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BudgetSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $categories = Category::where('type', 'expense')->get();
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        foreach ($users as $user) {
            foreach ($categories as $category) {
                if (rand(0, 1)) { // Tidak semua kategori dapat budget
                    Budget::create([
                        'user_id' => $user->id,
                        'category_id' => $category->id,
                        'amount' => rand(200000, 5000000),
                        'month' => $month,
                        'year' => $year,
                    ]);
                }
            }
        }
    }
} 