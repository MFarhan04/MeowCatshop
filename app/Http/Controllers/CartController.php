<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting; // Pastikan ini ada untuk mengecek status toko
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // ==========================================
    // 1. Tampilkan Halaman Keranjang Belanja
    // ==========================================
    public function index()
    {
        return view('cart');
    }

    // ==========================================
    // 2. Tambah Produk ke Keranjang (Session)
    // ==========================================
    public function add(Request $request, $id)
    {
        // PROTEKSI: Cek status toko sebelum mengizinkan tambah barang
        $shopStatus = Setting::where('key', 'shop_status')->first()->value ?? 'open';
        if ($shopStatus == 'closed') {
            return redirect()->back()->with('error', 'Maaf, Toko Meow Catshop sedang tutup sementara. Anda belum bisa menambahkan produk ke keranjang.');
        }

        $product = Product::findOrFail($id);
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        Session::put('cart', $cart);
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // ==========================================
    // 3. Update Jumlah (Qty) di Keranjang
    // ==========================================
    public function updateQuantity(Request $request, $id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $product = Product::find($id);
            $newQty = $request->quantity;

            if ($product && $product->stock >= $newQty) {
                $cart[$id]['quantity'] = $newQty;
                Session::put('cart', $cart);
                return redirect()->back()->with('success', 'Jumlah barang berhasil diupdate!');
            }

            return redirect()->back()->with('error', 'Maaf, stok produk tidak mencukupi untuk jumlah tersebut.');
        }

        return redirect()->back();
    }

    // ==========================================
    // 4. Hapus Produk dari Keranjang
    // ==========================================
    public function remove($id)
    {
        $cart = Session::get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang!');
    }

    // ==========================================
    // 5. Tampilkan Halaman Form Checkout
    // ==========================================
    public function showCheckout()
    {
        // PROTEKSI: Cek status toko sebelum masuk halaman checkout
        $shopStatus = Setting::where('key', 'shop_status')->first()->value ?? 'open';
        if ($shopStatus == 'closed') {
            return redirect()->route('cart.index')->with('error', 'Maaf, proses checkout tidak bisa dilanjutkan karena toko sedang tutup.');
        }

        $cart = Session::get('cart');

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda masih kosong.');
        }

        return view('checkout');
    }

    // ==========================================
    // 6. Simpan Pesanan (Store Order) ke Database
    // ==========================================
    public function storeOrder(Request $request)
    {
        // PROTEKSI
        $shopStatus = Setting::where('key', 'shop_status')->first()->value ?? 'open';
        if ($shopStatus == 'closed') {
            return redirect()->route('cart.index')->with('error', 'Maaf, pesanan gagal dibuat karena toko saat ini sedang tutup.');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'shipping_method' => 'required|in:pickup,delivery',
            'payment_method' => 'required|in:transfer,cash'
        ]);

        $cart = Session::get('cart');
        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        if ($request->shipping_method == 'pickup') {
            $status = 'menunggu pembayaran';
            $shippingCost = 0;
        } else {
            $status = 'menunggu ongkir';
            $shippingCost = null;
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'customer_name' => $request->customer_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'shipping_method' => $request->shipping_method,
            'payment_method' => $request->payment_method,
            'shipping_cost' => $shippingCost,
            'total_price' => $totalPrice,
            'status' => $status
        ]);

        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price']
            ]);

            $product = Product::find($id);
            if ($product) {
                $product->decrement('stock', $details['quantity']);
            }
        }

        Session::forget('cart');

        if ($request->shipping_method == 'delivery') {
            return redirect()->route('user.orders')->with('success', 'Pesanan dibuat! Mohon tunggu Admin mengecek ongkos kirim sebelum Anda melakukan pembayaran.');
        }

        if ($request->shipping_method == 'pickup' && $request->payment_method == 'transfer') {
            return redirect()->route('cart.payment', $order->id)->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
        }

        return redirect()->route('user.orders')->with('success', 'Pesanan berhasil dibuat! Silakan datang ke toko untuk mengambil barang dan membayar di kasir.');
    }

    // ==========================================
    // 7. Tampilkan Halaman Pembayaran
    // ==========================================
    public function payment($id)
    {
        $order = Order::findOrFail($id);

        if ($order->user_id != Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        return view('payment', compact('order'));
    }

    // ==========================================
    // 8. Proses Upload Bukti Pembayaran
    // ==========================================
    public function uploadReceipt(Request $request, $id)
    {
        // PROTEKSI UPLOAD
        $shopStatus = Setting::where('key', 'shop_status')->first()->value ?? 'open';
        if ($shopStatus == 'closed') {
            return redirect()->back()->with('error', 'Maaf, operasional toko sedang dihentikan sementara. Anda tidak dapat mengirim bukti pembayaran saat ini.');
        }

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $order = Order::findOrFail($id);

        if ($order->user_id != Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        if ($request->hasFile('bukti_pembayaran')) {
            $receiptPath = $request->file('bukti_pembayaran')->store('receipts', 'public');

            $order->update([
                'payment_receipt' => $receiptPath,
                'status' => 'menunggu konfirmasi'
            ]);

            return redirect()->route('user.orders')->with('success', 'Bukti pembayaran berhasil dikirim! Mohon tunggu konfirmasi dari Admin Meow Catshop.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah file bukti pembayaran.');
    }

    // ==========================================
    // 9. Tampilkan Riwayat Pesanan Saya
    // ==========================================
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('status', 'not like', '%_hidden')
            ->latest()
            ->get();
        return view('pesanan', compact('orders'));
    }

    // ==========================================
    // 9.5. Sembunyikan Riwayat Pesanan (Trik)
    // ==========================================
    public function hideOrder($id)
    {
        $order = Order::findOrFail($id);

        if ($order->user_id != Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        $order->update([
            'status' => $order->status . '_hidden'
        ]);

        return redirect()->back()->with('success', 'Riwayat pesanan berhasil dihapus dari tampilan Anda!');
    }

    // ==========================================
    // 9.6. Batalkan Pesanan oleh User
    // ==========================================
    public function cancelOrder($id)
    {
        // PROTEKSI BATALKAN PESANAN
        $shopStatus = Setting::where('key', 'shop_status')->first()->value ?? 'open';
        if ($shopStatus == 'closed') {
            return redirect()->back()->with('error', 'Maaf, operasional toko sedang dihentikan sementara. Anda tidak bisa membatalkan pesanan saat ini.');
        }

        $order = Order::with('items.product')->findOrFail($id);

        if ($order->user_id != Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        $cancelableStatuses = ['menunggu ongkir', 'menunggu pembayaran', 'menunggu konfirmasi'];
        $cleanStatus = str_replace('_hidden', '', strtolower($order->status));

        if (in_array($cleanStatus, $cancelableStatuses)) {

            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }

            $order->update([
                'status' => 'batal'
            ]);

            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan dan stok barang telah dikembalikan ke toko.');
        }

        return redirect()->back()->with('error', 'Gagal membatalkan. Pesanan ini sudah diproses atau dikirim oleh admin.');
    }

    // ==========================================
    // 9.7. Konfirmasi Barang Sudah Sampai (Baru)
    // ==========================================
    public function confirmDelivery($id)
    {
        // PROTEKSI KONFIRMASI BARANG
        $shopStatus = Setting::where('key', 'shop_status')->first()->value ?? 'open';
        if ($shopStatus == 'closed') {
            return redirect()->back()->with('error', 'Maaf, operasional toko sedang dihentikan sementara. Anda tidak bisa mengonfirmasi pesanan saat ini.');
        }

        $order = Order::findOrFail($id);

        if ($order->user_id != Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        $cleanStatus = str_replace('_hidden', '', strtolower($order->status));

        // Hanya bisa dikonfirmasi jika kurir sedang mengirim barang
        if ($cleanStatus == 'dikirim') {
            $order->update([
                'status' => 'selesai'
            ]);

            return redirect()->back()->with('success', 'Terima kasih atas konfirmasinya! Pesanan Anda telah selesai.');
        }

        return redirect()->back()->with('error', 'Gagal konfirmasi. Status paket saat ini belum dikirim.');
    }

    // ==========================================
    // 10. Cetak Nota (Invoice)
    // ==========================================
    public function printInvoice($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        if (Auth::user()->role != 'admin' && $order->user_id != Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        return view('invoice', compact('order'));
    }
}
