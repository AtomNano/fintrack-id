@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Navigation Cards -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Akses Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card Manajemen Transaksi -->
            <a href="{{ route('transactions.index') }}" class="block bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="bg-cyan-100 text-cyan-600 p-3 rounded-full mr-4">
                        <i class="fa-solid fa-money-bill-transfer fa-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Manajemen Transaksi</h3>
                        <p class="text-gray-500">Lihat, tambah, edit, dan hapus transaksi Anda.</p>
                    </div>
                </div>
            </a>

            <!-- Card Manajemen Anggaran -->
            <a href="{{ route('budgets.index') }}" class="block bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="bg-orange-100 text-orange-600 p-3 rounded-full mr-4">
                        <i class="fa-solid fa-bullseye fa-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Atur Anggaran</h3>
                        <p class="text-gray-500">Tetapkan budget bulanan untuk setiap kategori.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-bold">Selamat Datang Kembali, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-600">Berikut adalah ringkasan keuangan Anda bulan ini.</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Card Pemasukan -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="bg-green-100 text-green-600 p-3 rounded-full mr-4">
                    <i class="fa-solid fa-arrow-down fa-lg"></i>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold">Pemasukan Bulan Ini</h3>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <!-- Card Pengeluaran -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="bg-red-100 text-red-600 p-3 rounded-full mr-4">
                    <i class="fa-solid fa-arrow-up fa-lg"></i>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold">Pengeluaran Bulan Ini</h3>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <!-- Card Saldo -->
        <div class="bg-white p-6 rounded-lg shadow-md">
             <div class="flex items-center">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full mr-4">
                    <i class="fa-solid fa-wallet fa-lg"></i>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm font-semibold">Total Saldo Akun</h3>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalBalance, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart and Insights -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4">Grafik Pengeluaran Harian (30 Hari Terakhir)</h3>
            <div class="h-64">
                <canvas id="dailyExpenseChart"></canvas>
            </div>
        </div>

        <!-- Insights -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4">Insight Keuangan</h3>
            @if($topCategory)
            <ul class="space-y-4">
                <li class="flex items-start">
                    <div class="bg-yellow-100 text-yellow-600 p-2 rounded-full mr-3 mt-1">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold">Pengeluaran Terbesar</h4>
                        <p class="text-gray-600">{{ $topCategory->name }}</p>
                        <p class="font-bold text-sm">Rp {{ number_format($topCategory->total, 0, ',', '.') }}</p>
                    </div>
                </li>
            </ul>
            @else
            <p class="text-gray-500">Belum ada data pengeluaran bulan ini untuk ditampilkan.</p>
            @endif
        </div>
    </div>

<!-- Script untuk Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('dailyExpenseChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($dailyExpenseChart['labels']),
            datasets: [{
                label: 'Pengeluaran',
                data: @json($dailyExpenseChart['data']),
                backgroundColor: 'rgba(239, 68, 68, 0.5)',
                borderColor: 'rgba(239, 68, 68, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endsection 