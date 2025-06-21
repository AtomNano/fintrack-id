<!-- File: resources/views/admin/users/create.blade.php -->
@extends('layouts.admin')

@section('title', 'Tambah Pengguna Baru - Admin Panel')
@section('page-title', 'Tambah Pengguna Baru')
@section('page-description', 'Buat pengguna baru dalam sistem')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Pengguna Baru</h1>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        @include('admin.users._form')
    </form>
</div>
@endsection 