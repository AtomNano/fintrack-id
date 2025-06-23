@extends('layouts.app')

@section('title', 'Selamat Datang di FinTrack ID')

@section('content')
<div class="bg-white w-screen min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gray-50">
        <div class="container mx-auto px-6 py-20 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Kelola Keuangan Pribadi dengan Mudah.
            </h1>
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                FinTrack ID membantu Anda melacak setiap pemasukan dan pengeluaran, membuat anggaran, dan mencapai tujuan finansial Anda.
            </p>
            @guest
                <a href="{{ route('auth') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg transition duration-300 ease-in-out transform hover:scale-105 mr-2">
                    Mulai Sekarang (Gratis)
                </a>
                <a href="{{ route('auth') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg text-lg transition duration-300 ease-in-out">
                    Masuk
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg transition duration-300 ease-in-out transform hover:scale-105">
                    Buka Dashboard
                </a>
            @endguest
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-20">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Fitur Unggulan Kami</h2>
            <div class="flex flex-wrap -mx-4">
                <!-- Feature 1 -->
                <div class="w-full md:w-1/3 px-4 mb-8">
                    <div class="bg-white p-8 rounded-lg shadow-md text-center h-full">
                        <div class="text-blue-600 mb-4">
                            <i class="fa-solid fa-money-bill-transfer text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Catat Transaksi</h3>
                        <p class="text-gray-600">
                            Catat semua transaksi pemasukan dan pengeluaran Anda dengan cepat dan detail, di mana saja dan kapan saja.
                        </p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="w-full md:w-1/3 px-4 mb-8">
                    <div class="bg-white p-8 rounded-lg shadow-md text-center h-full">
                        <div class="text-blue-600 mb-4">
                            <i class="fa-solid fa-bullseye text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Anggaran Cerdas</h3>
                        <p class="text-gray-600">
                            Buat anggaran bulanan untuk setiap kategori agar pengeluaran tetap terkontrol dan sesuai rencana.
                        </p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="w-full md:w-1/3 px-4 mb-8">
                    <div class="bg-white p-8 rounded-lg shadow-md text-center h-full">
                        <div class="text-blue-600 mb-4">
                            <i class="fa-solid fa-chart-pie text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Laporan Insightful</h3>
                        <p class="text-gray-600">
                            Dapatkan laporan visual yang mudah dipahami untuk menganalisis kebiasaan finansial Anda secara mendalam.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gray-800 text-white">
        <div class="container mx-auto px-6 py-16 text-center">
            <h2 class="text-3xl font-bold mb-4">Siap Mengambil Kendali Finansial Anda?</h2>
            <p class="text-gray-300 mb-8 max-w-xl mx-auto">Bergabunglah dengan ribuan pengguna lain dan mulailah perjalanan finansial Anda yang lebih baik hari ini.</p>
            @guest
            <a href="{{ route('auth') }}" class="bg-white hover:bg-gray-200 text-gray-800 font-bold py-3 px-6 rounded-lg text-lg transition duration-300 ease-in-out transform hover:scale-105">
                Daftar Sekarang
            </a>
            @endguest
        </div>
    </div>
</div>
@endsection
