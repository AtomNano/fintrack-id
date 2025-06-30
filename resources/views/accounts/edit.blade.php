@extends('layouts.app')
@section('title', 'Edit Akun')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-2xl shadow-md text-white">
        <h1 class="text-2xl font-bold text-white mb-6">Edit Akun</h1>
        <form action="{{ route('accounts.update', $account->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('accounts._form', ['account' => $account])
        </form>
    </div>
</div>
@endsection 