<!-- File: resources/views/budgets/index.blade.php -->
@extends('layouts.app')
@section('title', 'Anggaran Bulanan')
@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Anggaran Bulanan</h1>
    <p class="text-gray-600 mb-6">Atur batas pengeluaran untuk setiap kategori agar keuangan tetap sehat.</p>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('budgets.index') }}" class="mb-6 bg-gray-50 p-4 rounded-lg flex gap-4 items-end">
        <div>
            <label for="month" class="block text-sm font-medium text-gray-700">Bulan</label>
            <select name="month" id="month" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 rounded-md">
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->format('F') }}</option>
                @endfor
            </select>
        </div>
        <div>
            <label for="year" class="block text-sm font-medium text-gray-700">Tahun</label>
            <select name="year" id="year" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 rounded-md">
                @for ($i = now()->year + 1; $i >= now()->year - 5; $i--)
                    <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md">Tampilkan</button>
    </form>

    <form action="{{ route('budgets.store') }}" method="POST">
        @csrf
        <input type="hidden" name="month" value="{{ $month }}">
        <input type="hidden" name="year" value="{{ $year }}">

        <div class="space-y-6">
            @foreach ($expenseCategories as $category)
                @php
                    $budgetAmount = $budgets->get($category->id, 0);
                    $spentAmount = $spendings->get($category->id, 0);
                    $percentage = ($budgetAmount > 0) ? ($spentAmount / $budgetAmount) * 100 : 0;
                    if ($percentage > 100) $percentage = 100;
                    
                    $progressBarColor = 'bg-blue-500'; // default
                    if ($percentage > 90) $progressBarColor = 'bg-red-500';
                    elseif ($percentage > 70) $progressBarColor = 'bg-yellow-500';
                @endphp
                <div class="border p-4 rounded-lg">
                    <div class="flex flex-wrap justify-between items-center gap-4">
                        <div class="flex-grow">
                            <div class="flex items-center mb-2">
                                <i class="{{ $category->icon }} text-xl mr-3 text-gray-600"></i>
                                <span class="font-semibold text-lg">{{ $category->name }}</span>
                            </div>
                            <div class="text-sm text-gray-600">
                                Rp {{ number_format($spentAmount, 0, ',', '.') }} / 
                                <span class="font-bold">Rp {{ number_format($budgetAmount, 0, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                <div class="{{ $progressBarColor }} h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                        <div class="flex-shrink-0 w-full sm:w-auto">
                             <label for="budget_{{ $category->id }}" class="block text-sm font-medium text-gray-700 text-right mb-1">Atur Budget</label>
                             <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                  <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="budgets[{{ $category->id }}]" id="budget_{{ $category->id }}"
                                   value="{{ $budgetAmount > 0 ? $budgetAmount : '' }}" placeholder="0"
                                   class="block w-full rounded-md border-gray-300 pl-8 pr-2 py-2 text-right sm:text-sm focus:border-blue-500 focus:ring-blue-500">
                             </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8 text-right">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg">Simpan Anggaran</button>
        </div>
    </form>
</div>
@endsection 