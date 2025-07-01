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

        // Tambahkan: Data untuk Grafik Pemasukan Harian (30 hari terakhir)
        $dailyIncomesQuery = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereBetween('transaction_date', [Carbon::now()->subDays(29), Carbon::now()])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get([
                DB::raw('DATE(transaction_date) as date'),
                DB::raw('SUM(amount) as total')
            ])
            ->pluck('total', 'date');

        $chartLabels = [];
        $expenseChartData = [];
        $incomeChartData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = Carbon::parse($date)->format('d M');
            $expenseChartData[] = $dailyExpensesQuery->get($date, 0);
            $incomeChartData[] = $dailyIncomesQuery->get($date, 0);
        }
        
        $dailyExpenseChart = [
            'labels' => $chartLabels,
            'expense' => $expenseChartData,
            'income' => $incomeChartData,
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

        // Ambil daftar tahun dari transaksi user
        $years = Transaction::where('user_id', $user->id)
            ->selectRaw('YEAR(transaction_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Ambil total pemasukan per kategori bulan ini
        $incomeByCategory = Transaction::where('luthfi_transactions.user_id', $user->id)
            ->where('luthfi_transactions.type', 'income')
            ->whereBetween('luthfi_transactions.transaction_date', [$startOfMonth, $endOfMonth])
            ->join('luthfi_categories', 'luthfi_transactions.category_id', '=', 'luthfi_categories.id')
            ->select('luthfi_categories.name', DB::raw('SUM(luthfi_transactions.amount) as total'))
            ->groupBy('luthfi_categories.name')
            ->get();

        // Ambil total pengeluaran per kategori bulan ini
        $expenseByCategory = Transaction::where('luthfi_transactions.user_id', $user->id)
            ->where('luthfi_transactions.type', 'expense')
            ->whereBetween('luthfi_transactions.transaction_date', [$startOfMonth, $endOfMonth])
            ->join('luthfi_categories', 'luthfi_transactions.category_id', '=', 'luthfi_categories.id')
            ->select('luthfi_categories.name', DB::raw('SUM(luthfi_transactions.amount) as total'))
            ->groupBy('luthfi_categories.name')
            ->get();

        // Hitung persentase
        $incomePercentages = [];
        foreach ($incomeByCategory as $row) {
            $incomePercentages[] = [
                'name' => $row->name,
                'percentage' => $totalIncome > 0 ? round(($row->total / $totalIncome) * 100, 2) : 0,
                'total' => $row->total,
            ];
        }
        $expensePercentages = [];
        foreach ($expenseByCategory as $row) {
            $expensePercentages[] = [
                'name' => $row->name,
                'percentage' => $totalExpense > 0 ? round(($row->total / $totalExpense) * 100, 2) : 0,
                'total' => $row->total,
            ];
        }

        $incomeExpenseSummary = [
            'labels' => ['Pemasukan', 'Pengeluaran'],
            'data' => [$totalIncome, $totalExpense],
        ];

        $expenseChartLabels = [];
        $expenseChartData = [];
        $expenseChartColors = [
            '#8B5CF6', '#06B6D4', '#F59E42', '#F43F5E', '#10B981', '#FBBF24', '#6366F1', '#A3E635', '#F472B6', '#374151'
        ];
        foreach ($expensePercentages as $i => $row) {
            $expenseChartLabels[] = $row['name'];
            $expenseChartData[] = $row['total'];
        }

        $categorySummary = [
            'labels' => $expenseChartLabels,
            'data' => $expenseChartData,
            'colors' => $expenseChartColors,
        ];

        // Data pengeluaran per kategori untuk bulan ini
        $expenseChartLabelsMonth = [];
        $expenseChartDataMonth = [];
        foreach ($expenseByCategory as $row) {
            $expenseChartLabelsMonth[] = $row->name;
            $expenseChartDataMonth[] = $row->total;
        }

        // Data pengeluaran per kategori untuk minggu ini
        $startOfWeek = $now->startOfWeek()->copy();
        $endOfWeek = $now->endOfWeek()->copy();
        $expenseByCategoryWeek = Transaction::where('luthfi_transactions.user_id', $user->id)
            ->where('luthfi_transactions.type', 'expense')
            ->whereBetween('luthfi_transactions.transaction_date', [$startOfWeek, $endOfWeek])
            ->join('luthfi_categories', 'luthfi_transactions.category_id', '=', 'luthfi_categories.id')
            ->select('luthfi_categories.name', DB::raw('SUM(luthfi_transactions.amount) as total'))
            ->groupBy('luthfi_categories.name')
            ->get();
        $expenseChartLabelsWeek = [];
        $expenseChartDataWeek = [];
        foreach ($expenseByCategoryWeek as $row) {
            $expenseChartLabelsWeek[] = $row->name;
            $expenseChartDataWeek[] = $row->total;
        }

        // Data pengeluaran per kategori untuk tahun ini
        $startOfYear = $now->startOfYear()->copy();
        $endOfYear = $now->endOfYear()->copy();
        $expenseByCategoryYear = Transaction::where('luthfi_transactions.user_id', $user->id)
            ->where('luthfi_transactions.type', 'expense')
            ->whereBetween('luthfi_transactions.transaction_date', [$startOfYear, $endOfYear])
            ->join('luthfi_categories', 'luthfi_transactions.category_id', '=', 'luthfi_categories.id')
            ->select('luthfi_categories.name', DB::raw('SUM(luthfi_transactions.amount) as total'))
            ->groupBy('luthfi_categories.name')
            ->get();
        $expenseChartLabelsYear = [];
        $expenseChartDataYear = [];
        foreach ($expenseByCategoryYear as $row) {
            $expenseChartLabelsYear[] = $row->name;
            $expenseChartDataYear[] = $row->total;
        }

        return view('dashboard', compact(
            'totalIncome', 
            'totalExpense',
            'totalBalance',
            'dailyExpenseChart',
            'topCategory',
            'recentTransactions',
            'incomePercentages',
            'expensePercentages',
            'years',
            'incomeExpenseSummary',
            'categorySummary',
            'expenseChartLabelsMonth', 'expenseChartDataMonth',
            'expenseChartLabelsWeek', 'expenseChartDataWeek',
            'expenseChartLabelsYear', 'expenseChartDataYear',
            'expenseChartColors'
        ));
    }
} 