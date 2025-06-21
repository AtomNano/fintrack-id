<!-- File: resources/views/admin/categories/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Manajemen Kategori Global - Admin Panel')
@section('page-title', 'Manajemen Kategori Global')
@section('page-description', 'Kelola kategori default untuk semua pengguna')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Kategori Global</h1>
        <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Kategori
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
             <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-center">Ikon</th>
                    <th class="py-3 px-6 text-left">Nama</th>
                    <th class="py-3 px-6 text-center">Tipe</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($categories as $category)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-center"><i class="{{ $category->icon }} fa-lg"></i></td>
                    <td class="py-3 px-6 text-left">{{ $category->name }}</td>
                    <td class="py-3 px-6 text-center">
                        <span class="bg-{{ $category->type === 'income' ? 'green' : 'red' }}-200 text-{{ $category->type === 'income' ? 'green' : 'red' }}-600 py-1 px-3 rounded-full text-xs">{{ $category->type }}</span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-2 transform hover:scale-110">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center transform hover:scale-110">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4">Tidak ada data kategori global.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $categories->links() }}
    </div>
</div>
@endsection 