<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // GET /produk (Tampilkan semua produk aktif + Filter Kategori)
    public function index(Request $request)
    {
        // Mulai query untuk produk yang statusnya bukan "Habis" / "inactive"
        // Mengacu pada seeder sebelumnya, status default adalah 'active'
        $query = Product::where('status', 'active');

        // Filter berdasarkan kategori jika ada query string ?kategori=tops
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $products = $query->get();

        return response()->json([
            'message' => 'Berhasil mengambil data produk',
            'data' => $products
        ]);
    }

    // GET /produk/{id} (Detail 1 produk)
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'message' => 'Detail produk',
            'data' => $product
        ]);
    }

    // POST /produk (Tambah produk penjual)
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'kategori' => 'required|string',
            'ukuran' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        // Validasi stok otomatis
        $data['status'] = $request->stok == 0 ? 'Habis' : 'active';

        // Upload gambar ke storage/app/public/products jika ada
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product = Product::create($data);

        return response()->json([
            'message' => 'Produk berhasil ditambahkan',
            'data' => $product
        ], 201);
    }

    // PUT/PATCH /produk/{id} (Edit produk)
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'harga' => 'sometimes|required|integer',
            'stok' => 'sometimes|required|integer',
            'kategori' => 'sometimes|required|string',
            'ukuran' => 'sometimes|required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        // Validasi stok otomatis jika stok diupdate
        if (isset($data['stok'])) {
            $data['status'] = $data['stok'] == 0 ? 'Habis' : 'active';
        }

        // Handle upload gambar baru dan hapus gambar lama
        if ($request->hasFile('gambar')) {
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product->update($data);

        return response()->json([
            'message' => 'Produk berhasil diperbarui',
            'data' => $product
        ]);
    }

    // DELETE /produk/{id} (Hapus produk)
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return response()->json([
            'message' => 'Produk berhasil dihapus'
        ]);
    }
}