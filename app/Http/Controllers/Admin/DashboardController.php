<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin.
     */
    public function index()
    {
        // Di sini Anda bisa menambahkan logika untuk statistik admin
        // Contoh: jumlah user, jumlah transaksi, dll.
        return view('admin.dashboard');
    }
} 