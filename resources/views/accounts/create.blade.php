@extends('layouts.app')
@section('title', 'Tambah Akun Baru')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-2xl shadow-md text-white">
        <h1 class="text-2xl font-bold text-white mb-6">Tambah Akun Baru</h1>
        <form action="{{ route('accounts.store') }}" method="POST">
            @csrf
            @include('accounts._form')
        </form>
    </div>
</div>
@endsection 