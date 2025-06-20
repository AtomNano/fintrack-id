@extends('layouts.app')
@section('title', 'Edit Akun')
@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Akun</h1>
    <form action="{{ route('accounts.update', $account->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('accounts._form', ['account' => $account])
    </form>
</div>
@endsection 