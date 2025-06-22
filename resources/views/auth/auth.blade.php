@extends('layouts.app')

@section('title', 'Selamat Datang di FinTrack ID')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="auth-container" id="container">
        <!-- Sign Up (Register) Form -->
        <div class="form-container sign-up-container">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h1>Buat Akun</h1>
                <p>Gunakan email Anda untuk registrasi</p>
                <input type="text" name="name" placeholder="Nama" value="{{ old('name') }}" required />
                @error('name')<p class="error-message">{{ $message }}</p>@enderror

                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
                @error('email')<p class="error-message">{{ $message }}</p>@enderror

                <input type="password" name="password" placeholder="Password" required />
                @error('password')<p class="error-message">{{ $message }}</p>@enderror

                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required />
                
                <button type="submit">Daftar</button>
            </form>
        </div>

        <!-- Sign In (Login) Form -->
        <div class="form-container sign-in-container">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1>Masuk</h1>
                <p>Masuk ke akun FinTrack ID Anda</p>
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
                @error('email')<p class="error-message">{{ $message }}</p>@enderror
                
                <input type="password" name="password" placeholder="Password" required />
                @error('password')<p class="error-message">{{ $message }}</p>@enderror

                <a href="#" style="font-size: 12px; margin: 10px 0; color: #0061ff; text-decoration: none;">Lupa password?</a>
                <button type="submit">Masuk</button>
            </form>
        </div>

        <!-- Overlay Panels -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Selamat Datang Kembali!</h1>
                    <p>Untuk tetap terhubung dengan kami, silakan masuk dengan info pribadi Anda</p>
                    <button class="ghost" id="signIn">Masuk</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Halo, Sahabat Finansial!</h1>
                    <p>Masukkan detail pribadi Anda dan mulailah perjalanan mengelola keuangan</p>
                    <button class="ghost" id="signUp">Daftar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    * {
        box-sizing: border-box;
    }

    .auth-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
        position: relative;
        overflow: hidden;
        width: 768px;
        max-width: 100%;
        min-height: 520px;
    }

    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
    }

    .sign-in-container {
        left: 0;
        width: 50%;
        z-index: 2;
    }

    .sign-up-container {
        left: 0;
        width: 50%;
        opacity: 0;
        z-index: 1;
    }

    .auth-container.right-panel-active .sign-in-container {
        transform: translateX(100%);
    }

    .auth-container.right-panel-active .sign-up-container {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
        animation: show 0.6s;
    }

    @keyframes show {
        0%, 49.99% {
            opacity: 0;
            z-index: 1;
        }
        50%, 100% {
            opacity: 1;
            z-index: 5;
        }
    }

    .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform 0.6s ease-in-out;
        z-index: 100;
    }

    .auth-container.right-panel-active .overlay-container {
        transform: translateX(-100%);
    }

    .overlay {
        background: #FF416C;
        background: -webkit-linear-gradient(to right, #0061ff, #60efff);
        background: linear-gradient(to right, #0061ff, #60efff);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 0 0;
        color: #FFFFFF;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }
    
    .overlay::before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white' opacity='0.1'%3E%3Cpath d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-8.59V10c0-.55.45-1 1-1s1 .45 1 1v1.41l1.29 1.29c.39.39.39 1.02 0 1.41a.996.996 0 0 1-1.41 0L11 12.41V10z'/%3E%3C/svg%3E");
        background-size: 300px;
    }

    .auth-container.right-panel-active .overlay {
        transform: translateX(50%);
    }

    .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .overlay-left {
        transform: translateX(-20%);
    }

    .auth-container.right-panel-active .overlay-left {
        transform: translateX(0);
    }

    .overlay-right {
        right: 0;
        transform: translateX(0);
    }

    .auth-container.right-panel-active .overlay-right {
        transform: translateX(20%);
    }

    form {
        background-color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 50px;
        height: 100%;
        text-align: center;
    }

    h1 {
        font-weight: bold;
        margin: 0;
    }

    p {
        font-size: 14px;
        font-weight: 500;
        line-height: 20px;
        letter-spacing: 0.5px;
        margin: 20px 0 30px;
    }

    input {
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 100%;
    }
    
    button {
        border-radius: 20px;
        border: 1px solid #0061ff;
        background-color: #0061ff;
        color: #FFFFFF;
        font-size: 12px;
        font-weight: bold;
        padding: 12px 45px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
        cursor: pointer;
    }
    
    button:active {
        transform: scale(0.95);
    }

    button:focus {
        outline: none;
    }

    button.ghost {
        background-color: transparent;
        border-color: #FFFFFF;
    }

    .error-message {
        color: #ff416c;
        font-size: 12px;
        margin-top: -5px;
        margin-bottom: 10px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .auth-container {
            width: 100%;
            max-width: 400px;
            min-height: 600px;
        }
        
        .form-container {
            width: 100%;
        }
        
        .overlay-container {
            display: none;
        }
        
        .sign-in-container,
        .sign-up-container {
            width: 100%;
            opacity: 1;
            transform: none;
        }
        
        .auth-container.right-panel-active .sign-in-container {
            transform: none;
            opacity: 0;
        }
        
        .auth-container.right-panel-active .sign-up-container {
            transform: none;
            opacity: 1;
        }
    }
</style>

<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
    
    // Cek jika ada error dari sisi register, langsung tampilkan panel register
    @if ($errors->has('name') || $errors->has('password_confirmation'))
        container.classList.add("right-panel-active");
    @endif
</script>
@endsection 