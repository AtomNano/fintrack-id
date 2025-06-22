<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TransactionController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = $user->transactions()->with(['category', 'account'])->latest('transaction_date');

        // Filtering logic
        if ($request->filled('filter_month')) {
            $query->whereMonth('transaction_date', $request->filter_month);
        }
        if ($request->filled('filter_year')) {
            $query->whereYear('transaction_date', $request->filter_year);
        }
        if ($request->filled('filter_category_id')) {
            $query->where('category_id', $request->filter_category_id);
        }
        
        $transactions = $query->paginate(15);
        $categories = $user->categories()->orWhereNull('user_id')->get();
        $accounts = $user->accounts()->get();
        $years = $user->transactions()->selectRaw('YEAR(transaction_date) as year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('transactions.index', compact('transactions', 'categories', 'accounts', 'years'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('transactions.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:luthfi_categories,id',
            'account_id' => 'required|exists:luthfi_accounts,id,user_id,' . Auth::id(),
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $user = Auth::user();
            $transaction = $user->transactions()->create($request->all());

            // Update account balance
            $account = Account::find($request->account_id);
            if ($request->type == 'income') {
                $account->balance += $request->amount;
            } else {
                $account->balance -= $request->amount;
            }
            $account->save();
        });

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        return redirect()->route('transactions.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:luthfi_categories,id',
            'account_id' => 'required|exists:luthfi_accounts,id,user_id,' . Auth::id(),
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $transaction) {
            // Revert old balance
            $oldAccount = Account::find($transaction->account_id);
            if ($transaction->type == 'income') {
                $oldAccount->balance -= $transaction->amount;
            } else {
                $oldAccount->balance += $transaction->amount;
            }
            $oldAccount->save();

            // Update transaction
            $transaction->update($request->all());

            // Apply new balance
            $newAccount = Account::find($request->account_id);
            if ($request->type == 'income') {
                $newAccount->balance += $request->amount;
            } else {
                $newAccount->balance -= $request->amount;
            }
            $newAccount->save();
        });

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);

        DB::transaction(function () use ($transaction) {
            // Revert balance before deleting
            $account = Account::find($transaction->account_id);
            if ($transaction->type == 'income') {
                $account->balance -= $transaction->amount;
            } else {
                $account->balance += $transaction->amount;
            }
            $account->save();

            $transaction->delete(); // Ini akan soft delete
        });

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
} 