@extends('layouts.admin')
@section('title', 'Manajemen Pesanan')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Manajemen Pesanan</h2>
        <p class="text-slate-500 text-sm mt-1">Daftar transaksi pelanggan dan kontrol pengiriman Meow Catshop.</p>
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

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
        <h3 class="font-bold text-slate-800 text-lg">Semua Transaksi</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-xs border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 font-semibold">ID / Tanggal</th>
                    <th class="px-6 py-4 font-semibold">Pelanggan</th>
                    <th class="px-6 py-4 font-semibold text-center">Metode</th>
                    <th class="px-6 py-4 font-semibold">Total Tagihan</th>
                    <th class="px-6 py-4 font-semibold text-center">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $order)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-bold text-slate-900">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                        <div class="text-xs text-slate-500">{{ $order->created_at->format('d M Y') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-900">{{ $order->customer_name }}</div>
                        <div class="text-xs text-slate-500">{{ $order->phone ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col items-center gap-1.5">
                            <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 px-2 py-0.5 rounded text-[9px] font-bold uppercase w-max tracking-wider">
                                <i data-lucide="{{ $order->shipping_method == 'pickup' ? 'store' : 'truck' }}" class="w-3 h-3 inline-block mr-0.5 mb-0.5"></i>
                                {{ $order->shipping_method == 'pickup' ? 'Ambil Toko' : 'Kurir' }}
                            </span>
                            <span class="{{ $order->payment_method == 'cash' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }} border px-2 py-0.5 rounded text-[9px] font-bold uppercase w-max tracking-wider">
                                <i data-lucide="{{ $order->payment_method == 'cash' ? 'banknote' : 'credit-card' }}" class="w-3 h-3 inline-block mr-0.5 mb-0.5"></i>
                                {{ $order->payment_method == 'cash' ? 'Tunai (Cash)' : 'Transfer' }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-bold text-slate-900">
                        Rp {{ number_format($order->total_price + ($order->shipping_cost ?? 0), 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @php
                        // PERBAIKAN: Bersihkan status dari kata '_hidden' agar warnanya tetap muncul
                        $cleanStatus = str_replace('_hidden', '', strtolower($order->status));

                        $colors = [
                        'menunggu ongkir' => 'bg-amber-50 text-amber-700 border-amber-100',
                        'menunggu pembayaran' => 'bg-orange-50 text-orange-700 border-orange-100',
                        'menunggu konfirmasi' => 'bg-sky-50 text-sky-700 border-sky-100',
                        'diproses' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                        'dikirim' => 'bg-blue-50 text-blue-700 border-blue-100',
                        'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                        'batal' => 'bg-red-50 text-red-700 border-red-100',
                        ];
                        $colorClass = $colors[$cleanStatus] ?? 'bg-slate-50 text-slate-700 border-slate-100';
                        @endphp
                        <span class="{{ $colorClass }} border px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tight">
                            {{ $cleanStatus }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2 items-center">

                            <a href="{{ route('admin.orders.show', $order->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-xs font-bold transition-colors inline-block">
                                Kelola Detail
                            </a>

                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Peringatan: Yakin ingin menghapus riwayat pesanan ini secara permanen? Data dan bukti transfer akan dihapus dari sistem!');">
                                @csrf
                                <button type="submit" class="bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 p-2 rounded-lg transition-colors border border-rose-200 shadow-sm" title="Hapus Riwayat">
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
                    <td colspan="6" class="px-6 py-16 text-center text-slate-400">Belum ada pesanan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="p-6 border-t border-slate-100">
        {{ $orders->links() }}
    </div>
    @endif
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endsection