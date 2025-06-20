<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        // Ambil semua kategori pengeluaran
        $expenseCategories = Category::where('type', 'expense')
            ->where(function ($query) use ($user) {
                $query->whereNull('user_id')->orWhere('user_id', $user->id);
            })->get();
        
        // Ambil data budget yang sudah ada
        $budgets = Budget::where('user_id', $user->id)
            ->where('month', $month)
            ->where('year', $year)
            ->pluck('amount', 'category_id');
            
        // Ambil total pengeluaran per kategori untuk bulan ini
        $spendings = DB::table('transactions')
            ->where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->select('category_id', DB::raw('SUM(amount) as total_spent'))
            ->groupBy('category_id')
            ->pluck('total_spent', 'category_id');

        return view('budgets.index', compact('expenseCategories', 'budgets', 'spendings', 'month', 'year'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'budgets' => 'required|array',
            'budgets.*' => 'nullable|numeric|min:0',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:2000',
        ]);
        
        $user = Auth::user();

        foreach ($request->budgets as $categoryId => $amount) {
            if (is_null($amount)) {
                // Hapus budget jika amount dikosongkan
                Budget::where('user_id', $user->id)
                    ->where('category_id', $categoryId)
                    ->where('month', $request->month)
                    ->where('year', $request->year)
                    ->delete();
            } else {
                // Buat atau update budget
                Budget::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'category_id' => $categoryId,
                        'month' => $request->month,
                        'year' => $request->year,
                    ],
                    ['amount' => $amount]
                );
            }
        }

        return redirect()->route('budgets.index', ['month' => $request->month, 'year' => $request->year])
            ->with('success', 'Anggaran berhasil disimpan.');
    }
} 