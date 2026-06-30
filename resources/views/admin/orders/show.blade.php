@extends('layouts.admin')
@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.orders') }}" class="text-slate-500 hover:text-indigo-600 text-sm font-bold flex items-center gap-2 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Daftar Pesanan
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <div class="lg:col-span-2 space-y-6">

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <h3 class="font-bold text-slate-800 text-lg mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Informasi Pengiriman
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                <div>
                    <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest mb-1">Penerima</p>
                    <p class="font-bold text-slate-900">{{ $order->customer_name }}</p>
                </div>
                <div>
                    <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest mb-1">WhatsApp</p>
                    <p class="font-bold text-slate-900">{{ $order->phone }}</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest mb-1">Alamat Lengkap</p>
                    <p class="font-semibold text-slate-700 leading-relaxed">{{ $order->address }}</p>
                </div>
                @if($order->note)
                <div class="sm:col-span-2 mt-2">
                    <p class="text-xs font-semibold text-amber-500 uppercase tracking-wider mb-1">Catatan dari Pembeli</p>
                    <div class="bg-amber-50 text-amber-800 p-4 rounded-xl border border-amber-100 text-sm italic">
                        "{{ $order->note }}"
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 bg-slate-50/50 border-b border-slate-200">
                <h3 class="font-bold text-slate-800 text-base uppercase text-[10px] tracking-widest">Produk yang Dibeli</h3>
            </div>
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 text-[10px] uppercase font-black border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3 text-center">Qty</th>
                        <th class="px-6 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="px-6 py-4 font-bold text-slate-900 flex items-center gap-3">
                            <img src="{{ asset('storage/' . ($item->product->image ?? 'default.jpg')) }}" class="w-10 h-10 rounded bg-slate-100 object-cover">
                            {{ $item->product->name ?? 'Produk Dihapus' }}
                        </td>
                        <td class="px-6 py-4 text-center font-bold">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 text-right font-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="space-y-6">

        <div class="bg-indigo-600 rounded-2xl p-6 shadow-sm text-white">
            <h3 class="font-bold text-indigo-100 uppercase text-[10px] tracking-widest mb-4">Total Pembayaran & Metode</h3>

            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-indigo-200">Pengiriman</span>
                    <span class="font-black uppercase text-white bg-indigo-500 px-2 py-0.5 rounded text-xs">
                        {{ $order->shipping_method == 'pickup' ? 'Ambil di Toko' : 'Kirim Kurir' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-indigo-200">Pembayaran</span>
                    <span class="font-black uppercase {{ $order->payment_method == 'cash' ? 'text-[#4ade80]' : 'text-[#fde047]' }}">
                        {{ $order->payment_method == 'cash' ? 'Tunai (Cash)' : 'Transfer Bank' }}
                    </span>
                </div>

                @php
                $cleanStatus = str_replace('_hidden', '', strtolower($order->status));
                $needsAction = in_array($cleanStatus, ['menunggu ongkir', 'menunggu konfirmasi']);
                @endphp
                <div class="flex justify-between pb-3 border-b border-indigo-500/50 mb-3">
                    <span class="text-indigo-200">Status Saat Ini</span>
                    <span class="font-black uppercase text-xs px-2 py-0.5 rounded shadow-sm {{ $needsAction ? 'bg-[#fde047] text-black animate-pulse' : 'bg-white text-indigo-700' }}">
                        {{ $cleanStatus }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-indigo-200">Subtotal</span>
                    <span class="font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-indigo-200">Ongkir</span>
                    <span class="font-bold">Rp {{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="pt-4 border-t border-indigo-500 flex justify-between items-end">
                    <span class="font-black uppercase text-xs">Total Tagihan</span>
                    <span class="text-2xl font-black">Rp {{ number_format($order->total_price + ($order->shipping_cost ?? 0), 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm"
            x-data="{ status: '{{ $order->status }}', shippingCost: '{{ $order->shipping_cost ?? '' }}' }">

            <h3 class="font-bold text-slate-400 text-[10px] uppercase tracking-widest mb-4">Kontrol Status Paket</h3>

            <form action="{{ route('admin.updateOrderStatus', $order->id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-slate-400 font-bold uppercase text-[10px] tracking-widest mb-1">Status Transaksi</label>
                    <select name="status" x-model="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold uppercase outline-none focus:ring-2 focus:ring-indigo-500 transition-all cursor-pointer">
                        <option value="menunggu ongkir">Menunggu Ongkir</option>
                        <option value="menunggu pembayaran">Menunggu Pembayaran</option>
                        <option value="menunggu konfirmasi">Konfirmasi Bayar</option>
                        <option value="diproses">Diproses</option>
                        <option value="dikirim">Dikirim</option>
                        <option value="selesai">Selesai</option>
                        <option value="batal">Batal</option>
                    </select>
                </div>

                <div class="mb-4" x-show="status === 'menunggu ongkir'" x-cloak>
                    <label class="block text-slate-400 font-bold uppercase text-[10px] tracking-widest mb-1">Input Nominal Ongkir</label>
                    <div class="relative">
                        <input type="number" name="shipping_cost" x-model="shippingCost"
                            placeholder="Contoh: 15000"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>

                <button type="submit" class="w-full bg-slate-900 text-white font-bold py-3 rounded-xl text-xs hover:bg-black transition-all shadow-sm">
                    Simpan Perubahan
                </button>
            </form>
        </div>

        @if($order->payment_receipt)
        <div class="bg-sky-50 rounded-2xl border border-sky-100 p-6 shadow-sm">
            <h3 class="font-bold text-sky-800 text-[10px] uppercase tracking-widest mb-3">Bukti Pembayaran</h3>
            <a href="{{ asset('storage/'.$order->payment_receipt) }}" target="_blank" class="block rounded-xl overflow-hidden border-2 border-white shadow-sm hover:scale-[1.02] transition-transform">
                <img src="{{ asset('storage/'.$order->payment_receipt) }}" class="w-full h-auto">
            </a>
            <p class="text-[10px] text-sky-600 mt-3 text-center font-bold uppercase">Klik gambar untuk memperbesar</p>
        </div>
        @elseif($cleanStatus == 'menunggu konfirmasi' || $cleanStatus == 'diproses' || $cleanStatus == 'dikirim' || $cleanStatus == 'selesai')
        <div class="bg-slate-50 border border-dashed border-slate-300 rounded-xl p-6 text-center">
            <p class="text-xs font-bold text-slate-500 uppercase">Pelanggan belum/tidak mengunggah bukti bayar.</p>
        </div>
        @endif

    </div>
</div>
@endsection