<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total_price',
        'status',
        'payment_status',
        'name',
        'phone',
        'shipping_address',
        'snap_token'
    ];

    protected $casts = [
        'status' => 'string',
        'payment_status' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function generateSnapToken()
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');

        $orderId = 'TRX-' . $this->id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $this->total_price,
            ],
            'customer_details' => [
                'first_name' => $this->name,
                'phone' => $this->phone,
                'shipping_address' => [
                    'address' => $this->shipping_address,
                ]
            ],
            'item_details' => [
                [
                    'id' => $this->product_id,
                    'price' => $this->product->price,
                    'quantity' => $this->quantity,
                    'name' => $this->product->name,
                ]
            ]
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $this->update(['snap_token' => $snapToken]);

        return $snapToken;
    }
} 