<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - FinTrack ID')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
        .admin-sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .admin-content {
            background-color: #f8fafc;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar Admin -->
        <div class="admin-sidebar w-64 fixed h-full">
            <div class="p-6">
                <div class="text-white text-xl font-bold mb-8">
                    <i class="fas fa-shield-alt mr-2"></i>
                    Admin Panel
                </div>
                
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center text-white hover:bg-black hover:bg-opacity-20 px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-black bg-opacity-20' : '' }}">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" class="flex items-center text-white hover:bg-black hover:bg-opacity-20 px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-black bg-opacity-20' : '' }}">
                        <i class="fas fa-users mr-3"></i>
                        Kelola User
                    </a>
                    
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center text-white hover:bg-black hover:bg-opacity-20 px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-black bg-opacity-20' : '' }}">
                        <i class="fas fa-tags mr-3"></i>
                        Kelola Kategori
                    </a>

                    <!-- kembali ke dashboard -->
                    <a href="{{ route('dashboard') }}" class="flex items-center text-white hover:bg-black hover:bg-opacity-20 px-4 py-3 rounded-lg transition duration-200">
                        <i class="fas fa-arrow-left mr-3"></i>
                        Kembali ke Dashboard User
                    </a>
                </nav>
            </div>
            
            <!-- Admin Info & Logout -->
            <div class="absolute bottom-0 w-full p-6">
                <div class="border-t border-white border-opacity-20 pt-4">
                    <div class="text-white text-sm mb-2">
                        <i class="fas fa-user-circle mr-2"></i>
                        {{ Auth::user()->name }}
                    </div>
                    <div class="text-white text-xs opacity-75 mb-4">
                        {{ Auth::user()->email }}
                    </div>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                       class="flex items-center text-white hover:text-red-200 transition duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="admin-content ml-64 flex-1 flex flex-col min-h-screen">

            <!-- Page Content -->
            <main class="p-6 flex-grow">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="bg-white shadow-inner mt-auto">
                <div class="container mx-auto px-6 py-4 text-center text-gray-600">
                    <p>&copy; {{ date('Y') }} FinTrack ID - Admin Panel. All Rights Reserved.</p>
                </div>
            </footer>
        </div>
    </div>
    @stack('scripts')
</body>
</html> 