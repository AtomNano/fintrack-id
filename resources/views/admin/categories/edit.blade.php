<!-- File: resources/views/admin/categories/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Kategori Global')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Kategori: {{ $category->name }}</h1>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.categories._form', ['category' => $category])
    </form>
</div>
@endsection 