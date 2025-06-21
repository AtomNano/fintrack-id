<!-- File: resources/views/admin/categories/edit.blade.php -->
@extends('layouts.admin')

@section('title', 'Edit Kategori Global - Admin Panel')
@section('page-title', 'Edit Kategori: ' . $category->name)
@section('page-description', 'Edit kategori global')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.categories._form', ['category' => $category])
    </form>
</div>
@endsection 