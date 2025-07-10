@extends('layouts.admin')

@section('title', 'Admin Dashboard - FinTrack ID')
@section('page-title', 'Admin Dashboard')
@section('page-description', 'Kelola sistem FinTrack ID')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Admin Dashboard</h1>
        <p class="text-gray-600">Selamat datang di panel admin FinTrack ID.</p>
    </div>

    
    <!-- Admin Menu Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card Manajemen Pengguna -->
        <a href="{{ route('admin.users.index') }}" class="block bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center">
                <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full mr-4">
                    <i class="fa-solid fa-users fa-lg"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Manajemen Pengguna</h3>
                    <p class="text-gray-500">Lihat, tambah, edit, dan hapus data pengguna.</p>
                </div>
            </div>
        </a>

        <!-- Card Manajemen Kategori Global -->
        <a href="{{ route('admin.categories.index') }}" class="block bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center">
                <div class="bg-teal-100 text-teal-600 p-3 rounded-full mr-4">
                    <i class="fa-solid fa-tags fa-lg"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Kategori Global</h3>
                    <p class="text-gray-500">Kelola kategori default untuk semua pengguna.</p>
                </div>
            </div>
        </a>
    </div>  

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 my-4">
        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 text-gray-900">
            <div class="text-lg font-bold">User Terdaftar</div>
            <div class="text-3xl font-bold mt-2">{{ $totalUsers }}</div>
        </div>
        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 text-gray-900">
            <div class="text-lg font-bold">Transaksi Hari Ini</div>
            <div class="text-3xl font-bold mt-2">{{ $totalTransaksiHari }}</div>
        </div>
        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 text-gray-900">
            <div class="text-lg font-bold">Transaksi Bulan Ini</div>
            <div class="text-3xl font-bold mt-2">{{ $totalTransaksiBulan }}</div>
        </div>
        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 text-gray-900">
            <div class="text-lg font-bold">Transaksi Tahun Ini</div>
            <div class="text-3xl font-bold mt-2">{{ $totalTransaksiTahun }}</div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 text-gray-900">
            <div class="text-lg font-bold">Total Pemasukan</div>
            <div class="text-2xl font-bold mt-2 text-green-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 text-gray-900">
            <div class="text-lg font-bold">Total Pengeluaran</div>
            <div class="text-2xl font-bold mt-2 text-red-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 text-gray-900">
            <div class="text-lg font-bold mb-4">Grafik Pertumbuhan User & Transaksi (6 Bulan Terakhir)</div>
            <canvas id="adminGrowthChart" height="180"></canvas>
        </div>
        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 text-gray-900">
            <div class="text-lg font-bold mb-4">Kategori Terpopuler</div>
            <ol class="list-decimal ml-6">
                @foreach($topCategories as $cat)
                    <li class="mb-2 flex justify-between">
                        <span>{{ $cat->name }}</span>
                        <span class="font-bold">{{ $cat->total }}</span>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('adminGrowthChart').getContext('2d');
const userGrowth = @json($userGrowth);
const transactionGrowth = @json($transactionGrowth);
new Chart(ctx, {
    type: 'line',
    data: {
        labels: userGrowth.map(item => item.month),
        datasets: [
            {
                label: 'User Baru',
                data: userGrowth.map(item => item.count),
                borderColor: '#6366F1',
                backgroundColor: 'rgba(99,102,241,0.2)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Transaksi',
                data: transactionGrowth.map(item => item.count),
                borderColor: '#F59E42',
                backgroundColor: 'rgba(245,158,66,0.2)',
                tension: 0.4,
                fill: true
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: { color: '#111827' }
            }
        },
        scales: {
            x: { ticks: { color: '#111827' }, grid: { color: 'rgba(0,0,0,0.05)' } },
            y: { ticks: { color: '#111827' }, grid: { color: 'rgba(0,0,0,0.05)' } }
        }
    }
});
</script>
@endpush 