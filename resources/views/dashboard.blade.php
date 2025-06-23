@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen glassmorphism">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">
                    Welcome Back, {{ Auth::user()->name }} 👋
                </h1>
                <p class="text-gray-300">Here's what's happening with your financial data today.</p>
            </div>
            <div class="relative">
                <input type="text" 
                       placeholder="Search for anything..." 
                       class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl px-4 py-2 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 w-64">
                <i class="fas fa-search absolute right-3 top-3 text-gray-300"></i>
            </div>
        </div>

        <!-- Quick Access Section -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-white mb-4">Quick Access</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Transaction Management Card -->
                <a href="{{ route('transactions.index') }}" class="block bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 hover:bg-white/20 transition-all duration-300 group">
                    <div class="flex items-center">
                        <div class="bg-cyan-500/20 text-cyan-400 p-3 rounded-xl mr-4 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-money-bill-transfer fa-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Transaction Management</h3>
                            <p class="text-gray-300">View, add, edit, and delete your transactions.</p>
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
                            <h3 class="text-xl font-bold text-white">Budget Management</h3>
                            <p class="text-gray-300">Set monthly budget for each category.</p>
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
                                <p class="text-gray-300 text-sm">Total Income</p>
                                <h3 class="text-2xl font-bold text-white">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                                <span class="text-green-400 text-sm">+1.2% ↗</span>
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
                                <p class="text-gray-300 text-sm">Total Outcome</p>
                                <h3 class="text-2xl font-bold text-white">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                                <span class="text-red-400 text-sm">-1.2% ↘</span>
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
                        <h3 class="text-xl font-bold text-white">Analytics</h3>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                <span class="text-gray-300 text-sm">Income</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-cyan-500 rounded-full"></div>
                                <span class="text-gray-300 text-sm">Outcome</span>
                            </div>
                            <select class="bg-white/10 border border-white/20 rounded-lg px-3 py-1 text-white text-sm">
                                <option>2024</option>
                                <option>2023</option>
                            </select>
                        </div>
                    </div>
                    <div class="h-64">
                        <canvas id="analyticsChart"></canvas>
                    </div>
                </div>

                <!-- Transaction Table -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-white">Transaction</h3>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <input type="text" 
                                       placeholder="Search for anything..." 
                                       class="bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-white placeholder-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 w-48">
                                <i class="fas fa-search absolute right-3 top-2.5 text-gray-300 text-sm"></i>
                            </div>
                            <select class="bg-white/10 border border-white/20 rounded-lg px-3 py-2 text-white text-sm">
                                <option>10 May - 20 May</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-gray-300 text-sm">
                                    <th class="pb-4">Name</th>
                                    <th class="pb-4">Date</th>
                                    <th class="pb-4">Amount</th>
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

            <!-- Right Column - Sidebar -->
            <div class="space-y-6 h-full flex flex-col w-full max-w-sm lg:mx-0">
                <!-- My Card -->
                <div class="bg-gradient-to-br from-purple-600 to-blue-600 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-12 -translate-x-12"></div>
                    
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-lg font-bold">My Card</h3>
                                <p class="text-purple-200 text-sm">Card Balance</p>
                                <h2 class="text-2xl font-bold">Rp {{ number_format($totalBalance, 0, ',', '.') }}</h2>
                            </div>
                            <div class="flex space-x-1">
                                <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">M</span>
                                </div>
                                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">C</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <p class="text-lg font-bold">Current Balance</p>
                        <p class="text-2xl font-bold">Rp {{ number_format($totalBalance - $totalExpense + $totalIncome, 0, ',', '.') }}</p>
                    </div>
                    
                    <div class="flex justify-between items-center text-sm">
                        <span>5282 3456 7890 1289</span>
                        <span>09/25</span>
                    </div>
                    
                    <div class="flex space-x-3 mt-4">
                        <button class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-lg text-sm font-medium">
                            Manage Cards
                        </button>
                        <button class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-lg text-sm font-medium">
                            Transfer
                        </button>
                    </div>
                </div>

                <!-- Activity Card -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-white">Activity</h3>
                        <select class="bg-white/10 border border-white/20 rounded-lg px-3 py-1 text-white text-sm">
                            <option>Month</option>
                            <option>Week</option>
                            <option>Year</option>
                        </select>
                    </div>
                    
                    <div class="relative h-40 mb-6">
                        <canvas id="activityChart"></canvas>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-white">75%</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                                <span class="text-gray-300 text-sm">Daily payment</span>
                            </div>
                            <span class="text-white font-medium">55%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-cyan-500 rounded-full"></div>
                                <span class="text-gray-300 text-sm">Hobby</span>
                            </div>
                            <span class="text-white font-medium">20%</span>
                        </div>
                    </div>
                    
                    <button class="w-full bg-white/10 backdrop-blur-md border border-white/20 rounded-lg py-3 text-white font-medium mt-6 hover:bg-white/20 transition-colors">
                        View all activity →
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
                    data: @json(array_map(function($val) { return $val * 1.2; }, $dailyExpenseChart['data'])),
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderRadius: 8,
                    maxBarThickness: 30
                },
                {
                    label: 'Outcome',
                    data: @json($dailyExpenseChart['data']),
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
            datasets: [{
                data: [55, 20, 25],
                backgroundColor: [
                    '#8B5CF6',
                    '#06B6D4',
                    '#374151'
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
                    display: false
                }
            }
        }
    });
</script>
@endsection 