<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'qty', 'harga'];

    // Relasi: 1 OrderItem mewakili 1 Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}