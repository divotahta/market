<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Data untuk ringkasan
        $totalTransaksi = $user->transaksis()->count();
        $totalPengeluaran = $user->transaksis()->sum('total_price');
        $pesananAktif = $user->transaksis()
            ->whereIn('status', ['pending', 'processing'])
            ->count();

        // Transaksi terbaru
        $transaksiTerbaru = $user->transaksis()
            ->with(['product'])
            ->latest()
            ->limit(5)
            ->get();

        // Produk rekomendasi (contoh: produk terbaru)
        $produkRekomendasi = Product::with('category')
            ->latest()
            ->limit(4)
            ->get();
        return view('pelanggan.dashboard', compact(
            'totalTransaksi',
            'totalPengeluaran',
            'pesananAktif',
            'transaksiTerbaru',
            'produkRekomendasi'
        ));
    }
}