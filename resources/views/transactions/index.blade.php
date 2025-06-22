<!-- File: resources/views/transactions/index.blade.php -->
@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Daftar Transaksi</h1>
    <!-- buat tombol dikanan -->
    <div class="flex justify-end">
        <button id="add-transaction-btn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-plus"></i> Tambah Transaksi Baru
        </button>
    </div>

    
    {{-- Transactions Table --}}
    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akun</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($transactions as $transaction)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->transaction_date->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->account->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="font-semibold {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($transaction->amount, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <button class="edit-btn text-indigo-600 hover:text-indigo-900"
                                    data-id="{{ $transaction->id }}"
                                    data-type="{{ $transaction->type }}"
                                    data-amount="{{ $transaction->amount }}"
                                    data-category_id="{{ $transaction->category_id }}"
                                    data-account_id="{{ $transaction->account_id }}"
                                    data-transaction_date="{{ $transaction->transaction_date->format('Y-m-d') }}"
                                    data-description="{{ $transaction->description }}"
                                    data-action="{{ route('transactions.update', $transaction) }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 ml-4"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Tidak ada transaksi ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $transactions->links() }}
</div>

{{-- Create Modal --}}
<div id="create-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-10">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                Tambah Transaksi Baru
                            </h3>
                            <div class="mt-2">
                                @include('transactions._form', ['categories' => $categories, 'accounts' => $accounts])
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div id="edit-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-10">
            <form method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                Edit Transaksi
                            </h3>
                            <div class="mt-2">
                                @include('transactions._form', ['categories' => $categories, 'accounts' => $accounts])
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const createModal = document.getElementById('create-modal');
    const editModal = document.getElementById('edit-modal');
    const addBtn = document.getElementById('add-transaction-btn');
    const editBtns = document.querySelectorAll('.edit-btn');
    const closeBtns = document.querySelectorAll('.close-modal');

    function openModal(modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    addBtn.addEventListener('click', () => {
        openModal(createModal);
    });

    editBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const data = btn.dataset;
            const form = editModal.querySelector('form');

            form.action = data.action;
            form.querySelector('select[name="type"]').value = data.type;
            form.querySelector('input[name="amount"]').value = data.amount;
            form.querySelector('select[name="category_id"]').value = data.category_id;
            form.querySelector('select[name="account_id"]').value = data.account_id;
            form.querySelector('input[name="transaction_date"]').value = data.transaction_date;
            form.querySelector('textarea[name="description"]').value = data.description;
            
            openModal(editModal);
        });
    });

    // Close modal when clicking close button
    closeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = btn.closest('.fixed');
            closeModal(modal);
        });
    });

    // Close modal when clicking on backdrop
    [createModal, editModal].forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal(modal);
            }
        });
    });

    // Close modal with Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (!createModal.classList.contains('hidden')) {
                closeModal(createModal);
            }
            if (!editModal.classList.contains('hidden')) {
                closeModal(editModal);
            }
        }
    });
});
</script>
@endpush 