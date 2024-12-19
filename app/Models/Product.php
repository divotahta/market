<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'condition',
        'image',
        'category_id',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function isSold()
    {
        return $this->status === 'sold';
    }
}
