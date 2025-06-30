@extends('layouts.app')

@section('title', 'Selamat Datang di FinTrack ID')

@section('content')
<<<<<<< HEAD
<div class="bg-white w-screen min-h-screen">
=======
<div class="min-h-screen flex flex-col justify-center items-center">
>>>>>>> 302a2af242fdd52b4c1ca798224d0aa19e5bb93d
    <!-- Hero Section -->
    <div class="glassmorphism bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl px-8 py-16 mt-12 mb-8 w-full max-w-3xl text-center shadow-xl">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
            Kelola Keuangan Pribadi dengan Mudah.
        </h1>
        <p class="text-lg text-gray-200 mb-8 max-w-2xl mx-auto">
            FinTrack ID membantu Anda melacak setiap pemasukan dan pengeluaran, membuat anggaran, dan mencapai tujuan finansial Anda.
        </p>
        @guest
            <a href="{{ route('auth') }}" class="bg-white/20 hover:bg-white/30 text-white font-bold py-3 px-6 rounded-lg text-lg transition duration-300 ease-in-out transform hover:scale-105 mr-2 border border-white/20">
                Mulai Sekarang (Gratis)
            </a>
            <a href="{{ route('auth') }}" class="bg-white/10 hover:bg-white/20 text-white font-bold py-3 px-6 rounded-lg text-lg transition duration-300 ease-in-out border border-white/20">
                Masuk
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="bg-white/20 hover:bg-white/30 text-white font-bold py-3 px-6 rounded-lg text-lg transition duration-300 ease-in-out transform hover:scale-105 border border-white/20">
                Buka Dashboard
            </a>
        @endguest
    </div>

    <!-- Features Section -->
    <div class="py-12 w-full max-w-6xl">
        <h2 class="text-3xl font-bold text-center text-white mb-12">Fitur Unggulan Kami</h2>
        <div class="flex flex-wrap -mx-4">
            <!-- Feature 1 -->
            <div class="w-full md:w-1/3 px-4 mb-8">
                <div class="glassmorphism bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-2xl shadow-md text-center h-full">
                    <div class="text-blue-400 mb-4">
                        <i class="fa-solid fa-money-bill-transfer text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-white">Catat Transaksi</h3>
                    <p class="text-gray-200">
                        Catat semua transaksi pemasukan dan pengeluaran Anda dengan cepat dan detail, di mana saja dan kapan saja.
                    </p>
                </div>
            </div>
            <!-- Feature 2 -->
            <div class="w-full md:w-1/3 px-4 mb-8">
                <div class="glassmorphism bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-2xl shadow-md text-center h-full">
                    <div class="text-blue-400 mb-4">
                        <i class="fa-solid fa-bullseye text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-white">Anggaran Cerdas</h3>
                    <p class="text-gray-200">
                        Buat anggaran bulanan untuk setiap kategori agar pengeluaran tetap terkontrol dan sesuai rencana.
                    </p>
                </div>
            </div>
            <!-- Feature 3 -->
            <div class="w-full md:w-1/3 px-4 mb-8">
                <div class="glassmorphism bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-2xl shadow-md text-center h-full">
                    <div class="text-blue-400 mb-4">
                        <i class="fa-solid fa-chart-pie text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-white">Laporan Insightful</h3>
                    <p class="text-gray-200">
                        Dapatkan laporan visual yang mudah dipahami untuk menganalisis kebiasaan finansial Anda secara mendalam.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="glassmorphism bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl px-8 py-12 w-full max-w-3xl text-center mt-8 mb-16">
        <h2 class="text-3xl font-bold mb-4 text-white">Siap Mengambil Kendali Finansial Anda?</h2>
        <p class="text-gray-200 mb-8 max-w-xl mx-auto">Bergabunglah dengan ribuan pengguna lain dan mulailah perjalanan finansial Anda yang lebih baik hari ini.</p>
        @guest
        <a href="{{ route('auth') }}" class="bg-white/20 hover:bg-white/30 text-white font-bold py-3 px-6 rounded-lg text-lg transition duration-300 ease-in-out transform hover:scale-105 border border-white/20">
            Daftar Sekarang
        </a>
        @endguest
    </div>
</div>
@endsection
