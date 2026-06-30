<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Models\Product;

// =======================================================
// 1. RUTE HALAMAN DEPAN & FILTER KATALOG (USER PUBLIK)
// =======================================================
Route::get('/', function (Request $request) {
    // Ambil data produk terbaru
    $query = Product::latest();

    // Fitur Pencarian Nama Produk
    if ($request->has('cari') && $request->cari != '') {
        $query->where('name', 'like', '%' . $request->cari . '%');
    }

    // Fitur Filter Tipe Produk (Makanan Basah/Kering/Pasir)
    if ($request->has('jenis') && $request->jenis != '') {
        $query->where('jenis_barang', $request->jenis);
    }

    // Fitur Filter Usia Kucing (Kitten/Adult/Senior/Mother dll)
    if ($request->has('usia') && $request->usia != '') {
        $query->where('usia_kucing', $request->usia);
    }

    $products = $query->get();
    return view('welcome', compact('products'));
})->name('home');


// =======================================================
// 2. RUTE KERANJANG (USER PUBLIK)
// =======================================================
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang/tambah/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/keranjang/update-qty/{id}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
Route::post('/keranjang/hapus/{id}', [CartController::class, 'remove'])->name('cart.remove');


// =======================================================
// 3. RUTE AUTENTIKASI (LOGIN, REGISTER, LOGOUT)
// =======================================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// =======================================================
// 4. RUTE PELANGGAN TERDAFTAR (DIKUNCI: WAJIB LOGIN)
// =======================================================
Route::middleware(['auth'])->group(function () {

    // --- Kelola Profil ---
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profil/update', [ProfileController::class, 'update'])->name('profile.update');

    // --- Form Checkout & Simpan Pesanan ---
    Route::get('/checkout', [CartController::class, 'showCheckout'])->name('cart.checkout_form');
    Route::post('/checkout', [CartController::class, 'storeOrder'])->name('cart.store_order');

    // --- Pembayaran & Upload Bukti ---
    Route::get('/pembayaran/{id}', [CartController::class, 'payment'])->name('cart.payment');
    Route::post('/pembayaran/{id}/upload', [CartController::class, 'uploadReceipt'])->name('cart.uploadReceipt');

    // --- Riwayat Pesanan Saya ---
    Route::get('/pesanan-saya', [CartController::class, 'myOrders'])->name('user.orders');

    // --- Cetak Nota Pembelian ---
    Route::get('/pesanan-saya/cetak/{id}', [CartController::class, 'printInvoice'])->name('user.printInvoice');

    // --- Konfirmasi Barang Sampai oleh User ---
    Route::post('/pesanan-saya/selesai/{id}', [CartController::class, 'confirmDelivery'])->name('user.orders.confirm');

    // --- Batalkan Pesanan oleh User ---
    Route::post('/pesanan-saya/batal/{id}', [CartController::class, 'cancelOrder'])->name('user.orders.cancel');

    // --- Sembunyikan Riwayat Pesanan Saya (Delete by User) ---
    Route::post('/pesanan-saya/hapus/{id}', [CartController::class, 'hideOrder'])->name('user.orders.hide');
});


// =======================================================
// 5. RUTE HALAMAN ADMIN (DIKUNCI: WAJIB LOGIN + ADMIN)
// =======================================================
Route::middleware(['auth', 'admin'])->group(function () {

    // --- Dashboard Admin (Statistik & Daftar Produk) ---
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // --- Kelola Produk ---
    Route::get('/admin/tambah', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/tambah', [AdminController::class, 'store'])->name('admin.store');

    Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::post('/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');

    Route::post('/admin/hapus/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

    // --- FITUR BARU: QUICK UPDATE STOK ---
    Route::post('/admin/products/{id}/stock', [AdminController::class, 'updateStock'])->name('admin.updateStock');

    // --- Kelola Pesanan (Orders) & Ongkir ---
    Route::get('/admin/pesanan', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/pesanan/{id}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
    Route::post('/admin/pesanan/status/{id}', [AdminController::class, 'updateOrderStatus'])->name('admin.updateOrderStatus');
    Route::post('/admin/pesanan/ongkir/{id}', [AdminController::class, 'setShippingCost'])->name('admin.setShippingCost');

    // --- Hapus Riwayat Pesanan Permanen ---
    Route::post('/admin/pesanan/hapus/{id}', [AdminController::class, 'destroyOrder'])->name('admin.orders.destroy');

    // --- Cetak Laporan Penjualan ---
    Route::get('/admin/laporan', [AdminController::class, 'report'])->name('admin.report');

    // --- Manajemen Pengguna (User Management) ---
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users/{id}/toggle-role', [AdminController::class, 'toggleRole'])->name('admin.users.toggleRole');
    Route::post('/admin/users/{id}/delete', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // --- Fitur Buka/Tutup Toko ---
    Route::post('/admin/toggle-shop', [AdminController::class, 'toggleShopStatus'])->name('admin.toggleShop');
});
