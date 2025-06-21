<!-- File: resources/views/admin/users/edit.blade.php -->
@extends('layouts.admin')

@section('title', 'Edit Pengguna - Admin Panel')
@section('page-title', 'Edit Pengguna')
@section('page-description', 'Edit data pengguna')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.users._form')
    </form>
</div>
@endsection 