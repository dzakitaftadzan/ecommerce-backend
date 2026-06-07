<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Tops
            ['nama' => 'Boxy Tee', 'harga' => 149000, 'stok' => 30, 'kategori' => 'Tops', 'ukuran' => 'M, L, XL', 'gambar' => 'front-tee.jpg', 'status' => 'active'],
            ['nama' => 'Hoodie Obsidian Black', 'harga' => 159000, 'stok' => 25, 'kategori' => 'Tops', 'ukuran' => 'M, L, XL', 'gambar' => 'dirty-clothes.jpg', 'status' => 'active'],
            ['nama' => 'Yoka Jacket Choengsam', 'harga' => 99000, 'stok' => 50, 'kategori' => 'Tops', 'ukuran' => 'S, M, L, XL', 'gambar' => 'basic-tee.jpg', 'status' => 'active'],
            ['nama' => 'Clasp Jigoku Jacket', 'harga' => 349000, 'stok' => 15, 'kategori' => 'Tops', 'ukuran' => 'L, XL', 'gambar' => 'denim-jacket.jpg', 'status' => 'active'],
            ['nama' => 'Classic Flannel Shirt', 'harga' => 199000, 'stok' => 40, 'kategori' => 'Tops', 'ukuran' => 'M, L, XL', 'gambar' => 'flannel.jpg', 'status' => 'active'],
            
            // Bottoms
            ['nama' => 'Button Pants Black', 'harga' => 289000, 'stok' => 20, 'kategori' => 'Bottoms', 'ukuran' => '30, 32, 34', 'gambar' => 'neversize-pants.jpg', 'status' => 'active'],
            ['nama' => 'Pleated Trouser', 'harga' => 279000, 'stok' => 25, 'kategori' => 'Bottoms', 'ukuran' => '28, 30, 32, 34', 'gambar' => 'pleated-trouser.jpg', 'status' => 'active'],
            ['nama' => 'White Baggy Pants', 'harga' => 259000, 'stok' => 35, 'kategori' => 'Bottoms', 'ukuran' => '30, 32, 34, 36', 'gambar' => 'cargo.jpg', 'status' => 'active'],
            ['nama' => 'Sakura Raw Denim', 'harga' => 179000, 'stok' => 60, 'kategori' => 'Bottoms', 'ukuran' => 'M, L, XL', 'gambar' => 'sweatpants.jpg', 'status' => 'active'],
            ['nama' => 'Short Plated Trouser', 'harga' => 219000, 'stok' => 50, 'kategori' => 'Bottoms', 'ukuran' => '30, 32, 34', 'gambar' => 'chino.jpg', 'status' => 'active'],
        ];

        $now = now();
        foreach ($products as &$product) {
            $product['created_at'] = $now;
            $product['updated_at'] = $now;
        }

        DB::table('products')->insert($products);
    }
}