
@extends('layouts.app')

@section('title', 'Masuk atau Daftar - FinTrack ID')

@push('styles')
<style>
    .glass-input {
        background-color: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
    }
    .glass-input:focus {
        background-color: rgba(255, 255, 255, 0.1);
        outline: none;
        box-shadow: 0 0 0 2px #8B5CF6;
    }
    .svg-chart-bar {
        animation: rise 2s ease-in-out infinite alternate;
    }
    @keyframes rise {
        from { transform: scaleY(0.1); }
        to { transform: scaleY(1); }
    }
    [x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4"
     x-data="{ isRegister: @json($errors->has('name') || old('name')) }"
     x-cloak>
    <div class="relative w-full max-w-4xl min-h-[600px] rounded-2xl shadow-2xl overflow-hidden bg-black/30 backdrop-blur-xl border border-white/10">
        <div class="relative h-full grid md:grid-cols-2">
            <!-- Login Form (Left) -->
            <div 
                class="flex flex-col justify-center p-8 text-white transition-all duration-500 md:static absolute inset-0 md:translate-x-0"
                :class="{
                    'opacity-100 pointer-events-auto z-10 md:z-0': !isRegister,
                    'opacity-0 pointer-events-none z-0 md:z-0': isRegister,
                    'md:opacity-100 md:pointer-events-auto': true
                }"
                x-cloak
            >
                <h2 class="text-3xl font-bold mb-6 text-center">Selamat Datang Kembali</h2>
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <input type="email" name="email" placeholder="Alamat Email" class="w-full glass-input rounded-lg px-4 py-3 text-white placeholder-gray-400" value="{{ old('email') }}" required>
                    @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    <input type="password" name="password" placeholder="Password" class="w-full glass-input rounded-lg px-4 py-3 text-white placeholder-gray-400" required>
                    @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center text-gray-400">
                            <input type="checkbox" name="remember" class="form-checkbox rounded text-purple-500 focus:ring-purple-500 border-white/20 bg-white/10">
                            <span class="ml-2">Ingat Saya</span>
                        </label>
                        <a href="#" class="font-semibold text-purple-400 hover:underline">Lupa Password?</a>
                    </div>
                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-300">Masuk</button>
                </form>
                <p class="md:hidden mt-6 text-center text-sm text-gray-400">
                    Belum punya akun?
                    <button @click="isRegister = true" class="font-semibold text-purple-400 hover:underline">Daftar sekarang</button>
                </p>
            </div>
            <!-- Register Form (Right) -->
            <div 
                class="flex flex-col justify-center p-8 text-white transition-all duration-500 md:static absolute inset-0 md:bg-white/5 md:border-l md:border-white/10"
                :class="{
                    'opacity-100 pointer-events-auto z-10 md:z-0': isRegister,
                    'opacity-0 pointer-events-none z-0 md:z-0': !isRegister,
                    'md:opacity-100 md:pointer-events-auto': true
                }"
                x-cloak
            >
                <h2 class="text-3xl font-bold mb-6 text-center">Buat Akun Baru</h2>
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    <input type="text" name="name" placeholder="Nama Lengkap" class="w-full glass-input rounded-lg px-4 py-3 text-white placeholder-gray-400" value="{{ old('name') }}" required>
                    @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    <input type="email" name="email" placeholder="Alamat Email" class="w-full glass-input rounded-lg px-4 py-3 text-white placeholder-gray-400" value="{{ old('email') }}" required>
                    @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    <input type="password" name="password" placeholder="Password" class="w-full glass-input rounded-lg px-4 py-3 text-white placeholder-gray-400" required>
                    @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="w-full glass-input rounded-lg px-4 py-3 text-white placeholder-gray-400" required>
                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-300">Daftar</button>
                </form>
                <p class="md:hidden mt-6 text-center text-sm text-gray-400">
                    Sudah punya akun?
                    <button @click="isRegister = false" class="font-semibold text-purple-400 hover:underline">Masuk di sini</button>
                </p>
            </div>
        </div>
        <!-- Overlay Motivasi (Desktop Only, absolute, tidak menutupi form) -->
        
        <div class="hidden md:block pointer-events-none absolute inset-0 z-0">
            <div class="absolute top-0 left-0 w-1/2 h-full"
                x-show="isRegister"
                x-transition:enter="transition-all duration-500"
                x-transition:enter-start="translate-x-full opacity-0"
                x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition-all duration-500"
                x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="translate-x-full opacity-0"
            >
                <div class="bg-gradient-to-br from-purple-600 to-blue-500 flex flex-col items-center justify-center p-8 text-white text-center rounded-l-2xl h-full">
                    <h2 class="text-3xl font-bold mb-2">Selamat Datang!</h2>
                    <p class="mb-6">Sudah terdaftar? Masuk untuk melanjutkan dan melihat dashboard finansialmu.</p>
                    <div class="w-full max-w-xs mb-6">
                        <!-- SVG Chart -->
                        <svg viewBox="0 0 100 60" class="w-full">
                            <defs><linearGradient id="barGradient2" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#A78BFA"/><stop offset="100%" stop-color="#60A5FA"/></linearGradient></defs>
                            <rect class="svg-chart-bar" style="animation-delay: 0.1s; transform-origin: bottom;" x="5" y="10" width="10" height="50" rx="3" fill="url(#barGradient2)" transform="scale(1, 0.4)"/>
                            <rect class="svg-chart-bar" style="animation-delay: 0.3s; transform-origin: bottom;" x="25" y="10" width="10" height="50" rx="3" fill="url(#barGradient2)" transform="scale(1, 0.7)"/>
                            <rect class="svg-chart-bar" style="animation-delay: 0.2s; transform-origin: bottom;" x="45" y="10" width="10" height="50" rx="3" fill="url(#barGradient2)" transform="scale(1, 0.5)"/>
                            <rect class="svg-chart-bar" style="animation-delay: 0.5s; transform-origin: bottom;" x="65" y="10" width="10" height="50" rx="3" fill="url(#barGradient2)" transform="scale(1, 0.9)"/>
                            <rect class="svg-chart-bar" style="animation-delay: 0.4s; transform-origin: bottom;" x="85" y="10" width="10" height="50" rx="3" fill="url(#barGradient2)" transform="scale(1, 0.6)"/>
                            <rect x="0" y="58" width="100" height="2" rx="1" fill="rgba(255,255,255,0.2)"/>
                        </svg>
                    </div>
                    <button @click="isRegister = false" class="font-semibold border-2 border-white rounded-full px-8 py-2 hover:bg-white hover:text-purple-600 transition-colors pointer-events-auto">Masuk</button>
                </div>
            </div>
            <div class="absolute top-0 right-0 w-1/2 h-full"
                x-show="!isRegister"
                x-transition:enter="transition-all duration-500"
                x-transition:enter-start="-translate-x-full opacity-0"
                x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition-all duration-500"
                x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="-translate-x-full opacity-0"
            >
                <div class="bg-gradient-to-br from-purple-600 to-blue-500 flex flex-col items-center justify-center p-8 text-white text-center rounded-r-2xl h-full">
                    <h2 class="text-3xl font-bold mb-2">Halo, Sobat Finansial!</h2>
                    <p class="mb-6">Daftar sekarang dan mulai perjalanan finansialmu untuk meraih semua tujuan.</p>
                    <div class="w-full max-w-xs mb-6">
                        <!-- SVG Chart -->
                        <svg viewBox="0 0 100 60" class="w-full">
                            <defs><linearGradient id="barGradient" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#A78BFA"/><stop offset="100%" stop-color="#60A5FA"/></linearGradient></defs>
                            <rect class="svg-chart-bar" style="animation-delay: 0.1s; transform-origin: bottom;" x="5" y="10" width="10" height="50" rx="3" fill="url(#barGradient)" transform="scale(1, 0.4)"/>
                            <rect class="svg-chart-bar" style="animation-delay: 0.3s; transform-origin: bottom;" x="25" y="10" width="10" height="50" rx="3" fill="url(#barGradient)" transform="scale(1, 0.7)"/>
                            <rect class="svg-chart-bar" style="animation-delay: 0.2s; transform-origin: bottom;" x="45" y="10" width="10" height="50" rx="3" fill="url(#barGradient)" transform="scale(1, 0.5)"/>
                            <rect class="svg-chart-bar" style="animation-delay: 0.5s; transform-origin: bottom;" x="65" y="10" width="10" height="50" rx="3" fill="url(#barGradient)" transform="scale(1, 0.9)"/>
                            <rect class="svg-chart-bar" style="animation-delay: 0.4s; transform-origin: bottom;" x="85" y="10" width="10" height="50" rx="3" fill="url(#barGradient)" transform="scale(1, 0.6)"/>
                            <rect x="0" y="58" width="100" height="2" rx="1" fill="rgba(255,255,255,0.2)"/>
                        </svg>
                    </div>
                    <button @click="isRegister = true" class="font-semibold border-2 border-white rounded-full px-8 py-2 hover:bg-white hover:text-purple-600 transition-colors pointer-events-auto">Daftar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush