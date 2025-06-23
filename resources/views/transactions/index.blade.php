<!-- File: resources/views/transactions/index.blade.php -->
@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4 text-white">Daftar Transaksi</h1>
    <div class="flex justify-end mb-4">
        <button id="add-transaction-btn" class="bg-white/20 hover:bg-white/30 text-white font-bold py-2 px-4 rounded-lg border border-white/20 transition">
            <i class="fas fa-plus"></i> Tambah Transaksi Baru
        </button>
    </div>

    {{-- Transactions Table --}}
    <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 my-6 text-white overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead class="bg-white/10 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Akun</th>
                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-transparent text-white divide-y divide-white/10">
                @forelse ($transactions as $transaction)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->transaction_date->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->account->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="font-semibold {{ $transaction->type == 'income' ? 'text-green-400' : 'text-red-400' }}">
                                {{ number_format($transaction->amount, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <button class="edit-btn bg-white/10 hover:bg-white/20 text-blue-400 font-bold py-1 px-3 rounded-lg border border-white/20 transition mr-2"
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
                                <button type="submit" class="bg-white/10 hover:bg-white/20 text-red-400 font-bold py-1 px-3 rounded-lg border border-white/20 transition ml-2"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-300">Tidak ada transaksi ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
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

    function setupCategoryFilter(form) {
        const typeRadios = form.querySelectorAll('input[name="type"]');
        const categorySelect = form.querySelector('select[name="category_id"]');
        if (!categorySelect || categorySelect.dataset.allOptions) { // if no select or already initialized
            return;
        }

        const allOptions = Array.from(categorySelect.options).map(opt => ({
            value: opt.value,
            text: opt.text,
            type: opt.dataset.type
        }));
        categorySelect.dataset.allOptions = JSON.stringify(allOptions);

        function filterCategories() {
            const selectedType = form.querySelector('input[name="type"]:checked').value;
            const currentCategoryValue = categorySelect.value;
            
            categorySelect.innerHTML = '';

            JSON.parse(categorySelect.dataset.allOptions).forEach(optionData => {
                if (optionData.value === "" || optionData.type === selectedType) {
                    const option = new Option(optionData.text, optionData.value);
                    option.dataset.type = optionData.type;
                    categorySelect.add(option);
                }
            });
            
            const newOptionExists = Array.from(categorySelect.options).some(opt => opt.value === currentCategoryValue);
            if(newOptionExists) {
                categorySelect.value = currentCategoryValue;
            } else {
                categorySelect.value = "";
            }
        }

        typeRadios.forEach(radio => radio.addEventListener('change', filterCategories));
        form.filterCategories = filterCategories; // Attach filter function to the form
    }

    // Setup for both modals
    setupCategoryFilter(createModal.querySelector('form'));
    setupCategoryFilter(editModal.querySelector('form'));

    addBtn.addEventListener('click', () => {
        const form = createModal.querySelector('form');
        form.reset();
        
        // set defaults
        form.querySelector('input[name="type"][value="expense"]').checked = true;
        form.querySelector('input[name="transaction_date"]').value = "{{ now()->format('Y-m-d') }}";
        
        if (form.filterCategories) {
            form.filterCategories();
        }

        openModal(createModal);
    });

    editBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const data = btn.dataset;
            const form = editModal.querySelector('form');

            form.action = data.action;
            form.querySelector(`input[name="type"][value="${data.type}"]`).checked = true;
            form.querySelector('input[name="amount"]').value = data.amount;
            form.querySelector('select[name="account_id"]').value = data.account_id;
            form.querySelector('input[name="transaction_date"]').value = data.transaction_date;
            form.querySelector('textarea[name="description"]').value = data.description;
            
            // Filter categories based on type, then set category
            if (form.filterCategories) {
                form.filterCategories();
            }
            form.querySelector('select[name="category_id"]').value = data.category_id;
            
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