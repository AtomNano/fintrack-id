@extends('layouts.app')
@section('title', 'Tambah Akun Baru')
@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Akun Baru</h1>
    <form action="{{ route('accounts.store') }}" method="POST">
        @csrf
        @include('accounts._form')
    </form>
</div>
@endsection 