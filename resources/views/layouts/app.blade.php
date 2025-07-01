<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FinTrack ID')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <style>
        .glassmorphism-bg {
            background-color: #0c0a09; /* Fallback color */
            background-image: linear-gradient(135deg, #111827 0%, #1a1f36 50%, #4338ca 100%);
            background-attachment: fixed;
        }

        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
        
        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
    </style>
</head>
<body class="glassmorphism-bg text-gray-200 antialiased">
    <div id="app" class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white/5 backdrop-blur-md sticky top-0 z-40 border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between items-center h-20">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <div class="bg-purple-500/20 text-purple-400 p-2 rounded-lg">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                        <span class="text-2xl font-bold text-white">
                            FinTrack<span class="text-purple-400">ID</span>
                        </span>
                    </a>

                    <div class="hidden lg:flex items-center space-x-8">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white transition-colors"><i class="fas fa-tachometer-alt mr-2 text-green-400"></i>Dashboard</a>
                            <a href="{{ route('transactions.index') }}" class="text-gray-300 hover:text-white transition-colors"><i class="fas fa-exchange-alt mr-2 text-purple-400"></i>Transaksi</a>
                            <a href="{{ route('accounts.index') }}" class="text-gray-300 hover:text-white transition-colors"><i class="fas fa-wallet mr-2 text-blue-400"></i>Kelola Kartu</a>
                            <a href="{{ route('budgets.index') }}" class="text-gray-300 hover:text-white transition-colors"><i class="fas fa-chart-pie mr-2 text-yellow-400"></i>Anggaran</a>
                            @if(Auth::user()->role === 'admin')
                                @if(request()->routeIs('admin.*'))
                                    <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white transition-colors"><i class="fas fa-user mr-2 text-pink-400"></i>Kembali ke Dashboard User</a>
                                @else
                                    <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-white transition-colors"><i class="fas fa-user-shield mr-2 text-purple-400"></i>Kembali ke Dashboard Admin</a>
                                @endif
                            @endif
                            
                            <div class="relative dropdown">
                                <button class="flex items-center space-x-2 text-white">
                                    <span>{{ Auth::user()->name }}</span>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                <div class="dropdown-menu absolute right-0 top-full mt-3 w-48 bg-gray-800/80 backdrop-blur-md rounded-xl shadow-lg border border-white/10 py-2 z-50">
                                    
                                    <hr class="border-white/10 my-1">
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-red-400 hover:bg-white/10 transition-colors">
                                        <i class="fas fa-sign-out-alt w-6"></i> Keluar
                                    </a>
                                </div>
                            </div>
                        @endauth
                    </div>

                     <button id="mobileMenuBtn" class="lg:hidden text-white p-2">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="mobile-menu lg:hidden fixed top-0 right-0 w-80 h-full bg-black/80 backdrop-blur-xl border-l border-white/10 z-50 transition-transform duration-300 translate-x-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-xl font-bold text-white">Menu</h3>
                    <button id="closeMobileMenu" class="text-gray-300 hover:text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <!-- Mobile Guest Menu -->
                @guest
                    <div class="space-y-4">
                        @if (Route::has('auth'))
                            <a href="{{ route('auth') }}" class="block p-4 {{ request()->routeIs('auth') ? 'bg-gradient-to-r from-green-500 to-blue-600' : 'bg-gradient-to-r from-blue-500 to-purple-600' }} text-white rounded-xl">
                                <i class="fas fa-sign-in-alt mr-3"></i>Masuk / Daftar
                            </a>
                        @endif
                    </div>
                @else
                    <!-- Mobile User Menu -->
                    <div class="space-y-3">
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block p-3 {{ request()->routeIs('admin.dashboard') ? 'bg-purple-700/80' : 'hover:bg-white/10' }} rounded-lg transition-colors text-white">
                                <i class="fas fa-tachometer-alt mr-3 text-green-400"></i>Dashboard Admin
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="block p-3 {{ request()->routeIs('admin.users.*') ? 'bg-purple-700/80' : 'hover:bg-white/10' }} rounded-lg transition-colors text-white">
                                <i class="fas fa-users mr-3 text-blue-400"></i>Kelola Pengguna
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="block p-3 {{ request()->routeIs('admin.categories.*') ? 'bg-purple-700/80' : 'hover:bg-white/10' }} rounded-lg transition-colors text-white">
                                <i class="fas fa-tags mr-3 text-purple-400"></i>Kelola Kategori
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="block p-3 {{ request()->routeIs('dashboard') ? 'bg-purple-700/80' : 'hover:bg-white/10' }} rounded-lg transition-colors text-white">
                                <i class="fas fa-tachometer-alt mr-3 text-green-400"></i>Dashboard
                            </a>
                            <a href="{{ route('accounts.index') }}" class="block p-3 {{ request()->routeIs('accounts.index') ? 'bg-purple-700/80' : 'hover:bg-white/10' }} rounded-lg transition-colors text-white">
                                <i class="fas fa-wallet mr-3 text-blue-400"></i>Kelola Kartu
                            </a>
                            <a href="{{ route('transactions.index') }}" class="block p-3 {{ request()->routeIs('transactions.*') ? 'bg-purple-700/80' : 'hover:bg-white/10' }} rounded-lg transition-colors text-white">
                                <i class="fas fa-exchange-alt mr-3 text-purple-400"></i>Transaksi
                            </a>
                            <a href="{{ route('budgets.index') }}" class="block p-3 {{ request()->routeIs('budgets.*') ? 'bg-purple-700/80' : 'hover:bg-white/10' }} rounded-lg transition-colors text-white">
                                <i class="fas fa-chart-pie mr-3 text-yellow-400"></i>Anggaran
                            </a>
                        @endif
                        @if (Auth::user()->role === 'admin')
                            @if(request()->routeIs('admin.*'))
                                <a href="{{ route('dashboard') }}" class="block p-3 hover:bg-white/10 rounded-lg transition-colors text-pink-400">
                                    <i class="fas fa-user mr-3"></i>Kembali ke Dashboard User
                                </a>
                            @else
                                <a href="{{ route('admin.dashboard') }}" class="block p-3 hover:bg-white/10 rounded-lg transition-colors text-purple-400">
                                    <i class="fas fa-user-shield mr-3"></i>Kembali ke Dashboard Admin
                                </a>
                            @endif
                        @endif
                        <hr class="my-4 border-white/20">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block p-3 text-red-400 hover:bg-white/10 rounded-lg transition-colors">
                            <i class="fas fa-sign-out-alt mr-3"></i>Keluar
                        </a>
                    </div>
                @endguest
            </div>
        </div>

        <!-- Logout Form -->
        @auth
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        @endauth

        <!-- Main Content -->
        <main class="flex-grow">
            {{-- Konten dari setiap halaman akan dimuat di sini --}}
            @yield('content')
        </main>
        
        <footer class="bg-white shadow-inner mt-auto">
            <div class="container mx-auto px-4 py-6 text-center text-gray-600">
                <p>&copy; {{ date('Y') }} FinTrack ID. All Rights Reserved.</p>
                <p class="text-sm">Created by Luthfi</p>
            </div>
        </footer>

    </div>

    <script>
        // Mobile menu functionality
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const closeMobileMenu = document.getElementById('closeMobileMenu');

        function openMobileMenu() {
            mobileMenu.classList.remove('translate-x-full');
        }
        function closeMobileMenuFunc() {
            mobileMenu.classList.add('translate-x-full');
        }

        if (mobileMenuBtn && mobileMenu && closeMobileMenu) {
            mobileMenuBtn.addEventListener('click', openMobileMenu);
            closeMobileMenu.addEventListener('click', closeMobileMenuFunc);

            // Close mobile menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                    closeMobileMenuFunc();
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
