@extends('layouts.app')

@section('title', 'Admin Dashboard')

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
@endsection 