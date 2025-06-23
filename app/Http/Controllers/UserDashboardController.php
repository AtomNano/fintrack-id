<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Transaction;

class UserDashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama pengguna dengan data keuangan.
     */
    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now();
        $startOfMonth = $now->startOfMonth()->copy();
        $endOfMonth = $now->endOfMonth()->copy();

        // 1. Total Pemasukan Bulan Ini
        $totalIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // 2. Total Pengeluaran Bulan Ini
        $totalExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
        
        // 3. Total Saldo dari semua akun
        $totalBalance = $user->accounts()->sum('balance');

        // 4. Data untuk Grafik Pengeluaran Harian (30 hari terakhir)
        $dailyExpensesQuery = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [Carbon::now()->subDays(29), Carbon::now()])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get([
                DB::raw('DATE(transaction_date) as date'),
                DB::raw('SUM(amount) as total')
            ])
            ->pluck('total', 'date');

        $chartLabels = [];
        $chartData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = Carbon::parse($date)->format('d M');
            $chartData[] = $dailyExpensesQuery->get($date, 0);
        }
        
        $dailyExpenseChart = [
            'labels' => $chartLabels,
            'data' => $chartData,
        ];

        // 5. Insight: Kategori Pengeluaran Terbesar Bulan Ini
        $topCategory = Transaction::where('luthfi_transactions.user_id', $user->id)
            ->where('luthfi_transactions.type', 'expense')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->join('luthfi_categories', 'luthfi_transactions.category_id', '=', 'luthfi_categories.id')
            ->select('luthfi_categories.name', DB::raw('SUM(luthfi_transactions.amount) as total'))
            ->groupBy('luthfi_categories.name')
            ->orderBy('total', 'DESC')
            ->first();

        // 6. Ambil 5 transaksi terakhir user
        $recentTransactions = Transaction::with(['category', 'account'])
            ->where('user_id', $user->id)
            ->orderByDesc('transaction_date')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalIncome', 
            'totalExpense',
            'totalBalance',
            'dailyExpenseChart',
            'topCategory',
            'recentTransactions'
        ));
    }
} 