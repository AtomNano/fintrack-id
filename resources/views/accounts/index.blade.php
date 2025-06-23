@extends('layouts.app')
@section('title', 'Manajemen Akun')
@section('content')
<div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-2xl shadow-md text-white">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Manajemen Akun (Dompet & Rekening)</h1>
        <a href="{{ route('accounts.create') }}" class="bg-white/20 hover:bg-white/30 text-white font-bold py-2 px-4 rounded-lg border border-white/20 transition">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Akun
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-500/10 border border-green-400 text-green-300 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif
     @if (session('error'))
        <div class="bg-red-500/10 border border-red-400 text-red-300 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($accounts as $account)
            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-2xl text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-lg text-white">{{ $account->name }}</h3>
                        <p class="text-sm text-gray-300">{{ $account->type }}</p>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ route('accounts.edit', $account->id) }}" class="text-blue-400 hover:text-blue-200 mr-3"><i class="fa-solid fa-pencil"></i></a>
                        <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus akun ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-200"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-300">Saldo Saat Ini</p>
                    <p class="text-2xl font-semibold text-white">Rp {{ number_format($account->balance, 0, ',', '.') }}</p>
                </div>
            </div>
        @empty
            <p class="md:col-span-2 lg:col-span-3 text-center text-gray-300">Anda belum memiliki akun. Silakan tambah akun baru.</p>
        @endforelse
    </div>
</div>
@endsection 