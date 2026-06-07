<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // GET /cart : Tampilkan isi keranjang pembeli
    public function index()
    {
        $userId = 1; // Asumsi pembeli ID 1 (Karena belum ada sistem login)

        // Ambil data keranjang beserta detail produknya (Eager Loading)
        $carts = Cart::with('product')->where('user_id', $userId)->get();

        return response()->json([
            'message' => 'Isi keranjang belanja',
            'data' => $carts
        ]);
    }

    // POST /cart/tambah : Tambah barang ke keranjang
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'size' => 'required|string'
        ]);

        $userId = 1; 

        // Cek apakah barang dengan ukuran yang sama sudah ada di keranjang
        $cart = Cart::where('user_id', $userId)
                    ->where('product_id', $request->product_id)
                    ->where('size', $request->size)
                    ->first();

        if ($cart) {
            // Jika sudah ada, tambahkan jumlah qty-nya saja
            $cart->update([
                'qty' => $cart->qty + $request->qty
            ]);
        } else {
            // Jika belum ada, buat baru di keranjang
            $cart = Cart::create([
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'qty' => $request->qty,
                'size' => $request->size
            ]);
        }

        return response()->json([
            'message' => 'Barang berhasil dimasukkan ke keranjang',
            'data' => $cart
        ], 201);
    }

    // PUT /cart/{id} : Update qty item di keranjang
    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        $cart = Cart::findOrFail($id);
        
        $cart->update([
            'qty' => $request->qty
        ]);

        return response()->json([
            'message' => 'Jumlah barang berhasil diupdate',
            'data' => $cart
        ]);
    }

    // DELETE /cart/hapus/{id} : Hapus barang dari keranjang
    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return response()->json([
            'message' => 'Barang dihapus dari keranjang'
        ]);
    }
}