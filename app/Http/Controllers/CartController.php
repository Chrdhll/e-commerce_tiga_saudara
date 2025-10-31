<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart; // <-- Import Cart facade

class CartController extends Controller
{
    /**
     * Menambahkan produk ke keranjang.
     */
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        Cart::add(
            $product->id,
            $product->name,
            1, // Kuantitas awal
            $product->finalPrice, // Gunakan accessor finalPrice
            ['image' => $product->image, 'unit' => $product->unit] // Opsi tambahan
        );

        // Beri notifikasi (jika Anda menginstal toast/notifikasi)
        // toast('Produk ditambahkan ke keranjang','success');

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    /**
     * Memperbarui kuantitas item di keranjang.
     */
    public function update(Request $request, $rowId)
    {
        $item = Cart::get($rowId);
        $product = Product::find($item->id); // Cek stok

        if ($request->action == 'increase') {
            // Pastikan tidak melebihi stok
            if ($item->qty + 1 > $product->stock) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi!');
            }
            Cart::update($rowId, $item->qty + 1);
        } elseif ($request->action == 'decrease') {
            Cart::update($rowId, $item->qty - 1); // Package ini otomatis menghapus jika qty < 1
        }

        return redirect()->back();
    }

    /**
     * Menghapus item dari keranjang.
     */
    public function remove($rowId)
    {
        Cart::remove($rowId);
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }

    /**
     * Menghapus semua item dari keranjang.
     */
    public function clear()
    {
        Cart::destroy();
        return redirect()->back()->with('success', 'Keranjang berhasil dikosongkan.');
    }
}