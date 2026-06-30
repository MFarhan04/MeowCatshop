@extends('layouts.admin')
@section('title', 'Edit Data Produk')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Edit Data Produk</h2>
            <p class="text-slate-500 text-sm mt-1">Perbarui informasi produk <strong>{{ $product->name }}</strong> di etalase toko.</p>
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

    <!-- Form Edit Produk -->
    <form action="{{ route('admin.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @csrf

        <div class="p-6 sm:p-8 space-y-6">

            <!-- Nama Produk -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
            </div>

            <!-- Grid Harga & Stok -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 font-bold text-slate-400">Rp</span>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" class="w-full pl-12 p-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jumlah Stok (Pcs) <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                </div>
            </div>

            <!-- Grid Kategori & Usia Kucing -->
            <!-- Kategori / Tipe Produk (Edit) -->
            <div class="form-group mb-4">
                <label class="font-bold mb-2 block">Tipe Produk</label>
                <select name="jenis_barang" class="w-full border p-2 rounded" required>
                    <option value="Makanan Basah" {{ $product->jenis_barang == 'Makanan Basah' ? 'selected' : '' }}>Makanan Basah</option>
                    <option value="Makanan Kering" {{ $product->jenis_barang == 'Makanan Kering' ? 'selected' : '' }}>Makanan Kering</option>
                    <option value="Pasir" {{ $product->jenis_barang == 'Pasir' ? 'selected' : '' }}>Pasir Kucing</option>
                </select>
            </div>

            <!-- Usia Kucing (Edit) -->
            <div class="form-group mb-4">
                <label class="font-bold mb-2 block">Peruntukan Usia</label>
                <select name="usia_kucing" class="w-full border p-2 rounded" required>
                    <option value="Kitten Food" {{ $product->usia_kucing == 'Kitten Food' ? 'selected' : '' }}>Kitten</option>
                    <option value="Adult Cat Food" {{ $product->usia_kucing == 'Adult Cat Food' ? 'selected' : '' }}>Adult</option>
                    <option value="Senior Cat Food" {{ $product->usia_kucing == 'Senior Cat Food' ? 'selected' : '' }}>Senior</option>
                    <option value="Mother" {{ $product->usia_kucing == 'Mother' ? 'selected' : '' }}>Mother</option>
                    <option value="Mother and Kitten" {{ $product->usia_kucing == 'Mother and Kitten' ? 'selected' : '' }}>Mother & Kitten</option>
                    <option value="All Stages" {{ $product->usia_kucing == 'All Stages' ? 'selected' : '' }}>All Stages</option>
                </select>
            </div>

            <!-- Foto Produk (Preview & Ganti) -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Foto Produk</label>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 border border-slate-200 rounded-xl bg-slate-50">
                    <!-- Preview Gambar Lama -->
                    <div class="shrink-0 relative group">
                        <img src="{{ asset('storage/'.$product->image) }}" alt="Preview" class="w-24 h-24 object-cover rounded-lg border border-slate-300 bg-white shadow-sm">
                        <div class="absolute inset-0 bg-black/50 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="text-[10px] text-white font-bold uppercase tracking-wider">Foto Lama</span>
                        </div>
                    </div>

                    <!-- Input Ganti Gambar -->
                    <div class="flex-grow w-full">
                        <input type="file" name="image" accept="image/*" class="w-full p-2 bg-white border border-slate-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer">
                        <p class="text-xs text-slate-500 mt-2 font-medium"><span class="text-amber-600 font-bold">Catatan:</span> Kosongkan kolom ini jika kamu tidak ingin mengganti foto produk yang sudah ada.</p>
                    </div>
                </div>
            </div>

            <!-- Deskripsi Produk -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Lengkap <span class="text-red-500">*</span></label>
                <textarea name="description" rows="5" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all resize-y">{{ old('description', $product->description) }}</textarea>
            </div>

        </div>

        <!-- Bagian Tombol Submit -->
        <div class="bg-slate-50 p-6 border-t border-slate-200 flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-indigo-700 shadow-sm transition-all flex items-center gap-2 active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Simpan Perubahan Data
            </button>
        </div>

    </form>
</div>
@endsection