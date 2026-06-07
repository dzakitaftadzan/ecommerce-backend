<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'nama', 
        'harga', 
        'stok', 
        'kategori', 
        'ukuran', 
        'gambar', 
        'status'
    ];
}