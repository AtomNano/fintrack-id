@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen w-screen h-screen bg-gradient-to-b from-[#141332] to-[#3D3A98] flex">
    <!-- Sidebar -->
    <aside class="w-80 h-full bg-[#1D1D41] rounded-2xl flex flex-col justify-between p-6 relative">
        <div>
            <!-- Logo -->
            <div class="flex items-center justify-center mb-12 mt-4">
                <span class="font-bold text-3xl text-white font-sans tracking-wide">FinTrack<span class="text-[#64CFF6]">ID</span></span>
                <span class="ml-2 text-xs font-extrabold text-white">TM</span>
            </div>
            <!-- Navigation -->
            <nav class="space-y-2">
                <a href="#" class="flex items-center px-6 py-3 bg-[#6359E9] rounded-lg text-white font-semibold text-base mb-2">
                    <i class="fa-solid fa-table-columns mr-4"></i> Dashboard
                </a>
                <a href="#" class="flex items-center px-6 py-3 hover:bg-[#27264E] rounded-lg text-white font-normal text-base">
                    <i class="fa-solid fa-chart-bar mr-4"></i> Analytics
                </a>
                <a href="#" class="flex items-center px-6 py-3 hover:bg-[#27264E] rounded-lg text-white font-normal text-base">
                    <i class="fa-solid fa-wallet mr-4"></i> My Wallet
                </a>
                <a href="{{ route('transactions.index') }}" class="flex items-center px-6 py-3 hover:bg-[#27264E] rounded-lg text-white font-normal text-base">
                    <i class="fa-solid fa-right-left mr-4"></i> Transaksi
                </a>
                <a href="{{ route('budgets.index') }}" class="flex items-center px-6 py-3 hover:bg-[#27264E] rounded-lg text-white font-normal text-base">
                    <i class="fa-solid fa-bullseye mr-4"></i> Anggaran
                </a>
                <a href="#" class="flex items-center px-6 py-3 hover:bg-[#27264E] rounded-lg text-white font-normal text-base">
                    <i class="fa-solid fa-user mr-4"></i> Accounts
                </a>
                <a href="#" class="flex items-center px-6 py-3 hover:bg-[#27264E] rounded-lg text-white font-normal text-base">
                    <i class="fa-solid fa-gear mr-4"></i> Settings
                </a>
            </nav>
            <div class="border-t border-[#4B4B99] my-8"></div>
            <!-- Dark Mode Toggle -->
            <div class="flex items-center justify-between px-6 mt-8">
                <div class="flex items-center">
                    <i class="fa-regular fa-moon text-white mr-3"></i>
                    <span class="text-white text-lg">Dark Mode</span>
                </div>
                <div class="w-12 h-7 bg-[#6359E9] rounded-full flex items-center px-1 cursor-pointer">
                    <div class="w-6 h-6 bg-white rounded-full"></div>
                </div>
            </div>
        </div>
        <!-- User Info -->
        <div class="flex items-center mt-8 mb-2">
            <div class="w-14 h-14 rounded-full bg-[#B0F6FF] flex items-center justify-center overflow-hidden mr-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=B0F6FF&color=141332" alt="User" class="w-14 h-14 object-cover" />
            </div>
            <div>
                <div class="text-white font-bold text-lg">{{ Auth::user()->name }}</div>
                <div class="text-[#F0F0FB] text-sm">Web Developer</div>
            </div>
        </div>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        <!-- Welcome & Search -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-white mb-1">Welcome Back, {{ Auth::user()->name }} <span class="inline-block">👋</span></h1>
                <p class="text-[#A6A6A6]">Here's what's happening with your store today.</p>
            </div>
            <div class="relative w-96">
                <input type="text" class="w-full py-2 pl-10 pr-4 rounded-lg bg-[#1D1D41] text-white placeholder-[#AEABD8] border-none focus:ring-2 focus:ring-[#6359E9]" placeholder="Search for anything....">
                <i class="fa-solid fa-search absolute left-3 top-2.5 text-[#AEABD8]"></i>
            </div>
        </div>
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-[#1D1D41] rounded-2xl p-6 flex items-center shadow-md">
                <div class="bg-[#64CFF6] p-3 rounded-lg mr-4"><i class="fa-solid fa-arrow-down text-white text-xl"></i></div>
                <div>
                    <div class="text-[#8C89B4] text-sm font-semibold">Total Income</div>
                    <div class="text-2xl font-bold text-white">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
                    <div class="bg-green-100 bg-opacity-20 text-[#02B15A] text-xs rounded px-2 py-1 inline-block mt-1 font-semibold">+1.29%</div>
                </div>
            </div>
            <div class="bg-[#1D1D41] rounded-2xl p-6 flex items-center shadow-md">
                <div class="bg-[#6359E9] p-3 rounded-lg mr-4"><i class="fa-solid fa-arrow-up text-white text-xl"></i></div>
                <div>
                    <div class="text-[#8C89B4] text-sm font-semibold">Total Outcome</div>
                    <div class="text-2xl font-bold text-white">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
                    <div class="bg-red-100 bg-opacity-20 text-[#E41414] text-xs rounded px-2 py-1 inline-block mt-1 font-semibold">-1.29%</div>
                </div>
            </div>
            <div class="bg-[#1D1D41] rounded-2xl p-6 flex items-center shadow-md">
                <div class="bg-[#3A6FF9] p-3 rounded-lg mr-4"><i class="fa-solid fa-wallet text-white text-xl"></i></div>
                <div>
                    <div class="text-[#8C89B4] text-sm font-semibold">Total Balance</div>
                    <div class="text-2xl font-bold text-white">Rp {{ number_format($totalBalance, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        <!-- Analytics & Card/Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Analytics Chart -->
            <div class="lg:col-span-2 bg-[#1D1D41] rounded-2xl p-6 shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-white">Analytics</h3>
                    <div class="flex items-center space-x-4">
                        <span class="flex items-center"><span class="w-4 h-2 rounded bg-[#6359E9] mr-2"></span><span class="text-white text-sm font-semibold">Income</span></span>
                        <span class="flex items-center"><span class="w-4 h-2 rounded bg-[#64CFF6] mr-2"></span><span class="text-white text-sm font-semibold">Outcome</span></span>
                        <select class="bg-[#27264E] text-[#8C89B4] rounded px-2 py-1 text-xs">
                            <option>2020</option>
                        </select>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="analyticsChart"></canvas>
                </div>
            </div>
            <!-- Card Info & Activity -->
            <div class="flex flex-col gap-6">
                <div class="bg-[#1D1D41] rounded-2xl p-6 shadow-md">
                    <div class="text-white text-lg font-bold mb-2">My Card</div>
                    <div class="bg-gradient-to-br from-[#9C2CF3] to-[#3A6FF9] rounded-xl p-6 mb-4 relative">
                        <div class="text-white text-xs opacity-60 mb-1">Current Balance</div>
                        <div class="text-2xl font-bold text-white mb-2">$5,750.20</div>
                        <div class="flex justify-between items-center text-white text-xs">
                            <span>5282 3456 7890 1289</span>
                            <span>09/25</span>
                        </div>
                        <div class="absolute right-6 top-6"><img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" class="w-10 h-8" alt="Mastercard"></div>
                    </div>
                    <div class="flex gap-2">
                        <button class="bg-[#6359E9] text-white rounded-lg px-4 py-2 font-semibold">Manage Cards</button>
                        <button class="border border-white text-white rounded-lg px-4 py-2 font-semibold">Transfer</button>
                    </div>
                    <div class="text-[#8C89B4] text-sm mt-4">Card Balance</div>
                    <div class="text-white text-xl font-bold">$15,595.015</div>
                </div>
                <div class="bg-[#1D1D41] rounded-2xl p-6 shadow-md">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-white text-lg font-bold">Activity</div>
                        <select class="bg-[#27264E] text-[#8C89B4] rounded px-2 py-1 text-xs">
                            <option>Month</option>
                        </select>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <div class="relative w-48 h-48">
                            <canvas id="activityChart"></canvas>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-white text-3xl font-bold">75%</span>
                            </div>
                        </div>
                        <div class="flex justify-between w-full mt-4">
                            <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#6359E9] mr-2"></span><span class="text-white text-sm">Daily payment</span><span class="ml-2 text-white font-bold">55%</span></div>
                            <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#64CFF6] mr-2"></span><span class="text-white text-sm">Hobby</span><span class="ml-2 text-white font-bold">20%</span></div>
                        </div>
                        <button class="mt-4 text-white underline">View all activity →</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Transactions Table -->
        <div class="bg-[#1D1D41] rounded-2xl p-6 shadow-md mb-8">
            <div class="flex justify-between items-center mb-4">
                <div class="text-white text-xl font-bold">Transaction</div>
                <div class="flex gap-2">
                    <input type="text" class="bg-[#27264E] text-[#AEABD8] rounded px-3 py-2 text-sm" placeholder="Search for anything....">
                    <input type="text" class="bg-[#27264E] text-[#AEABD8] rounded px-3 py-2 text-sm" placeholder="10 May - 20 May">
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-white">
                    <thead>
                        <tr class="text-[#AEABD8] text-sm">
                            <th class="py-2 px-4 text-left">Name</th>
                            <th class="py-2 px-4 text-left">Date</th>
                            <th class="py-2 px-4 text-left">Amount</th>
                            <th class="py-2 px-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions ?? [] as $transaction)
                        <tr>
                            <td class="py-2 px-4 flex items-center gap-2">
                                <span class="w-8 h-8 rounded-full bg-[#EAE5FA] flex items-center justify-center">
                                    <i class="fa-solid fa-receipt text-[#6359E9]"></i>
                                </span>
                                {{ $transaction->category->name ?? '-' }}
                            </td>
                            <td class="py-2 px-4">{{ $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->format('D, d M Y') : '-' }}</td>
                            <td class="py-2 px-4">Rp {{ number_format($transaction->amount, 2, ',', '.') }}</td>
                            <td class="py-2 px-4">
                                <span class="bg-green-100 bg-opacity-20 text-[#02B15A] px-3 py-1 rounded-full text-xs">
                                    {{ $transaction->type === 'income' ? 'Deposited' : 'Spent' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Analytics Bar Chart
const analyticsCtx = document.getElementById('analyticsChart').getContext('2d');
new Chart(analyticsCtx, {
    type: 'bar',
    data: {
        labels: @json($dailyExpenseChart['labels']),
        datasets: [
            {
                label: 'Income',
                data: [12000, 18000, 15000, 20000, 30000, 25000, 18000, 22000], // Example static, replace with your real data if needed
                backgroundColor: '#6359E9',
                borderRadius: 10,
                barThickness: 16,
            },
            {
                label: 'Outcome',
                data: @json($dailyExpenseChart['data']),
                backgroundColor: '#64CFF6',
                borderRadius: 10,
                barThickness: 16,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { color: '#8C89B4' },
                grid: { color: 'rgba(140,137,180,0.2)', borderDash: [4,4] }
            },
            x: {
                ticks: { color: '#8C89B4' },
                grid: { display: false }
            }
        }
    }
});
// Activity Doughnut Chart
const activityCtx = document.getElementById('activityChart').getContext('2d');
new Chart(activityCtx, {
    type: 'doughnut',
    data: {
        labels: ['Daily payment', 'Hobby', 'Other'],
        datasets: [{
            data: [55, 20, 25],
            backgroundColor: ['#6359E9', '#64CFF6', '#3A3A5A'],
            borderWidth: 0,
        }]
    },
    options: {
        cutout: '75%',
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
@endsection 