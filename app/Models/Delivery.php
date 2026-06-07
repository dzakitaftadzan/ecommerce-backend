<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'order_id', 
        'driver_id', 
        'status', 
        'foto_pod', 
        'catatan'
    ];

    // Relasi ke order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}