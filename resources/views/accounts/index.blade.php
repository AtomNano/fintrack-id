@extends('layouts.app')
@section('title', 'Manajemen Akun')
@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Akun (Dompet & Rekening)</h1>
        <a href="{{ route('accounts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Akun
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif
     @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($accounts as $account)
            <div class="border p-4 rounded-lg shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-lg">{{ $account->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $account->type }}</p>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ route('accounts.edit', $account->id) }}" class="text-blue-500 hover:text-blue-700 mr-3"><i class="fa-solid fa-pencil"></i></a>
                        <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus akun ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-600">Saldo Saat Ini</p>
                    <p class="text-2xl font-semibold text-gray-800">Rp {{ number_format($account->balance, 0, ',', '.') }}</p>
                </div>
            </div>
        @empty
            <p class="md:col-span-2 lg:col-span-3 text-center text-gray-500">Anda belum memiliki akun. Silakan tambah akun baru.</p>
        @endforelse
    </div>
</div>
@endsection 