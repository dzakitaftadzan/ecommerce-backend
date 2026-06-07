<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'total', 'status', 'alamat', 'ongkir'];

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    // Tambahkan relasi ini
    public function delivery() {
        return $this->hasOne(Delivery::class);
    }
}