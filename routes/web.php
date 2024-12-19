<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;
use App\Http\Controllers\Admin\TransaksiAdminController;
use App\Http\Controllers\transaksiController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

// Route publik
Route::get('/', function () {
    $query = \App\Models\Product::query();
    $categories = \App\Models\Category::all();

    if (request('category')) {
        $query->where('category_id', request('category'));
    }

    $products = $query->latest()->paginate(6);
    return view('welcome', compact('products', 'categories'));
})->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/about', function () {return view('about');})->name('about');

// Route admin dengan middleware auth dan role:admin
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // CRUD Products
    Route::get('/products', [ProductController::class, 'indexAdmin'])->name('admin.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    // Kategori Produk
    Route::get('categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Transaksi
    Route::get('/transaksi', [TransaksiAdminController::class, 'index'])->name('admin.transaksi.index');
    Route::get('/transaksi/{transaksi}', [TransaksiAdminController::class, 'show'])->name('admin.transaksi.show');
    Route::patch('/transaksi/{transaksi}/status', [TransaksiAdminController::class, 'updateStatus'])->name('admin.transaksi.update-status');
    
    // Report
    Route::get('/report', [TransaksiAdminController::class, 'report'])->name('admin.report');
});

// Route pelanggan
Route::middleware(['auth', 'verified', 'role:pelanggan'])->prefix('pelanggan')->group(function () {
    Route::get('/dashboard', [PelangganDashboardController::class, 'index'])->name('pelanggan.dashboard');

    Route::post('/transaksi', [transaksiController::class, 'store'])->name('pelanggan.transaksi.store');
    Route::get('/transaksi/{transaksi}', [transaksiController::class, 'show'])->name('pelanggan.transaksi.show');
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('pelanggan.transaksi.index');
    Route::get('/transaksi/create/{product}', [TransaksiController::class, 'create'])->name('pelanggan.transaksi.create');
    
    // Report
    Route::get('/report', [ProductController::class, 'report'])->name('pelanggan.report');
    
});

// Profile routes
Route::middleware('auth')->group(function(){
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Midtrans notification handler
Route::post('/midtrans/notification', [TransaksiController::class, 'notification'])
    ->name('midtrans.notification');

require __DIR__.'/auth.php';
