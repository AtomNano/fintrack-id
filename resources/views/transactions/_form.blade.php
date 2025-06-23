<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Transaksi</label>
    <div class="flex">
        <label class="mr-4"><input type="radio" name="type" value="expense" {{ old('type', $transaction->type ?? 'expense') == 'expense' ? 'checked' : '' }} class="mr-1"> Pengeluaran</label>
        <label><input type="radio" name="type" value="income" {{ old('type', $transaction->type ?? '') == 'income' ? 'checked' : '' }} class="mr-1"> Pemasukan</label>
    </div>
</div>
<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="amount">Jumlah</label>
    <input type="number" step="any" name="amount" id="amount" value="{{ old('amount', $transaction->amount ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
</div>
<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="category_id">Kategori</label>
    <select name="category_id" id="category_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
        <option value="">Pilih Kategori</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" data-type="{{ $category->type }}" {{ old('category_id', $transaction->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="account_id">Akun</label>
    <select name="account_id" id="account_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
        @foreach($accounts as $account)
            <option value="{{ $account->id }}" {{ old('account_id', $transaction->account_id ?? '') == $account->id ? 'selected' : '' }}>{{ $account->name }} (Rp {{ number_format($account->balance, 0, ',', '.') }})</option>
        @endforeach
    </select>
</div>
<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="transaction_date">Tanggal</label>
    <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date', isset($transaction) ? $transaction->transaction_date->format('Y-m-d') : now()->format('Y-m-d')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
</div>
<div class="mb-6">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Deskripsi</label>
    <textarea name="description" id="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">{{ old('description', $transaction->description ?? '') }}</textarea>
</div>
<div class="flex items-center justify-end space-x-3">
    <button type="button" class="close-modal text-gray-600 hover:text-gray-800 font-bold py-2 px-4 rounded">Batal</button>
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Simpan</button>
</div> 