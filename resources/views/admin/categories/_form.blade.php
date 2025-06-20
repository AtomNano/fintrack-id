<!-- File: resources/views/admin/categories/_form.blade.php -->
<!-- Name -->
<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nama Kategori</label>
    <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" required>
    @error('name') <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p> @enderror
</div>

<!-- Type -->
<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="type">Tipe</label>
    <select name="type" id="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('type') border-red-500 @enderror" required>
        <option value="expense" {{ old('type', $category->type ?? '') == 'expense' ? 'selected' : '' }}>Expense (Pengeluaran)</option>
        <option value="income" {{ old('type', $category->type ?? '') == 'income' ? 'selected' : '' }}>Income (Pemasukan)</option>
    </select>
    @error('type') <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p> @enderror
</div>

<!-- Icon -->
<div class="mb-6">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="icon">Kelas Ikon FontAwesome</label>
    <input type="text" name="icon" id="icon" value="{{ old('icon', $category->icon ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('icon') border-red-500 @enderror" placeholder="e.g., fa-solid fa-utensils">
    @error('icon') <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p> @enderror
</div>

<div class="flex items-center justify-end">
    <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-800 font-bold py-2 px-4 rounded mr-2">Batal</a>
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
        {{ isset($category) ? 'Update' : 'Simpan' }} Kategori
    </button>
</div> 