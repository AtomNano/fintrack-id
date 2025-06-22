<?php

use Illuminate\Support\Facades\Route;

// Import Controller
use App\Http\Controllers\Auth\AuthController;
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

// Route untuk Guest (yang belum login) - Combined Auth Page
Route::middleware('guest')->group(function () {
    Route::get('auth', [AuthController::class, 'showAuthForm'])->name('auth');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    
    // Redirect old routes to new combined auth page
    Route::get('login', function() {
        return redirect()->route('auth');
    });
    Route::get('register', function() {
        return redirect()->route('auth');
    });
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
