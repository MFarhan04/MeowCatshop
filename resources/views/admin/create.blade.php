@extends('layouts.admin')
@section('title', 'Tambah Produk Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Tambah Produk Baru</h2>
            <p class="text-slate-500 text-sm mt-1">Masukkan detail barang baru untuk ditampilkan di etalase toko.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="bg-slate-100 text-slate-700 px-4 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-200 transition-colors border border-slate-200">
            Batal & Kembali
        </a>
    </div>

    <!-- Notifikasi Error (Jika Ada) -->
    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl font-medium shadow-sm flex items-start gap-3">
        <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Tambah Produk -->
    <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @csrf

        <div class="p-6 sm:p-8 space-y-6">

            <!-- Nama Produk -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Whiskas Tuna 1.2kg" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
            </div>

            <!-- Grid Harga & Stok -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 font-bold text-slate-400">Rp</span>
                        <input type="number" name="price" value="{{ old('price') }}" required placeholder="0" min="0" class="w-full pl-12 p-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jumlah Stok (Pcs) <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" required placeholder="0" min="0" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                </div>
            </div>

            <!-- Grid Kategori & Usia Kucing -->
            <!-- Kategori / Tipe Produk -->
            <div class="form-group mb-4">
                <label class="font-bold mb-2 block">Tipe Produk</label>
                <select name="jenis_barang" class="w-full border p-2 rounded" required>
                    <option value="" disabled selected>-- Pilih Tipe Produk --</option>
                    <option value="Makanan Basah">Makanan Basah</option>
                    <option value="Makanan Kering">Makanan Kering</option>
                    <option value="Pasir">Pasir Kucing</option>
                </select>
            </div>

            <!-- Usia Kucing -->
            <div class="form-group mb-4">
                <label class="font-bold mb-2 block">Peruntukan Usia</label>
                <select name="usia_kucing" class="w-full border p-2 rounded" required>
                    <option value="" disabled selected>-- Pilih Usia Kucing --</option>
                    <option value="Kitten Food">Kitten</option>
                    <option value="Adult Cat Food">Adult</option>
                    <option value="Senior Cat Food">Senior</option>
                    <option value="Mother">Mother</option>
                    <option value="Mother and Kitten">Mother & Kitten</option>
                    <option value="All Stages">All Stages</option>
                </select>
            </div>

            <!-- Foto Produk -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Foto Produk <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="file" name="image" required accept="image/*" class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 cursor-pointer">
                </div>
                <p class="text-xs text-slate-500 mt-2">Format yang diizinkan: JPG, JPEG, PNG. Maksimal ukuran file 2MB.</p>
            </div>

            <!-- Deskripsi Produk -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Lengkap <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" required placeholder="Tuliskan keunggulan, kandungan gizi, atau detail produk di sini..." class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all resize-y">{{ old('description') }}</textarea>
            </div>

        </div>

        <!-- Bagian Tombol Submit -->
        <div class="bg-slate-50 p-6 border-t border-slate-200 flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-indigo-700 shadow-sm transition-all flex items-center gap-2 active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Produk ke Etalase
            </button>
        </div>

    </form>
</div>
@endsection