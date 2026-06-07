<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // POST /checkout (Proses Pembeli Checkout)
    public function checkout(Request $request)
    {
        // Validasi input alamat
        $request->validate([
            'alamat' => 'required|string'
        ]);

        $userId = 1; // Asumsi pembeli ID 1
        $carts = Cart::with('product')->where('user_id', $userId)->get();

        if ($carts->isEmpty()) {
            return response()->json(['message' => 'Keranjang belanja kosong'], 400);
        }

        $ongkir = 20000; // Flat rate ongkir Rp 20.000
        $totalHargaProduk = 0;

        // 1. Validasi stok sebelum diproses
        foreach ($carts as $cart) {
            if ($cart->product->stok < $cart->qty) {
                return response()->json([
                    'message' => 'Stok produk ' . $cart->product->nama . ' tidak mencukupi'
                ], 400);
            }
            $totalHargaProduk += $cart->product->harga * $cart->qty;
        }

        $totalKeseluruhan = $totalHargaProduk + $ongkir;

        // Gunakan DB Transaction agar aman
        DB::beginTransaction();
        try {
            // 2. Simpan ke tabel orders
            $order = Order::create([
                'user_id' => $userId,
                'total' => $totalKeseluruhan,
                'status' => 'Menunggu Konfirmasi',
                'alamat' => $request->alamat,
                'ongkir' => $ongkir
            ]);

            // 3. Pindahkan cart ke order_items & Kurangi stok
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'qty' => $cart->qty,
                    'harga' => $cart->product->harga // Harga dikunci saat beli
                ]);

                // Kurangi stok produk
                $product = $cart->product;
                $product->stok -= $cart->qty;
                
                // Ubah status otomatis jika stok habis
                if ($product->stok == 0) {
                    $product->status = 'Habis';
                }
                $product->save();
            }

            // 4. Kosongkan keranjang pembeli
            Cart::where('user_id', $userId)->delete();

            DB::commit();

            return response()->json([
                'message' => 'Checkout berhasil',
                'data' => $order
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan sistem',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /pesanan-saya (Pembeli: Lihat riwayat order)
    public function pesananSaya()
    {
        $userId = 1; // Asumsi pembeli ID 1
        
        $orders = Order::with('items.product')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'message' => 'Riwayat pesanan saya',
            'data' => $orders
        ]);
    }

    // GET /penjual/orders (Penjual: Dashboard pesanan masuk)
    public function pesananMasuk(Request $request)
    {
        $query = Order::with('items.product')->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->get();

        return response()->json([
            'message' => 'Daftar pesanan masuk',
            'data' => $orders
        ]);
    }
}