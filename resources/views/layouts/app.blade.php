<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-g">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FinTrack ID')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" xintegrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <style>
        /* Anda bisa menambahkan custom CSS di sini atau di file app.css */
        body {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div id="app">
        <nav class="bg-white shadow-sm">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center py-4">
                    <a class="text-lg font-semibold" href="{{ url('/') }}">
                        FinTrack ID
                    </a>
                    <div>
                        <!-- Tautan untuk Guest -->
                        @guest
                            @if (Route::has('login'))
                                <a class="text-gray-600 hover:text-gray-900 mr-4" href="{{ route('login') }}">Login</a>
                            @endif
                            @if (Route::has('register'))
                                <a class="text-gray-600 hover:text-gray-900" href="{{ route('register') }}">Register</a>
                            @endif
                        @else
                        <!-- Tautan untuk User yang Login -->
                            <div class="hidden sm:flex sm:items-center sm:ml-6">
                                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 mr-4">Dashboard</a>
                                <a href="{{ route('accounts.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Akun Saya</a>
                                <a href="{{ route('transactions.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Transaksi</a>
                                <a href="{{ route('budgets.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Anggaran</a>
                            </div>

                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-red-500 hover:text-red-700 ml-4">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-8">
            <div class="container mx-auto px-4">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
