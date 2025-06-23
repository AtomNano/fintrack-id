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
        body {
            font-family: 'Figtree', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 25%, #059669 75%, #065f46 100%);
            background-color: rgba(30, 58, 138, 0.95); /* fallback solid color */
        }
        
        .financial-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 1px, transparent 1px),
                radial-gradient(circle at 75% 75%, rgba(16,185,129,0.15) 1px, transparent 1px),
                url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M20 20c0-5.5-4.5-10-10-10s-10 4.5-10 10 4.5 10 10 10 10-4.5 10-10zm10 0c0-5.5-4.5-10-10-10s-10 4.5-10 10 4.5 10 10 10 10-4.5 10-10z'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 40px 40px, 40px 40px, 80px 80px;
        }
        
        .nav-link {
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link:hover {
            transform: translateY(-2px);
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #10b981, #06d6a0, #f72585);
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 1px;
        }
        
        .nav-link:hover::before {
            width: 100%;
        }

        .nav-link.active::before {
            width: 100%;
        }
        
        .nav-link.active {
            color: white !important;
            transform: translateY(-2px);
        }
        
        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }
        
        .mobile-menu.active {
            transform: translateX(0);
        }
        
        .logo-glow {
            text-shadow: 0 0 30px rgba(16,185,129,0.6), 0 0 60px rgba(16,185,129,0.3);
        }
        
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
            position: absolute;
        }
        
        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        /* Ensure navbar doesn't clip dropdowns */
        nav {
            overflow: visible !important;
        }
        
        .container {
            overflow: visible !important;
        }
        
        /* Dropdown positioning fixes */
        .dropdown {
            position: relative;
            overflow: visible;
        }
        
        .dropdown-menu {
            min-width: 200px;
            border: 1px solid rgba(0,0,0,0.1);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body class="w-screen min-h-screen bg-[#141332]">
    <div id="app" class="flex flex-col min-h-screen w-screen">
        <!-- Navigation -->
        @if (!request()->routeIs('dashboard'))
        <nav class="gradient-bg financial-pattern shadow-xl sticky top-0 z-40" style="background: rgba(30, 58, 138, 0.95);">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center py-4">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl p-2">
                            <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                        <a href="{{ url('/') }}" class="text-2xl font-bold text-white
                        logo-glow">
                            FinTrack<span class="text-green-300">ID</span>
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden lg:flex items-center space-x-8">
                        <!-- Guest Navigation -->
                        @guest
                            <div class="flex items-center space-x-6">
                                @if (Route::has('auth'))
                                    <a href="{{ route('auth') }}" class="nav-link {{ request()->routeIs('auth') ? 'active' : '' }} text-white/90 hover:text-white font-medium flex items-center space-x-2">
                                        <i class="fas fa-sign-in-alt"></i>
                                        <span>Login / Register</span>
                                    </a>
                                @endif
                            </div>
                        @else
                            <!-- Admin Navigation -->
                            @if (Auth::user()->role === 'admin')
                                <div class="flex items-center space-x-6">
                                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} text-white/90 hover:text-white font-medium flex items-center space-x-2">
                                        <i class="fas fa-tachometer-alt text-green-300"></i>
                                        <span>Admin Dashboard</span>
                                    </a>
                                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }} text-white/90 hover:text-white font-medium flex items-center space-x-2">
                                        <i class="fas fa-users text-blue-300"></i>
                                        <span>Kelola User</span>
                                    </a>
                                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }} text-white/90 hover:text-white font-medium flex items-center space-x-2">
                                        <i class="fas fa-tags text-purple-300"></i>
                                        <span>Kelola Kategori</span>
                                    </a>
                                    <div class="dropdown relative">
                                        <button class="nav-link text-white/90 hover:text-white font-medium flex items-center space-x-2">
                                            <i class="fas fa-user-circle text-yellow-300"></i>
                                            <span>{{ Auth::user()->name }}</span>
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </button>
                                        <div class="dropdown-menu absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-xl py-2 z-50">
                                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                                <i class="fas fa-user mr-2"></i>Profile Settings
                                            </a>
                                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                                <i class="fas fa-cog mr-2"></i>Preferences
                                            </a>
                                            <hr class="my-2">
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- User Navigation -->
                                <div class="flex items-center space-x-6">
                                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }} text-white/90 hover:text-white font-medium flex items-center space-x-2">
                                        <i class="fas fa-tachometer-alt text-green-300"></i>
                                        <span>Dashboard</span>
                                    </a>
                                    <a href="{{ route('accounts.index') }}" class="nav-link {{ request()->routeIs('accounts.*') ? 'active' : '' }} text-white/90 hover:text-white font-medium flex items-center space-x-2">
                                        <i class="fas fa-wallet text-blue-300"></i>
                                        <span>Akun Bank Saya</span>
                                    </a>
                                    <a href="{{ route('transactions.index') }}" class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }} text-white/90 hover:text-white font-medium flex items-center space-x-2">
                                        <i class="fas fa-exchange-alt text-purple-300"></i>
                                        <span>Transaksi</span>
                                    </a>
                                    <a href="{{ route('budgets.index') }}" class="nav-link {{ request()->routeIs('budgets.*') ? 'active' : '' }} text-white/90 hover:text-white font-medium flex items-center space-x-2">
                                        <i class="fas fa-chart-pie text-yellow-300"></i>
                                        <span>Anggaran</span>
                                    </a>
                                    <div class="dropdown relative">
                                        <button class="nav-link text-white/90 hover:text-white font-medium flex items-center space-x-2">
                                            <i class="fas fa-user-circle text-green-300"></i>
                                            <span>{{ Auth::user()->name }}</span>
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </button>
                                        <div class="dropdown-menu absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-xl py-2 z-50">
                                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                                <i class="fas fa-user mr-2"></i>Profile Settings
                                            </a>
                                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                                <i class="fas fa-cog mr-2"></i>Preferences
                                            </a>
                                            <hr class="my-2">
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endguest
                    </div>

                    <!-- Mobile Menu Button -->
                    <button id="mobileMenuBtn" class="lg:hidden text-white p-3 rounded-lg hover:bg-white/10 transition-all duration-300">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </nav>
        @endif

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="mobile-menu lg:hidden fixed top-0 right-0 w-80 h-full bg-white shadow-2xl z-50">
            <div class="p-6">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-xl font-bold text-gray-800">Menu</h3>
                    <button id="closeMobileMenu" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <!-- Mobile Guest Menu -->
                @guest
                    <div class="space-y-4">
                        @if (Route::has('auth'))
                            <a href="{{ route('auth') }}" class="block p-4 {{ request()->routeIs('auth') ? 'bg-gradient-to-r from-green-500 to-blue-600' : 'bg-gradient-to-r from-blue-500 to-purple-600' }} text-white rounded-xl">
                                <i class="fas fa-sign-in-alt mr-3"></i>Login / Register
                            </a>
                        @endif
                    </div>
                @else
                    <!-- Mobile User Menu -->
                    <div class="space-y-3">
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block p-3 {{ request()->routeIs('admin.dashboard') ? 'bg-green-100 border-l-4 border-green-500' : 'hover:bg-gray-100' }} rounded-lg transition-colors">
                                <i class="fas fa-tachometer-alt mr-3 text-green-500"></i>Admin Dashboard
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="block p-3 {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 border-l-4 border-blue-500' : 'hover:bg-gray-100' }} rounded-lg transition-colors">
                                <i class="fas fa-users mr-3 text-blue-500"></i>Kelola User
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="block p-3 {{ request()->routeIs('admin.categories.*') ? 'bg-purple-100 border-l-4 border-purple-500' : 'hover:bg-gray-100' }} rounded-lg transition-colors">
                                <i class="fas fa-tags mr-3 text-purple-500"></i>Kelola Kategori
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="block p-3 {{ request()->routeIs('dashboard') ? 'bg-green-100 border-l-4 border-green-500' : 'hover:bg-gray-100' }} rounded-lg transition-colors">
                                <i class="fas fa-tachometer-alt mr-3 text-green-500"></i>Dashboard
                            </a>
                            <a href="{{ route('accounts.index') }}" class="block p-3 {{ request()->routeIs('accounts.*') ? 'bg-blue-100 border-l-4 border-blue-500' : 'hover:bg-gray-100' }} rounded-lg transition-colors">
                                <i class="fas fa-wallet mr-3 text-blue-500"></i>Akun Saya
                            </a>
                            <a href="{{ route('transactions.index') }}" class="block p-3 {{ request()->routeIs('transactions.*') ? 'bg-purple-100 border-l-4 border-purple-500' : 'hover:bg-gray-100' }} rounded-lg transition-colors">
                                <i class="fas fa-exchange-alt mr-3 text-purple-500"></i>Transaksi
                            </a>
                            <a href="{{ route('budgets.index') }}" class="block p-3 {{ request()->routeIs('budgets.*') ? 'bg-yellow-100 border-l-4 border-yellow-500' : 'hover:bg-gray-100' }} rounded-lg transition-colors">
                                <i class="fas fa-chart-pie mr-3 text-yellow-500"></i>Anggaran
                            </a>
                        @endif
                        <hr class="my-4">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block p-3 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                            <i class="fas fa-sign-out-alt mr-3"></i>Logout
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
        <main class="py-10 flex-grow">
            <div class="w-full px-4">
                @yield('content')
            </div>
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

        if (mobileMenuBtn && mobileMenu && closeMobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.add('active');
            });

            closeMobileMenu.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                    mobileMenu.classList.remove('active');
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
