<!-- File: resources/views/transactions/edit.blade.php -->
@extends('layouts.app')
@section('title', 'Edit Transaksi')
@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Transaksi</h1>
    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('transactions._form', ['transaction' => $transaction])
    </form>
</div>
@endsection 