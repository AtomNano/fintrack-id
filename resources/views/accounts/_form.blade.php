<div class="mb-4">
    <label class="block text-white text-sm font-bold mb-2" for="name">Nama Akun</label>
    <input type="text" name="name" id="name" value="{{ old('name', $account->name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-white placeholder-white" placeholder="e.g., Bank BCA, GoPay, Dompet Tunai" required>
</div>

<div class="mb-4">
    <label class="block text-white text-sm font-bold mb-2" for="type">Tipe Akun</label>
    <input type="text" name="type" id="type" value="{{ old('type', $account->type ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-white placeholder-white" placeholder="e.g., E-Wallet, Bank, Uang Tunai" required>
</div>

<div class="mb-6">
    <label class="block text-white text-sm font-bold mb-2" for="balance">Saldo Awal</label>
    <input type="number" step="any" name="balance" id="balance" value="{{ old('balance', $account->balance ?? '0') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-white placeholder-white" required>
    @if(isset($account))
        <p class="text-xs text-gray-500 mt-1">Mengubah saldo di sini tidak akan membuat transaksi baru. Ini hanya untuk koreksi saldo.</p>
    @endif
</div>

<div class="flex items-center justify-end">
    <a href="{{ route('accounts.index') }}" class="text-gray-600 hover:text-gray-800 font-bold py-2 px-4 rounded mr-2">Batal</a>
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">{{ isset($account) ? 'Perbarui' : 'Simpan' }}</button>
</div>

<style>
    input::placeholder, textarea::placeholder {
        color: #fff !important;
        opacity: 1 !important;
    }
</style> 