<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaksi;
use Illuminate\Http\Request;


class TransaksiController extends Controller
{
    public function create(Product $product)
    {
        return view('pelanggan.transaksi.create', compact('product'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'shipping_address' => 'required|string',
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        $transaksi = Transaksi::create([
            'user_id' => auth('')->user()->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'total_price' => $product->price,
            'status' => 'pending',
            'payment_status' => 'pending',
            'name' => $request->name,
            'phone' => $request->phone,
            'shipping_address' => $request->shipping_address,
        ]);

        // Mode Development: Langsung update status
        if (config('app.env') === 'local') {
            $transaksi->update([
                'payment_status' => 'completed',
                'status' => 'pending'
            ]);

            // Update produk menjadi terjual
            $product->update(['status' => 'sold']);

            return redirect()->route('pelanggan.transaksi.show', $transaksi)
                ->with('success', 'Pembayaran berhasil (Mode Development)');
        }

        // Mode Production: Generate Snap Token
        $snapToken = $transaksi->generateSnapToken();
        return view('pelanggan.transaksi.payment', compact('transaksi', 'snapToken'));
    }

    public function notification(Request $request)
    {
        try {
            $payload = $request->all();
            
            // Extract order ID dari format TRX-ID-TIMESTAMP
            $orderId = $payload['order_id'];
            $transactionId = explode('-', $orderId)[1]; // Ambil ID transaksi saja
            
            $transaksi = Transaksi::findOrFail($transactionId);
            
            switch($payload['transaction_status']) {
                case 'capture':
                case 'settlement':
                    // Update transaksi
                    $transaksi->payment_status = 'completed';
                    $transaksi->status = 'completed';
                    $transaksi->save();

                    // Update produk
                    $product = $transaksi->product;
                    $product->status = 'sold';
                    $product->save();
                    break;

                case 'pending':
                    $transaksi->payment_status = 'pending';
                    $transaksi->status = 'pending';
                    $transaksi->save();
                    break;

                case 'deny':
                case 'expire':
                case 'cancel':
                    $transaksi->payment_status = 'failed';
                    $transaksi->status = 'cancelled';
                    $transaksi->save();
                    break;
            }

            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $transaksis = Transaksi::with(['product', 'user'])
            ->where('user_id', auth('')->user()->id)
            ->latest()
            ->paginate(10);
        
        return view('pelanggan.transaksi.index', compact('transaksis'));
    }

    public function show(Transaksi $transaksi)
    {
        if ($transaksi->user_id !== auth('')->user()->id) {
            abort(403);
        }

        return view('pelanggan.transaksi.show', compact('transaksi'));
    }
} 