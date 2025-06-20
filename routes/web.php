<?php

use Illuminate\Support\Facades\Route;

// Import Controller
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\UserDashboardController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

// User Resource Controllers
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BudgetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Publik
Route::get('/', function () {
    return view('welcome'); // Halaman homepage publik
})->name('home');

// Route untuk Guest (yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

// Route untuk yang sudah Login
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

    // Dashboard User
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Resource routes untuk user
    Route::resource('accounts', AccountController::class);
    Route::resource('categories', CategoryController::class); // Kategori milik user
    Route::resource('transactions', TransactionController::class);
    Route::resource('budgets', BudgetController::class)->only(['index', 'store']);

    // Route untuk Admin (diproteksi oleh middleware auth dan admin)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Resource untuk manajemen user dan kategori global
        Route::resource('users', AdminUserController::class);
        Route::resource('categories', AdminCategoryController::class)->except(['show']); // Kategori global
    });
});
