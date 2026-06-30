@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Dashboard Utama</h2>
        <p class="text-slate-500 text-sm mt-1">Ringkasan statistik toko dan manajemen amunisi Meow Catshop.</p>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <a href="{{ route('admin.report') }}" class="bg-white border border-slate-200 text-slate-700 px-4 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-50 hover:text-indigo-600 shadow-sm transition-all flex items-center gap-2 w-fit">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m4 2v-4m4 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Laporan Penjualan
        </a>

        <a href="{{ route('admin.create') }}" class="bg-indigo-600 text-white px-4 py-2.5 rounded-xl font-bold text-sm hover:bg-indigo-700 shadow-sm transition-colors flex items-center gap-2 w-fit">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Produk
        </a>
    </div>
</div>

@if(session('success'))
<div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-medium flex items-center gap-3 shadow-sm">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
    {{ session('success') }}
</div>
@endif

<div class="mb-8 p-6 rounded-2xl border flex flex-col sm:flex-row justify-between items-center gap-4 shadow-sm {{ $shopStatus == 'open' ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-rose-50 border-rose-200 text-rose-800' }}">
    <div>
        <h4 class="font-bold text-lg flex items-center gap-2">
            <span class="relative flex h-3 w-3">
                @if($shopStatus == 'open')
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                @endif
                <span class="relative inline-flex rounded-full h-3 w-3 {{ $shopStatus == 'open' ? 'bg-emerald-500' : 'bg-rose-600' }}"></span>
            </span>
            Status Operasional: {{ $shopStatus == 'open' ? 'TOKO BUKA (Menerima Pesanan)' : 'TOKO TUTUP (Mode Katalog)' }}
        </h4>
        <p class="text-sm opacity-80 mt-1 font-medium">
            {{ $shopStatus == 'open' ? 'Pelanggan dapat melakukan proses tambah keranjang dan checkout seperti biasa.' : 'Pelanggan hanya bisa melihat produk dan sistem akan menolak proses checkout.' }}
        </p>
    </div>

    <form action="{{ route('admin.toggleShop') }}" method="POST">
        @csrf
        <button type="submit" class="font-bold px-6 py-3 rounded-xl text-sm transition-all shadow-sm text-white flex items-center gap-2 {{ $shopStatus == 'open' ? 'bg-rose-600 hover:bg-rose-700' : 'bg-emerald-600 hover:bg-emerald-700' }}">
            @if($shopStatus == 'open')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            Tutup Toko Sementara
            @else
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
            </svg>
            Buka Toko Kembali
            @endif
        </button>
    </form>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">

    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col gap-4 hover:shadow-md transition-shadow relative overflow-hidden">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full z-0"></div>
        <div class="flex items-center justify-between z-10">
            <div class="bg-emerald-100 text-emerald-600 p-3 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="z-10 mt-2">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Pendapatan</p>
            <h3 class="text-2xl font-black text-slate-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col gap-4 hover:shadow-md transition-shadow relative overflow-hidden">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-50 rounded-full z-0"></div>
        <div class="flex items-center justify-between z-10">
            <div class="bg-amber-100 text-amber-600 p-3 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <a href="{{ route('admin.orders') }}" class="text-xs font-bold text-amber-600 hover:underline">Lihat Detail &rarr;</a>
        </div>
        <div class="z-10 mt-2">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Menunggu Diproses</p>
            <h3 class="text-2xl font-black text-slate-900">{{ $pesananBaru }} <span class="text-sm font-semibold text-slate-500">Antrean</span></h3>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col gap-4 hover:shadow-md transition-shadow relative overflow-hidden">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-sky-50 rounded-full z-0"></div>
        <div class="flex items-center justify-between z-10">
            <div class="bg-sky-100 text-sky-600 p-3 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
        <div class="z-10 mt-2">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Katalog Produk</p>
            <h3 class="text-2xl font-black text-slate-900">{{ $totalProduk }} <span class="text-sm font-semibold text-slate-500">Macam</span></h3>
        </div>
    </div>

    @php
    $stokMenipis = $products->where('stock', '<=', 5)->count();
    @endphp
    <div class="bg-white rounded-2xl border {{ $stokMenipis > 0 ? 'border-rose-300' : 'border-slate-200' }} p-6 shadow-sm flex flex-col gap-4 hover:shadow-md transition-shadow relative overflow-hidden">
        <div class="absolute -right-4 -top-4 w-24 h-24 {{ $stokMenipis > 0 ? 'bg-rose-50' : 'bg-slate-50' }} rounded-full z-0"></div>
        <div class="flex items-center justify-between z-10">
            <div class="{{ $stokMenipis > 0 ? 'bg-rose-100 text-rose-600 animate-pulse' : 'bg-slate-100 text-slate-600' }} p-3 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            @if($stokMenipis > 0)
            <span class="text-[10px] font-black uppercase text-rose-600 bg-rose-100 px-2 py-1 rounded-md tracking-wider border border-rose-200">Segera Restock</span>
            @endif
        </div>
        <div class="z-10 mt-2">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Stok Menipis (<= 5)</p>
            <h3 class="text-2xl font-black {{ $stokMenipis > 0 ? 'text-rose-600' : 'text-slate-900' }}">{{ $stokMenipis }} <span class="text-sm font-semibold text-slate-500">Item</span></h3>
        </div>
    </div>

</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-8 flex flex-col sm:flex-row divide-y sm:divide-y-0 sm:divide-x divide-slate-100">
    <div class="flex-1 px-4 py-2 text-center sm:text-left">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Makanan Basah (Wet Food)</p>
        <p class="text-xl font-black text-slate-800">{{ $products->where('jenis_barang', 'Makanan Basah')->count() }} <span class="text-sm text-slate-500 font-semibold">Varian</span></p>
    </div>
    <div class="flex-1 px-4 py-2 text-center sm:text-left">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Makanan Kering (Dry Food)</p>
        <p class="text-xl font-black text-slate-800">{{ $products->where('jenis_barang', 'Makanan Kering')->count() }} <span class="text-sm text-slate-500 font-semibold">Varian</span></p>
    </div>
    <div class="flex-1 px-4 py-2 text-center sm:text-left">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Pasir Kucing (Litter)</p>
        <p class="text-xl font-black text-slate-800">{{ $products->where('jenis_barang', 'Pasir')->count() }} <span class="text-sm text-slate-500 font-semibold">Varian</span></p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
        <h3 class="font-bold text-slate-800 text-lg">Daftar Produk di Etalase</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-xs border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 font-semibold">Info Produk</th>
                    <th class="px-6 py-4 font-semibold">Kategori & Usia</th>
                    <th class="px-6 py-4 font-semibold">Harga Jual</th>
                    <th class="px-6 py-4 font-semibold text-center">Stok Cepat</th>
                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($products as $product)
                <tr class="hover:bg-slate-50/50 transition-colors">

                    <td class="px-6 py-4 flex items-center gap-4">
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-14 h-14 rounded-xl object-cover border border-slate-200 bg-white">
                        <div>
                            <div class="font-bold text-slate-900 text-base mb-0.5">{{ $product->name }}</div>
                            <div class="text-xs text-slate-500 line-clamp-1 max-w-[250px]" title="{{ $product->description }}">{{ $product->description }}</div>
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-1.5">
                            <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 px-2 py-0.5 rounded text-[9px] font-bold w-max uppercase tracking-wider">
                                <i data-lucide="tag" class="w-3 h-3 inline-block mr-0.5 mb-0.5"></i>
                                {{ $product->jenis_barang }}
                            </span>
                            <span class="bg-sky-50 text-sky-700 border border-sky-200 px-2 py-0.5 rounded text-[9px] font-bold w-max uppercase tracking-wider">
                                <i data-lucide="info" class="w-3 h-3 inline-block mr-0.5 mb-0.5"></i>
                                {{ $product->usia_kucing }}
                            </span>
                        </div>
                    </td>

                    <td class="px-6 py-4 font-bold text-slate-900 text-base">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.updateStock', $product->id) }}" method="POST" class="flex flex-col items-center gap-2">
                            @csrf
                            <div class="flex items-center gap-1 bg-white border border-slate-300 rounded-lg overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500 transition-all shadow-sm">
                                <input type="number" name="stock" value="{{ $product->stock }}" min="0" class="w-16 py-1.5 px-2 text-center text-sm font-bold text-slate-700 focus:outline-none" required>
                                <button type="submit" class="bg-indigo-50 hover:bg-indigo-500 text-indigo-600 hover:text-white px-2 py-1.5 transition-colors border-l border-slate-200" title="Simpan Perubahan Stok">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </button>
                            </div>

                            @if($product->stock == 0)
                                <span class="text-[9px] font-black uppercase text-rose-600 bg-rose-50 px-2 py-0.5 rounded border border-rose-100 tracking-wider">Stok Habis</span>
                            @elseif($product->stock <= 5)
                                <span class="text-[9px] font-black uppercase text-amber-600 bg-amber-50 px-2 py-0.5 rounded border border-amber-100 tracking-wider">Menipis</span>
                            @else
                                <span class="text-[9px] font-bold uppercase text-emerald-600 tracking-wider">Aman</span>
                            @endif
                        </form>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.edit', $product->id) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 p-2.5 rounded-lg transition-colors border border-slate-200" title="Edit Produk">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini dari katalog?');">
                                @csrf
                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 p-2.5 rounded-lg transition-colors border border-rose-100" title="Hapus Produk">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center justify-center text-slate-400">
                            <svg class="w-12 h-12 mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="font-medium text-slate-500">Belum ada produk di dalam katalog.</p>
                            <a href="{{ route('admin.create') }}" class="text-indigo-600 font-bold mt-2 hover:underline">Tambahkan Produk Sekarang</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endsection
