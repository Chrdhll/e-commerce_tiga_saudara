<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class CartController extends Controller
{


    private function getWhatsappNumber()
    {
        return Cache::rememberForever('setting.whatsapp_number', function () {
            // Jika tidak ada di cache, ambil dari DB
            // Jika tidak ada di DB, pakai nomor fallback
            return Setting::where('key', 'whatsapp_number')->first()?->value ?? '6283189865216';
        });
    }

    public function checkout(Request $request)
    {
        $cartItems = Cart::content();
        $user = Auth::user();

        if ($user->is_admin) {
            return redirect()->back()->with('error', 'Admin tidak diizinkan untuk melakukan checkout.');
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Ambil data user dari profil (sesuai yang Anda tambahkan)
        $userAddress = $user->address;
        $userPhone = $user->phone_number;

        // Validasi: Wajibkan user mengisi profil sebelum checkout
        if (empty($userAddress) || empty($userPhone)) {
            return redirect()->route('profile.edit')->with('error', 'Harap lengkapi Alamat dan Nomor Telepon di profil Anda sebelum checkout.');
        }

        // Ambil total dari keranjang (angka murni)
        // Gunakan str_replace untuk menghapus format ribuan sebelum konversi
        $totalPrice = (float) str_replace(['Rp ', '.'], '', Cart::subtotal(2, '.', ''));

        // Buat Invoice Number unik (cocok dengan Filament)
        $invoiceNumber = 'INV-' . strtoupper(uniqid());

        // Gunakan database transaction
        try {
            DB::beginTransaction();

            // 1. Buat Order baru (sesuai tabel 'orders' Anda)
            $order = Order::create([
                'user_id' => $user->id,
                'invoice_number' => $invoiceNumber,
                'total_price' => $totalPrice,
                'status' => 'pending',         // Status default dari Filament
                'payment_status' => 'unpaid',  // Status default dari Filament
                'shipping_address' => $userAddress,
                'phone_number' => $userPhone,
            ]);

            $waMessage = "Halo 3 Saudara! Saya ingin konfirmasi pesanan saya:\n\n";
            $waMessage .= "Nomor Invoice: *{$invoiceNumber}*\n"; // SANGAT PENTING
            $waMessage .= "Nama: " . $user->name . "\n";
            $waMessage .= "Telepon: " . $userPhone . "\n";
            $waMessage .= "Alamat: " . $userAddress . "\n\n";
            $waMessage .= "Detail Pesanan:\n";

            // 2. Pindahkan item dari keranjang ke order_items (sesuai tabel 'order_items')
            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->id,
                    'quantity' => $item->qty,
                    'price' => $item->price, // Harga per item (sudah dihitung diskon saat 'add')
                ]);
                $waMessage .= "- {$item->name} (x{$item->qty}) @ Rp " . number_format($item->price, 0, ',', '.') . "\n";
            }

            $waMessage .= "\nTotal: *Rp " . number_format($totalPrice, 0, ',', '.') . "*\n\n";
            $waMessage .= "Mohon info untuk total dan rekening pembayarannya. Terima kasih.";

            // 3. Kosongkan keranjang
            Cart::destroy();

            DB::commit();

            // 4. Redirect ke WhatsApp

            $waNumber = $this->getWhatsappNumber();


            $waLink = "https://wa.me/{$waNumber}?text=" . urlencode($waMessage);


            // Kirim event untuk me-refresh keranjang di frontend
            // (Meskipun redirect, ini best practice jika user menekan "back")
            return redirect()->away($waLink)
                ->with('cart_cleared', true); // Kirim status untuk di-handle JS jika perlu

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat checkout: ' . $e->getMessage());
        }
    }
    public function orderNow(Request $request)
    {
        $user = Auth::user();

        if ($user->is_admin) {
            return redirect()->back()->with('error', 'Admin tidak diizinkan untuk melakukan checkout.');
        }

        // 1. Validasi Input dari form
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // 2. Validasi Profil User (wajib diisi sebelum checkout)
        $userAddress = $user->address;
        $userPhone = $user->phone_number;

        if (empty($userAddress) || empty($userPhone)) {
            // Redirect ke profil jika belum lengkap
            return redirect()->route('profile.edit')->with('error', 'Harap lengkapi Alamat dan Nomor Telepon di profil Anda sebelum checkout.');
        }

        // 3. Ambil data produk
        $product = Product::findOrFail($request->product_id);
        $quantity = (int) $request->quantity;

        // 4. Cek Stok Produk
        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }

        // 5. Hitung harga
        $pricePerItem = $product->finalPrice; // Ambil harga (sudah termasuk diskon jika ada)
        $totalPrice = $pricePerItem * $quantity;
        $invoiceNumber = 'INV-' . strtoupper(uniqid()); // Buat invoice

        // 6. Buat Pesanan (Transaksi DB)
        try {
            DB::beginTransaction();

            // Buat Order (sesuai tabel 'orders' Anda)
            $order = Order::create([
                'user_id' => $user->id,
                'invoice_number' => $invoiceNumber,
                'total_price' => $totalPrice,
                'status' => 'pending',         // Status default
                'payment_status' => 'unpaid',  // Status default
                'shipping_address' => $userAddress,
                'phone_number' => $userPhone,
            ]);

            // Buat OrderItem (sesuai tabel 'order_items' Anda)
            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $pricePerItem,
            ]);

            DB::commit();

            // 7. Buat Pesan WhatsApp
            $waMessage = "Halo 3 Saudara! Saya ingin *Pesan Langsung*:\n\n";
            $waMessage .= "Nomor Invoice: *{$invoiceNumber}*\n";
            $waMessage .= "Nama: " . $user->name . "\n";
            $waMessage .= "Telepon: " . $userPhone . "\n";
            $waMessage .= "Alamat: " . $userAddress . "\n\n";
            $waMessage .= "Detail Pesanan:\n";
            $waMessage .= "- {$product->name} (x{$quantity}) @ Rp " . number_format($pricePerItem, 0, ',', '.') . "\n";
            $waMessage .= "\nTotal: *Rp " . number_format($totalPrice, 0, ',', '.') . "*\n\n";
            $waMessage .= "Mohon info untuk total dan rekening pembayarannya. Terima kasih.";

            // 8. Redirect ke WhatsApp

            $waNumber = $this->getWhatsappNumber();


            $waLink = "https://wa.me/{$waNumber}?text=" . urlencode($waMessage);


            return redirect()->away($waLink);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function getCartResponse(): JsonResponse
    {
        $cartItems = Cart::content();

        // Ambil data gambar terbaru dari database
        $productIds = $cartItems->pluck('id');
        $productImages = Product::whereIn('id', $productIds)->pluck('image', 'id');

        $items = $cartItems->map(function ($item) use ($productImages) {

            $imageUrl = 'https://via.placeholder.com/80'; // Gambar default

            // Cek jika ID produk ada di hasil query kita
            if (isset($productImages[$item->id]) && !empty($productImages[$item->id])) {

                // $productImages[$item->id] berisi: "product-images/FILE.jpg"
                // Storage::url() akan mengubahnya menjadi: "/storage/product-images/FILE.jpg"

                // KITA HAPUS PENGECEKAN 'exists()' DAN LANGSUNG BUAT URL
                $imageUrl = Storage::url($productImages[$item->id]);
            }


            $item->options->put('image_url', $imageUrl);

            return $item;
        });

        return response()->json([
            'items' => $items->keyBy('rowId'),
            'count' => Cart::count(),
            'subtotal' => 'Rp ' . Cart::subtotal(0, ',', '.'),
        ]);
    }

    /**
     * Mengambil konten keranjang saat ini.
     */
    public function content(): JsonResponse
    {
        return $this->getCartResponse();
    }

    /**
     * Menambahkan produk ke keranjang.
     */
    public function add(Request $request): JsonResponse
    {
        if (Auth::check() && Auth::user()->is_admin) {
            // Kirim respon JSON 'Forbidden' (Dilarang)
            return response()->json(['message' => 'Admin tidak diizinkan untuk mengelola keranjang.'], 403);
        }

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        if ($product->stock < $quantity) {
            return response()->json(['message' => 'Stok tidak mencukupi!'], 422);
        }

        Cart::add(
            $product->id,
            $product->name,
            $quantity,
            $product->finalPrice,
            [
                // HAPUS 'image' dari sini agar tidak menyimpan data basi
                // 'image' => $product->image, // <--- HAPUS BARIS INI
                'unit' => $product->unit,
                'stock' => $product->stock
            ]
        );

        return $this->getCartResponse();
    }

    /**
     * Memperbarui kuantitas item di keranjang.
     */
    public function update(Request $request, $rowId): JsonResponse
    {
        if (Auth::check() && Auth::user()->is_admin) {
            // Kirim respon JSON 'Forbidden' (Dilarang)
            return response()->json(['message' => 'Admin tidak diizinkan untuk mengelola keranjang.'], 403);
        }

        $item = Cart::get($rowId);
        $stock = $item->options->stock ?? 0;

        if ($request->action == 'increase') {
            if ($item->qty + 1 > $stock) {
                return response()->json(['message' => 'Stok tidak mencukupi!'], 422);
            }
            Cart::update($rowId, $item->qty + 1);
        } elseif ($request->action == 'decrease') {
            Cart::update($rowId, $item->qty - 1);
        }

        return $this->getCartResponse();
    }

    /**
     * Menghapus item dari keranjang.
     */
    public function remove($rowId): JsonResponse
    {
        if (Auth::check() && Auth::user()->is_admin) {
            // Kirim respon JSON 'Forbidden' (Dilarang)
            return response()->json(['message' => 'Admin tidak diizinkan untuk mengelola keranjang.'], 403);
        }

        Cart::remove($rowId);
        return $this->getCartResponse();
    }

    /**
     * Menghapus semua item dari keranjang.
     */
    public function clear(): JsonResponse
    {
        if (Auth::check() && Auth::user()->is_admin) {
            // Kirim respon JSON 'Forbidden' (Dilarang)
            return response()->json(['message' => 'Admin tidak diizinkan untuk mengelola keranjang.'], 403);
        }

        Cart::destroy();
        return $this->getCartResponse();
    }
}
