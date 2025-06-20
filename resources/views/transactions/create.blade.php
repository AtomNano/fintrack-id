<!-- File: resources/views/transactions/create.blade.php -->
@extends('layouts.app')
@section('title', 'Tambah Transaksi')
@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Transaksi Baru</h1>
    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf
        @include('transactions._form')
    </form>
</div>
@endsection 