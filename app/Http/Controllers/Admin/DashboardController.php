<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin.
     */
    public function index()
    {
        // Jumlah user terdaftar
        $totalUsers = User::count();

        // Total transaksi hari/bulan/tahun
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();
        $totalTransaksiHari = Transaction::whereDate('transaction_date', $today)->count();
        $totalTransaksiBulan = Transaction::whereBetween('transaction_date', [$startOfMonth, Carbon::now()])->count();
        $totalTransaksiTahun = Transaction::whereBetween('transaction_date', [$startOfYear, Carbon::now()])->count();

        // Total pemasukan/pengeluaran semua user
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');

        // Grafik pertumbuhan user dan transaksi (6 bulan terakhir)
        $userGrowth = [];
        $transactionGrowth = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('Y-m');
            $userGrowth[] = [
                'month' => Carbon::now()->subMonths($i)->format('M Y'),
                'count' => User::whereYear('created_at', Carbon::now()->subMonths($i)->year)
                                ->whereMonth('created_at', Carbon::now()->subMonths($i)->month)
                                ->count(),
            ];
            $transactionGrowth[] = [
                'month' => Carbon::now()->subMonths($i)->format('M Y'),
                'count' => Transaction::whereYear('transaction_date', Carbon::now()->subMonths($i)->year)
                                    ->whereMonth('transaction_date', Carbon::now()->subMonths($i)->month)
                                    ->count(),
            ];
        }

        // Kategori terpopuler (paling sering dipakai user)
        $topCategories = Transaction::join('luthfi_categories', 'luthfi_transactions.category_id', '=', 'luthfi_categories.id')
            ->select('luthfi_categories.name', DB::raw('COUNT(luthfi_transactions.id) as total'))
            ->groupBy('luthfi_categories.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalTransaksiHari',
            'totalTransaksiBulan',
            'totalTransaksiTahun',
            'totalIncome',
            'totalExpense',
            'userGrowth',
            'transactionGrowth',
            'topCategories',
        ));
    }
} 