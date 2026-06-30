<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Setting; // Ditambahkan untuk memanggil tabel Setting (Status Toko)
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // =======================================================
    // 1. DASHBOARD & MANAJEMEN PRODUK
    // =======================================================

    public function index()
    {
        $totalPendapatan = Order::whereIn('status', ['selesai', 'selesai_hidden'])->get()->sum(function ($order) {
            return $order->total_price + ($order->shipping_cost ?? 0);
        });

        $pesananBaru = Order::whereIn('status', ['menunggu ongkir', 'menunggu pembayaran', 'menunggu konfirmasi'])->count();
        $totalProduk = Product::count();
        $products = Product::latest()->get();

        // AMBIL STATUS TOKO (Default: open jika belum ada di DB)
        $shopStatus = Setting::where('key', 'shop_status')->first()->value ?? 'open';

        return view('admin.index', compact('totalPendapatan', 'pesananBaru', 'totalProduk', 'products', 'shopStatus'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'jenis_barang' => 'required|string',
            'usia_kucing' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'required|string',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'jenis_barang' => $request->jenis_barang,
            'usia_kucing' => $request->usia_kucing,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Produk baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'jenis_barang' => 'required|string',
            'usia_kucing' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'required|string',
        ]);

        $dataToUpdate = [
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'jenis_barang' => $request->jenis_barang,
            'usia_kucing' => $request->usia_kucing,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $dataToUpdate['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($dataToUpdate);

        return redirect()->route('admin.dashboard')->with('success', 'Data produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Produk berhasil dihapus dari katalog!');
    }


    // =======================================================
    // 2. MANAJEMEN PESANAN (ORDERS)
    // =======================================================

    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = Order::with('items.product', 'user')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|string',
            'shipping_cost' => 'nullable|numeric|min:0'
        ]);

        $updateData = [
            'status' => $request->status
        ];

        if ($request->has('shipping_cost') && $request->shipping_cost !== null) {
            $updateData['shipping_cost'] = $request->shipping_cost;

            // LOGIKA PINTAR: Cek metode pembayaran saat ongkir pertama kali diinput
            if ($request->status == 'menunggu ongkir' && $request->shipping_cost > 0) {
                if ($order->payment_method == 'cash') {
                    $updateData['status'] = 'diproses';
                } else {
                    $updateData['status'] = 'menunggu pembayaran';
                }
            }
        }

        $order->update($updateData);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui sesuai metode pembayarannya!');
    }

    public function setShippingCost(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'shipping_cost' => 'required|numeric|min:0'
        ]);

        $order->update([
            'shipping_cost' => $request->shipping_cost,
            'status' => 'menunggu pembayaran'
        ]);

        return redirect()->back()->with('success', 'Ongkos kirim berhasil ditetapkan!');
    }

    // =======================================================
    // 3. HAPUS PESANAN (DESTROY ORDER)
    // =======================================================

    public function destroyOrder($id)
    {
        $order = Order::findOrFail($id);

        if ($order->payment_receipt && Storage::disk('public')->exists($order->payment_receipt)) {
            Storage::disk('public')->delete($order->payment_receipt);
        }

        $order->items()->delete();
        $order->delete();

        return redirect()->route('admin.orders')->with('success', 'Riwayat transaksi berhasil dihapus secara permanen dari sistem.');
    }

    // =======================================================
    // 4. LAPORAN PENJUALAN (REPORTING)
    // =======================================================

    public function report(Request $request)
    {
        $query = Order::with('user')->whereIn('status', ['selesai', 'selesai_hidden']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $orders = $query->latest()->get();

        $totalPendapatan = $orders->sum(function ($order) {
            return $order->total_price + ($order->shipping_cost ?? 0);
        });

        return view('admin.report', compact('orders', 'totalPendapatan'));
    }

    // =======================================================
    // 5. MANAJEMEN PENGGUNA (USER MANAGEMENT)
    // =======================================================

    public function users()
    {
        // Menggunakan withCount('orders') untuk menghitung jumlah transaksi tiap user
        $users = User::withCount('orders')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // FITUR: Mengubah Hak Akses (Admin <=> User)
    public function toggleRole($id)
    {
        $user = User::findOrFail($id);

        // Keamanan: Mencegah admin mengubah role dirinya sendiri agar tidak terkunci keluar sistem
        if ($user->id == auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa mengubah hak akses akun Anda sendiri!');
        }

        // Tukar role secara dinamis
        $user->role = ($user->role == 'admin') ? 'user' : 'admin';
        $user->save();

        return redirect()->route('admin.users')->with('success', 'Hak akses untuk ' . $user->name . ' berhasil diperbarui!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->id == auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun admin Anda sendiri!');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Akun pengguna berhasil dihapus dari sistem!');
    }

    // =======================================================
    // 6. FITUR DINAMIS: BUKA / TUTUP TOKO
    // =======================================================

    public function toggleShopStatus(Request $request)
    {
        // Cari atau buat baru konfigurasi 'shop_status' di tabel settings
        $setting = Setting::firstOrCreate(
            ['key' => 'shop_status'],
            ['value' => 'open']
        );

        // Tukar statusnya (jika open jadi closed, dan sebaliknya)
        $setting->value = ($setting->value == 'open') ? 'closed' : 'open';
        $setting->save();

        // Siapkan pesan notifikasi
        $pesan = ($setting->value == 'closed') ? 'Toko BERHASIL DITUTUP! Pelanggan tidak bisa memproses checkout.' : 'Toko BERHASIL DIBUKA KEMBALI!';

        return redirect()->back()->with('success', $pesan);
    }

    // =======================================================
    // 7. FITUR QUICK UPDATE STOK
    // =======================================================
    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'stock' => $request->stock
        ]);

        return redirect()->back()->with('success', 'Stok produk "' . $product->name . '" berhasil diperbarui menjadi ' . $request->stock . ' pcs!');
    }
}
