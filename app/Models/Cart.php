<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    // Mengizinkan pengisian data massal
    protected $fillable = [
        'user_id', 
        'product_id', 
        'qty', 
        'size'
    ];

    // Relasi: 1 data keranjang pasti milik 1 produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}