@extends('layouts.app')
@section('title', 'Manajemen Akun')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-2xl shadow-md text-white">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white">Manajemen Akun (Dompet & Rekening)</h1>
                <p class="text-gray-300 mt-1">Kelola semua akun keuangan Anda di sini.</p>
            </div>
            <a href="{{ route('accounts.create') }}" class="bg-white/20 hover:bg-white/30 text-white font-bold py-2 px-4 rounded-lg border border-white/20 transition">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Akun
            </a>
        </div>

        {{-- Ringkasan Total Saldo --}}
        <div class="mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl p-6 flex items-center shadow-lg">
                <i class="fa-solid fa-wallet text-3xl text-white mr-4"></i>
                <div>
                    <div class="text-lg text-white font-semibold">Total Saldo Seluruh Akun</div>
                    <div class="text-3xl font-bold text-white">
                        Rp {{ number_format($accounts->sum('balance'), 0, ',', '.') }}
                    </div>
                </div>
            </div>
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
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-2xl text-white shadow-md hover:shadow-xl transition-shadow duration-200 group relative">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-bold text-lg text-white flex items-center gap-2">
                                <i class="fa-solid fa-wallet"></i> {{ $account->name }}
                            </h3>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-600/80 text-white">{{ $account->type }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('accounts.edit', $account->id) }}" class="text-blue-400 hover:text-blue-200" title="Edit Akun">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus akun ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-200" title="Hapus Akun"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-300">Saldo Saat Ini</p>
                        <p class="text-3xl font-extrabold text-green-400 group-hover:text-green-300 transition">Rp {{ number_format($account->balance, 0, ',', '.') }}</p>
                    </div>
                    @if(isset($account->created_at))
                    <div class="mt-2 text-xs text-gray-400">
                        Dibuat: {{ $account->created_at->format('d M Y') }}
                    </div>
                    @endif
                </div>
            @empty
                <p class="md:col-span-2 lg:col-span-3 text-center text-gray-300">Anda belum memiliki akun. Silakan tambah akun baru.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection 