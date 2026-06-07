<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryLog extends Model
{
    // Mengizinkan pengisian data secara massal
    protected $fillable = ['order_id', 'status', 'keterangan'];
}