<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// ---------------------------------------------
// ROUTES PRODUK
// ---------------------------------------------
Route::get('/produk', [ProductController::class, 'index']);
Route::get('/produk/{id}', [ProductController::class, 'show']);
Route::post('/produk', [ProductController::class, 'store']);
Route::post('/produk/{id}', [ProductController::class, 'update']);
Route::delete('/produk/{id}', [ProductController::class, 'destroy']);

// ---------------------------------------------
// ROUTES CART (KERANJANG)
// ---------------------------------------------
Route::get('/cart', [CartController::class, 'index']);           // Tampilkan isi cart
Route::post('/cart/tambah', [CartController::class, 'store']);   // Tambah barang
Route::put('/cart/{id}', [CartController::class, 'update']);     // Update qty
Route::delete('/cart/hapus/{id}', [CartController::class, 'destroy']); // Hapus item

// ---------------------------------------------
// ROUTES ORDER & CHECKOUT
// ---------------------------------------------
// Sisi Pembeli
Route::post('/checkout', [OrderController::class, 'checkout']);
Route::get('/pesanan-saya', [OrderController::class, 'pesananSaya']);

// Sisi Penjual
Route::get('/penjual/orders', [OrderController::class, 'pesananMasuk']);