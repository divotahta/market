<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaksi;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik dasar
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $todayTransactions = Transaksi::whereDate('created_at', today())->count();
        $todayRevenue = Transaksi::whereDate('created_at', today())
            ->where('status', 'completed')
            ->sum('total_price');

        // Transaksi terbaru
        $recentTransactions = Transaksi::with(['product'])
            ->latest()
            ->limit(5)
            ->get();

        // Produk terlaris
        $topProducts = Product::withCount(['transaksis as total_sold'])
            ->with('category')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'todayTransactions',
            'todayRevenue',
            'recentTransactions',
            'topProducts'
        ));
    }
} 