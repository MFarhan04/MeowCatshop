@extends('layouts.admin')
@section('title', 'Laporan Penjualan')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4 print:hidden">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Laporan Penjualan</h2>
        <p class="text-slate-500 text-sm mt-1">Rekapitulasi pendapatan dari pesanan yang telah selesai.</p>
    </div>
    <div class="flex gap-2">
        <button onclick="window.print()" class="bg-indigo-600 text-white px-4 py-2.5 rounded-xl font-bold text-sm hover:bg-indigo-700 shadow-sm transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Cetak Laporan
        </button>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6 print:hidden">
    <form action="{{ route('admin.report') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
        <div class="flex-grow">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Mulai</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none">
        </div>
        <div class="flex-grow">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Akhir</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-slate-800 text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-900 transition-colors">Terapkan</button>
            <a href="{{ route('admin.report') }}" class="bg-slate-100 text-slate-600 px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-200 transition-colors text-center border border-slate-200">Reset</a>
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden print:border-none print:shadow-none print:rounded-none">

    <div class="p-8 border-b border-slate-200 text-center">
        <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tighter">MEOW CATSHOP</h1>
        <p class="text-slate-500 text-sm mt-1">Laporan Penjualan Produk & Aksesoris Hewan Peliharaan</p>
        <p class="text-slate-500 text-sm">
            Periode:
            @if(request('start_date') && request('end_date'))
            <span class="font-bold">{{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }}</span> s/d <span class="font-bold">{{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}</span>
            @else
            <span class="font-bold">Keseluruhan Waktu</span>
            @endif
        </p>
    </div>

    <div class="p-6 bg-slate-50/50 flex justify-between items-center border-b border-slate-200">
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Transaksi Selesai</p>
            <p class="text-xl font-black text-slate-800">{{ $orders->count() }} Transaksi</p>
        </div>
        <div class="text-right">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Pendapatan Bersih</p>
            <p class="text-2xl font-black text-emerald-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-xs border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 font-semibold">No</th>
                    <th class="px-6 py-4 font-semibold">ID / Tanggal</th>
                    <th class="px-6 py-4 font-semibold">Nama Pelanggan</th>
                    <th class="px-6 py-4 font-semibold text-center">Metode</th>
                    <th class="px-6 py-4 font-semibold text-right">Ongkir</th>
                    <th class="px-6 py-4 font-semibold text-right">Subtotal Barang</th>
                    <th class="px-6 py-4 font-semibold text-right text-slate-900">Total Dibayar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $index => $order)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 font-medium">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-900">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                        <div class="text-xs text-slate-500">{{ $order->created_at->format('d/m/Y') }}</div>
                    </td>
                    <td class="px-6 py-4 font-medium text-slate-900">{{ $order->customer_name ?? $order->user->name }}</td>

                    <td class="px-6 py-4 text-center">
                        <div class="flex flex-col gap-1 items-center">
                            <span class="text-[10px] font-bold text-slate-500 uppercase">
                                {{ $order->shipping_method == 'pickup' ? 'Ambil Toko' : 'Kurir' }}
                            </span>
                            <span class="text-[10px] font-black uppercase {{ $order->payment_method == 'cash' ? 'text-emerald-600' : 'text-amber-600' }}">
                                {{ $order->payment_method == 'cash' ? 'Tunai' : 'Transfer' }}
                            </span>
                        </div>
                    </td>

                    <td class="px-6 py-4 text-right">Rp {{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right font-bold text-slate-900">
                        Rp {{ number_format($order->total_price + ($order->shipping_cost ?? 0), 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-slate-500 font-medium">
                        Tidak ada data penjualan pada periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    /* CSS Khusus agar hasil print rapi */
    @media print {
        body {
            background-color: white !important;
        }

        .print\:hidden {
            display: none !important;
        }

        .print\:border-none {
            border: none !important;
        }

        .print\:shadow-none {
            box-shadow: none !important;
        }

        .print\:rounded-none {
            border-radius: 0 !important;
        }

        /* Jika kamu menggunakan sidebar, tambahkan class sidebar-mu di sini untuk disembunyikan saat print */
        aside,
        header,
        nav {
            display: none !important;
        }

        main {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }
    }
</style>
@endsection