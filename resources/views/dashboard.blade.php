@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen glassmorphism flex flex-col items-center py-8">
    <!-- Container dengan lebar maksimal agar dashboard tidak sejajar penuh dengan navbar -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">
                    Selamat Datang, {{ Auth::user()->name }} 👋
                </h1>
                <p class="text-gray-300">Berikut adalah ringkasan data keuangan Anda hari ini.</p>
            </div>
            <div class="relative w-full md:w-auto">
                <input type="text" 
                       placeholder="Search for anything..." 
                       class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl px-4 py-2 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 w-full md:w-64">
                <i class="fas fa-search absolute right-3 top-3 text-gray-300"></i>
            </div>
        </div>

        <!-- Quick Access Section -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-white mb-4">Akses Cepat</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Transaction Management Card -->
                <a href="{{ route('transactions.index') }}" class="block bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 hover:bg-white/20 transition-all duration-300 group">
                    <div class="flex items-center">
                        <div class="bg-cyan-500/20 text-cyan-400 p-3 rounded-xl mr-4 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-money-bill-transfer fa-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Kelola Transaksi</h3>
                            <p class="text-gray-300">Lihat, tambah, edit, dan hapus transaksi Anda.</p>
                        </div>
                    </div>
                </a>

                <!-- Budget Management Card -->
                <a href="{{ route('budgets.index') }}" class="block bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 hover:bg-white/20 transition-all duration-300 group">
                    <div class="flex items-center">
                        <div class="bg-orange-500/20 text-orange-400 p-3 rounded-xl mr-4 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-bullseye fa-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Kelola Anggaran</h3>
                            <p class="text-gray-300">Atur anggaran bulanan untuk setiap kategori.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <!-- Left Column - Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Total Income Card -->
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-300 text-sm">Total Pemasukan</p>
                                <h3 class="text-2xl font-bold text-white">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                                
                            </div>
                            <div class="bg-cyan-500/20 p-3 rounded-xl">
                                <i class="fas fa-arrow-down text-cyan-400 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Outcome Card -->
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-300 text-sm">Total Pengeluaran</p>
                                <h3 class="text-2xl font-bold text-white">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                                
                            </div>
                            <div class="bg-purple-500/20 p-3 rounded-xl">
                                <i class="fas fa-arrow-up text-purple-400 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Analytics Chart -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-white">Analitik</h3>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                <span class="text-gray-300 text-sm">Pemasukan</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-cyan-500 rounded-full"></div>
                                <span class="text-gray-300 text-sm">Pengeluaran</span>
                            </div>
                            <form id="yearFilterForm" action="{{ route('transactions.index') }}" method="GET" class="inline">
                                <input type="hidden" name="filter_year" id="filter_year_input">
                                <select id="yearSelect" class="bg-white/10 border border-white/20 rounded-lg px-3 py-1 text-white text-sm">
                                    @foreach($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="ml-2 bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded transition">Lihat Transaksi</button>
                            </form>
                        </div>
                    </div>
                    <div class="h-64">
                        <canvas id="analyticsChart"></canvas>
                    </div>
                </div>

                <!-- Transaction Table -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">   
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-white">Transaksi</h3>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <input type="text" 
                                       placeholder="Cari apapun..." 
                                       class="bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-white placeholder-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 w-48">
                                <i class="fas fa-search absolute right-3 top-2.5 text-gray-300 text-sm"></i>
                            </div>
                            <select class="bg-white/10 border border-white/20 rounded-lg px-3 py-2 text-white text-sm">
                                <option>10 Mei - 20 Mei</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-gray-300 text-sm">
                                    <th class="pb-4">Nama</th>
                                    <th class="pb-4">Tanggal</th>
                                    <th class="pb-4">Jumlah</th>
                                    <th class="pb-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-white">
                                @forelse($recentTransactions as $transaction)
                                    <tr class="border-t border-white/10">
                                        <td class="py-4">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-shopping-cart text-white text-xs"></i>
                                                </div>
                                                <span>{{ $transaction->category->name ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 text-gray-300">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('D, d M Y') }}</td>
                                        <td class="py-4">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                        <td class="py-4">
                                            <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm">
                                                {{ ucfirst($transaction->status ?? 'Completed') }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-gray-300">Tidak ada transaksi terbaru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar Desktop -->
            <div class="space-y-6 h-full flex flex-col w-full max-w-sm lg:mx-0 lg:flex hidden">
                <!-- My Card -->
                <div class="bg-gradient-to-br from-purple-600 to-blue-600 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-12 -translate-x-12"></div>
                    
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-lg font-bold">Kartu Saya</h3>
                                <p class="text-purple-200 text-sm">Saldo Kartu</p>
                                <h2 class="text-2xl font-bold">Rp {{ number_format($totalBalance, 0, ',', '.') }}</h2>
                            </div>
                            
                        </div>
                    </div>

                    <div class="mb-6">
                        <p class="text-lg font-bold">Saldo Saat Ini</p>
                        <p class="text-2xl font-bold">Rp {{ number_format($totalBalance - $totalExpense + $totalIncome, 0, ',', '.') }}</p>
                    </div>
                    
                    <div class="flex space-x-3 mt-4">
                        <a href="{{ route('accounts.index') }}" class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-lg text-sm font-medium">
                            Kelola Kartu
                        </a>
                        <a href="{{ route('transactions.create') }}" class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-lg text-sm font-medium">
                            Transfer
                        </a>
                    </div>
                </div>

                <!-- Activity Card -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-white">Aktivitas</h3>
                        <select class="bg-white/10 border border-white/20 rounded-lg px-3 py-1 text-white text-sm">
                            <option>Bulan</option>
                            <option>Minggu</option>
                            <option>Tahun</option>
                        </select>
                    </div>
                    
                    <div class="relative h-40 mb-6">
                        <canvas id="activityChart"></canvas>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        @foreach($expensePercentages as $item)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                                <span class="text-gray-300 text-sm">{{ $item['name'] }}</span>
                            </div>
                            <span class="text-white font-medium">{{ $item['percentage'] }}%</span>
                        </div>
                        @endforeach
                    </div>
                    
                    <button class="w-full bg-white/10 backdrop-blur-md border border-white/20 rounded-lg py-3 text-white font-medium mt-6 hover:bg-white/20 transition-colors" onclick="window.location='{{ route('transactions.index') }}'" type="button">
                        Lihat semua aktivitas →
                    </button>   
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Analytics Chart
    const analyticsCtx = document.getElementById('analyticsChart');
    new Chart(analyticsCtx, {
        type: 'bar',
        data: {
            labels: @json($dailyExpenseChart['labels']),
            datasets: [
                {
                    label: 'Income',
                    data: @json($dailyExpenseChart['income']),
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderRadius: 8,
                    maxBarThickness: 30
                },
                {
                    label: 'Outcome',
                    data: @json($dailyExpenseChart['expense']),
                    backgroundColor: 'rgba(6, 182, 212, 0.8)',
                    borderRadius: 8,
                    maxBarThickness: 30
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#9CA3AF'
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: '#9CA3AF'
                    },
                    beginAtZero: true
                }
            }
        }
    });

    // Activity Doughnut Chart
    const activityCtx = document.getElementById('activityChart');
    new Chart(activityCtx, {
        type: 'doughnut',
        data: {
            labels: @json(array_column($expensePercentages, 'name')),
            datasets: [{
                data: @json(array_column($expensePercentages, 'percentage')),
                backgroundColor: [
                    '#8B5CF6', '#06B6D4', '#F59E42', '#F43F5E', '#10B981', '#FBBF24', '#6366F1', '#A3E635', '#F472B6', '#374151'
                ],
                borderWidth: 0,
                cutout: '70%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: '#fff',
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.parsed || 0;
                            return label + ': ' + value + '%';
                        }
                    }
                }
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const yearSelect = document.getElementById('yearSelect');
        const filterYearInput = document.getElementById('filter_year_input');
        const yearForm = document.getElementById('yearFilterForm');
        if (yearSelect && filterYearInput && yearForm) {
            yearForm.addEventListener('submit', function(e) {
                filterYearInput.value = yearSelect.value;
            });
        }
    });
</script>
@endsection