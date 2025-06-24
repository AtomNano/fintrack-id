<!-- File: resources/views/admin/users/_form.blade.php -->
<!-- Name -->
<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nama</label>
    <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" required>
    @error('name') <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p> @enderror
</div>

<!-- Email -->
<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
    <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" required>
    @error('email') <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p> @enderror
</div>

<!-- Role -->
<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="role">Role</label>
    <select name="role" id="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('role') border-red-500 @enderror" required>
        <option value="user" {{ old('role', $user->role ?? '') == 'user' ? 'selected' : '' }}>User</option>
        <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
    </select>
    @error('role') <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p> @enderror
</div>

<!-- Password -->
<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
    <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" {{ isset($user) ? '' : 'required' }}>
    @if(isset($user)) <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password.</p> @endif
    @error('password') <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p> @enderror
</div>

<!-- Password Confirmation -->
<div class="mb-6">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">Konfirmasi Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
</div>

<div class="flex items-center justify-end">
    <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-800 font-bold py-2 px-4 rounded mr-2">Batal</a>
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
        {{ isset($user) ? 'Perbarui' : 'Simpan' }} Pengguna
    </button>
</div> 