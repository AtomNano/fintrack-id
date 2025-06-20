<!-- File: resources/views/transactions/index.blade.php -->
@extends('layouts.app')
@section('title', 'Daftar Transaksi')
@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="flex flex-wrap justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Transaksi</h1>
        <a href="{{ route('transactions.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Transaksi
        </a>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('transactions.index') }}" class="mb-6 bg-gray-50 p-4 rounded-lg flex flex-wrap gap-4 items-end">
        <div>
            <label for="filter_month" class="block text-sm font-medium text-gray-700">Bulan</label>
            <select name="filter_month" id="filter_month" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                <option value="">Semua</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('filter_month') == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->format('F') }}</option>
                @endfor
            </select>
        </div>
        <div>
            <label for="filter_year" class="block text-sm font-medium text-gray-700">Tahun</label>
            <select name="filter_year" id="filter_year" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                <option value="">Semua</option>
                @foreach ($years as $year)
                    <option value="{{ $year }}" {{ request('filter_year', now()->year) == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="filter_category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
            <select name="filter_category_id" id="filter_category_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                <option value="">Semua</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('filter_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md">Filter</button>
        <a href="{{ route('transactions.index') }}" class="text-gray-600 hover:text-gray-800 font-bold py-2 px-4 rounded-md">Reset</a>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Tanggal</th>
                    <th class="py-3 px-6 text-left">Kategori</th>
                    <th class="py-3 px-6 text-left">Akun</th>
                    <th class="py-3 px-6 text-left">Deskripsi</th>
                    <th class="py-3 px-6 text-right">Pemasukan</th>
                    <th class="py-3 px-6 text-right">Pengeluaran</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($transactions as $transaction)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $transaction->transaction_date->format('d M Y') }}</td>
                    <td class="py-3 px-6 text-left"><i class="{{ $transaction->category->icon }} mr-2"></i>{{ $transaction->category->name }}</td>
                    <td class="py-3 px-6 text-left">{{ $transaction->account->name }}</td>
                    <td class="py-3 px-6 text-left">{{ $transaction->description }}</td>
                    <td class="py-3 px-6 text-right text-green-600 font-semibold">
                        @if($transaction->type == 'income')
                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        @endif
                    </td>
                    <td class="py-3 px-6 text-right text-red-600 font-semibold">
                        @if($transaction->type == 'expense')
                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">
                            <a href="{{ route('transactions.edit', $transaction->id) }}" class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2 transform hover:scale-110">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center transform hover:scale-110">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4">Belum ada transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $transactions->withQueryString()->links() }}</div>
</div>
@endsection 