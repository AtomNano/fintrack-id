<!-- File: resources/views/admin/categories/create.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Kategori Global')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Kategori Global</h1>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        @include('admin.categories._form')
    </form>
</div>
@endsection 