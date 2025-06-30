<style>
    .glass-input {
        background-color: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        color: #fff;
    }
    .glass-input:focus {
        background-color: rgba(255, 255, 255, 0.1);
        outline: none;
        box-shadow: 0 0 0 2pxrgb(24, 21, 29);
    }
    .glass-input::placeholder {
        color: #d1d5db;
        opacity: 1;
    }
    /* Style untuk menyembunyikan option kategori */
    .category-option.hidden {
        display: none;
    }
    .error-message {
        color: #ef4444; /* red-500 */
        font-size: 0.875rem; /* text-sm */
        margin-top: 0.5rem; /* mt-2 */
    }
    .glass-input option, .glass-input optgroup {
        color: #111 !important;
</style>

<div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 text-white shadow-xl">
    <div class="mb-4 bg-white/20 backdrop-blur-md px-4 py-2 rounded-xl">
        <label class="block text-white text-sm font-bold mb-2">Jenis Transaksi</label>
        <div class="flex gap-6 items-center">
            <label class="mr-4 flex items-center cursor-pointer">
                <input type="radio" name="type" value="expense" @checked(old('type', optional($transaction)->type ?? 'expense') == 'expense') class="mr-2"> Pengeluaran
            </label>
            <label class="flex items-center cursor-pointer">
                <input type="radio" name="type" value="income" @checked(old('type', optional($transaction)->type ?? '') == 'income') class="mr-2"> Pemasukan
            </label>
        </div>
        @error('type')
            <p class="error-message">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label class="block text-white text-sm font-bold mb-2" for="amount">Jumlah</label>
        <input type="number" step="any" name="amount" id="amount" value="{{ old('amount', optional($transaction)->amount ?? '') }}" class="glass-input shadow appearance-none border rounded w-full py-2 px-3 placeholder-gray-400 @error('amount') border-red-500 @enderror" required>
        @error('amount')
            <p class="error-message">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label class="block text-white text-sm font-bold mb-2" for="category_id">Kategori</label>
        <select name="category_id" id="category_id" class="glass-input text-black shadow appearance-none border rounded w-full py-2 px-3 placeholder-gray-400 @error('category_id') border-red-500 @enderror" required>
            <option value="" class="text-black">Pilih Kategori</option>
            @foreach($categories as $category)
                <option 
                    value="{{ $category->id }}" 
                    data-type="{{ $category->type }}" 
                    @selected(old('category_id', optional($transaction)->category_id ?? '') == $category->id)
                    class="category-option text-black">
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="error-message">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label class="block text-white text-sm font-bold mb-2" for="account_id">Akun</label>
        <select name="account_id" id="account_id" class="glass-input text-black shadow appearance-none border rounded w-full py-2 px-3 placeholder-gray-400 @error('account_id') border-red-500 @enderror" required>
            @foreach($accounts as $account)
                <option value="{{ $account->id }}" @selected(old('account_id', optional($transaction)->account_id ?? '') == $account->id) class="text-black">
                    {{ $account->name }} (Rp {{ number_format($account->balance, 0, ',', '.') }})
                </option>
            @endforeach
        </select>
        @error('account_id')
            <p class="error-message">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label class="block text-white text-sm font-bold mb-2" for="transaction_date">Tanggal</label>
        <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date', optional(optional($transaction)->transaction_date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="glass-input shadow appearance-none border rounded w-full py-2 px-3 placeholder-gray-400 @error('transaction_date') border-red-500 @enderror" required>
        @error('transaction_date')
            <p class="error-message">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label class="block text-white text-sm font-bold mb-2" for="description">Deskripsi</label>
        <textarea name="description" id="description" rows="3" class="glass-input shadow appearance-none border rounded w-full py-2 px-3 placeholder-gray-400">{{ old('description', optional($transaction)->description ?? '') }}</textarea>
        @error('description')
            <p class="error-message">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-end space-x-3">
        <button type="button" class="close-modal text-white hover:bg-blue-700 hover:text-red font-bold py-2 px-4 rounded">Batal</button>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Simpan</button>
    </div>
</div>

{{-- SCRIPT UNTUK FILTER KATEGORI SECARA DINAMIS --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeRadios = document.querySelectorAll('input[name="type"]');
        const categorySelect = document.getElementById('category_id');
        const categoryOptions = categorySelect.querySelectorAll('.category-option');

        function filterCategories() {
            const selectedType = document.querySelector('input[name="type"]:checked').value;
            let hasVisibleOptions = false;

            // Simpan nilai yang sedang terpilih
            const previouslySelectedCategory = categorySelect.value;
            
            // Reset pilihan kategori agar tidak memilih kategori yang tersembunyi
            categorySelect.value = '';

            categoryOptions.forEach(option => {
                if (option.dataset.type === selectedType) {
                    option.classList.remove('hidden');
                    hasVisibleOptions = true;
                    // Jika kategori yang sebelumnya terpilih sesuai dengan tipe baru, pilih kembali
                    if (option.value === previouslySelectedCategory) {
                        categorySelect.value = previouslySelectedCategory;
                    }
                } else {
                    option.classList.add('hidden');
                }
            });
        }

        typeRadios.forEach(radio => radio.addEventListener('change', filterCategories));

        // Jalankan filter saat halaman pertama kali dimuat
        filterCategories();
    });
</script> 