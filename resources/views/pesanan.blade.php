<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Pesanan Saya - Meow Catshop</title>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: #f4f4f0;
            color: #000;
        }

        .brutalist-border {
            border: 4px solid #000;
        }

        /* PENGGANTI TITIK: Desain Grid Teknik */
        .bg-grid-layout {
            background-size: 30px 30px;
            background-image:
                linear-gradient(to right, rgba(0, 0, 0, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0, 0, 0, 0.05) 1px, transparent 1px);
        }

        /* Desain Garis Diagonal Halus */
        .bg-diagonal-lines {
            background-image: repeating-linear-gradient(-45deg, transparent, transparent 10px, rgba(0, 0, 0, 0.04) 10px, rgba(0, 0, 0, 0.04) 11px);
        }
    </style>
</head>

<body class="antialiased flex flex-col min-h-screen bg-grid-layout">

    @include('partials.header')

    <main class="flex-grow max-w-6xl mx-auto px-4 sm:px-6 py-12 sm:py-16 w-full relative">

        @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            class="fixed top-24 left-4 right-4 sm:left-auto sm:right-8 z-50 p-4 sm:p-5 bg-[#991b1b] brutalist-border text-white font-black uppercase shadow-[6px_6px_0px_0px_#000] flex items-center justify-between sm:justify-start gap-3 sm:gap-4 sm:max-w-sm transform transition-all">
            <div class="flex items-center gap-3">
                <i data-lucide="alert-triangle" class="w-8 h-8 sm:w-10 sm:h-10 stroke-[3px] flex-shrink-0 animate-pulse"></i>
                <span class="text-sm sm:text-base leading-tight">{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="hover:scale-125 transition-transform flex-shrink-0"><i data-lucide="x" class="w-6 h-6 stroke-[4px]"></i></button>
        </div>
        @endif

        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            class="fixed top-24 left-4 right-4 sm:left-auto sm:right-8 z-50 p-4 sm:p-5 bg-[#22d3ee] brutalist-border text-black font-black uppercase shadow-[6px_6px_0px_0px_#000] flex items-center justify-between sm:justify-start gap-3 sm:gap-4 sm:max-w-sm transform transition-all">
            <div class="flex items-center gap-3">
                <i data-lucide="party-popper" class="w-8 h-8 sm:w-10 sm:h-10 stroke-[3px] flex-shrink-0 animate-pulse"></i>
                <span class="text-sm sm:text-base leading-tight">YAY! {{ session('success') }}</span>
            </div>
            <button @click="show = false" class="hover:scale-125 transition-transform flex-shrink-0"><i data-lucide="x" class="w-6 h-6 stroke-[4px]"></i></button>
        </div>
        @endif
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 border-b-[6px] border-black pb-8">
            <div class="flex-1">
                <h1 class="text-4xl sm:text-5xl font-black uppercase tracking-tighter bg-black text-white px-6 py-3 brutalist-border shadow-[8px_8px_0px_0px_#fde047] inline-block transform -rotate-1 mb-4 sm:mb-0">
                    RIWAYAT PESANAN
                </h1>
                <p class="font-bold text-lg mt-4 text-gray-600 border-l-[4px] border-[#991b1b] pl-3">Pantau status pesanan, ongkir, dan tagihan anabulmu di sini.</p>
            </div>
            <a href="{{ route('home') }}" class="bg-[#fde047] text-black font-black uppercase px-6 py-3 brutalist-border shadow-[4px_4px_0_0_#000] hover:-translate-y-1 hover:shadow-[6px_6px_0_0_#000] transition-all flex items-center gap-2 w-full md:w-fit justify-center">
                <i data-lucide="shopping-bag" class="w-5 h-5 stroke-[3px]"></i> Belanja Lagi
            </a>
        </div>

        @if($orders->count() > 0)
        <div class="space-y-10">
            @foreach($orders as $order)

            @php $cleanStatus = str_replace('_hidden', '', strtolower($order->status)); @endphp

            <div class="bg-white brutalist-border shadow-[8px_8px_0px_0px_#000] flex flex-col lg:flex-row justify-between items-stretch transition-all duration-300 hover:shadow-[12px_12px_0px_0px_#000]">

                <div class="p-6 lg:p-8 lg:w-2/3 bg-diagonal-lines border-b-[4px] lg:border-b-0 lg:border-r-[4px] border-black flex flex-col bg-white">

                    <div class="flex flex-wrap items-center gap-2 mb-6">
                        <span class="text-[10px] font-black bg-black text-white border-2 border-black px-2 py-0.5 tracking-widest uppercase">ID: #INV-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>

                        <span class="text-[10px] font-black bg-white border-2 border-black px-2 py-0.5 flex items-center gap-1 uppercase italic"><i data-lucide="calendar" class="w-3 h-3"></i> {{ $order->created_at->format('d M Y') }}</span>

                        @if($order->shipping_method == 'pickup')
                        <span class="text-[10px] font-black bg-[#ffde59] border-2 border-black px-2 py-0.5 flex items-center gap-1 uppercase tracking-tighter"><i data-lucide="store" class="w-3 h-3"></i> Ambil Toko</span>
                        @else
                        <span class="text-[10px] font-black bg-[#38bdf8] border-2 border-black px-2 py-0.5 flex items-center gap-1 uppercase tracking-tighter"><i data-lucide="truck" class="w-3 h-3"></i> Kirim Kurir</span>
                        @endif

                        @if($order->payment_method == 'cash')
                        <span class="text-[10px] font-black bg-[#4ade80] border-2 border-black px-2 py-0.5 flex items-center gap-1 uppercase tracking-tighter"><i data-lucide="banknote" class="w-3 h-3"></i> Tunai (Cash)</span>
                        @else
                        <span class="text-[10px] font-black bg-[#c084fc] border-2 border-black px-2 py-0.5 flex items-center gap-1 uppercase tracking-tighter"><i data-lucide="credit-card" class="w-3 h-3"></i> Transfer Bank</span>
                        @endif
                    </div>

                    <h3 class="font-black text-3xl sm:text-4xl uppercase leading-none mb-4 text-black">{{ $order->customer_name }}</h3>

                    <div class="flex items-start gap-2 mb-8 group">
                        <div class="mt-1"><i data-lucide="map-pin" class="w-4 h-4 text-[#991b1b]"></i></div>
                        <p class="font-bold text-sm text-gray-600 line-clamp-2 max-w-lg leading-relaxed">
                            {{ $order->address }}
                        </p>
                    </div>

                    <div class="mt-auto bg-white border-[3px] border-black p-4 w-full sm:w-fit min-w-[280px] shadow-[4px_4px_0_0_#000]">
                        <div class="flex justify-between items-center text-xs font-bold text-gray-500 mb-2 uppercase tracking-tighter">
                            <span>Subtotal Barang</span>
                            <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs font-bold text-gray-500 border-b-[2px] border-black border-dashed pb-3 mb-3 uppercase tracking-tighter">
                            <span>Biaya Pengiriman</span>
                            <span class="{{ $order->shipping_cost === null && $order->shipping_method == 'delivery' ? 'text-[#991b1b] animate-pulse font-black' : '' }}">
                                @if($order->shipping_method == 'pickup')
                                Rp 0
                                @elseif($order->shipping_cost === null)
                                Menunggu Admin
                                @else
                                Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-black uppercase text-xs">Total Akhir</span>
                            <span class="font-black text-lg bg-[#fde047] px-2 border-[2px] border-black shadow-[2px_2px_0_0_#000]">Rp {{ number_format($order->total_price + ($order->shipping_cost ?? 0), 0, ',', '.') }}</span>
                        </div>
                    </div>

                </div>

                <div class="p-6 lg:p-8 lg:w-1/3 flex flex-col justify-center items-center gap-6 bg-[#f4f4f0]">

                    <div class="w-full text-center">
                        <p class="text-[10px] font-black uppercase text-gray-400 mb-3 tracking-[0.2em]">Kondisi Paket</p>

                        @php
                        $statusMap = [
                        'menunggu ongkir' => ['color' => 'bg-orange-400', 'icon' => 'loader', 'msg' => 'Admin sedang cek ongkir.'],
                        'menunggu pembayaran' => ['color' => 'bg-[#ffde59]', 'icon' => 'wallet', 'msg' => 'Segera lunasi tagihanmu.'],
                        'menunggu konfirmasi' => ['color' => 'bg-[#22d3ee]', 'icon' => 'search', 'msg' => 'Sedang diverifikasi admin.'],
                        'diproses' => ['color' => 'bg-[#c084fc]', 'icon' => 'package', 'msg' => 'Paket sedang disiapkan.'],
                        'dikirim' => ['color' => 'bg-[#38bdf8]', 'icon' => 'truck', 'msg' => 'Paket dalam perjalanan.'],
                        'selesai' => ['color' => 'bg-[#4ade80]', 'icon' => 'check-circle', 'msg' => 'Diterima dengan baik!'],
                        'batal' => ['color' => 'bg-[#991b1b] text-white', 'icon' => 'x-circle', 'msg' => 'Pesanan dibatalkan.'],
                        ];
                        $curr = $statusMap[$cleanStatus] ?? ['color' => 'bg-gray-200', 'icon' => 'info', 'msg' => '-'];
                        @endphp

                        <div class="{{ $curr['color'] }} brutalist-border px-4 py-3 font-black uppercase text-sm shadow-[4px_4px_0_0_#000] flex items-center justify-center gap-2 mb-2">
                            <i data-lucide="{{ $curr['icon'] }}" class="w-5 h-5 {{ $cleanStatus == 'menunggu ongkir' ? 'animate-spin' : '' }}"></i>
                            {{ strtoupper($cleanStatus) }}
                        </div>
                        <p class="text-[10px] font-bold text-gray-500 uppercase italic leading-tight">{{ $curr['msg'] }}</p>
                    </div>

                    <div class="w-full space-y-3">
                        @if($cleanStatus == 'menunggu pembayaran' && $order->payment_method == 'transfer')
                        <a href="{{ route('cart.payment', $order->id) }}" class="w-full flex items-center justify-center gap-2 bg-black text-[#fde047] px-4 py-4 brutalist-border font-black uppercase text-xs hover:bg-[#991b1b] hover:text-white transition-all shadow-[4px_4px_0_0_#000] active:translate-y-1 active:shadow-none">
                            <i data-lucide="credit-card" class="w-5 h-5"></i> Bayar Sekarang
                        </a>
                        @endif

                        @if(in_array($cleanStatus, ['diproses', 'dikirim', 'selesai', 'menunggu konfirmasi']))
                        <a href="{{ route('user.printInvoice', $order->id) }}" target="_blank" class="w-full flex items-center justify-center gap-2 bg-white text-black px-4 py-4 brutalist-border font-black uppercase text-xs hover:bg-[#38bdf8] transition-all shadow-[4px_4px_0_0_#000] active:translate-y-1 active:shadow-none">
                            <i data-lucide="printer" class="w-5 h-5"></i> Lihat Nota
                        </a>
                        @endif

                        @if($cleanStatus == 'dikirim')
                        <form action="{{ route('user.orders.confirm', $order->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin barang sudah diterima dengan baik?');">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#4ade80] text-black px-4 py-4 brutalist-border font-black uppercase text-xs hover:bg-black hover:text-[#4ade80] transition-all shadow-[4px_4px_0_0_#000] active:translate-y-1 active:shadow-none">
                                <i data-lucide="check-square" class="w-5 h-5"></i> Barang Sudah Sampai
                            </button>
                        </form>
                        @endif

                        @if(in_array($cleanStatus, ['menunggu ongkir', 'menunggu pembayaran', 'menunggu konfirmasi']))
                        <form action="{{ route('user.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin membatalkan pesanan ini? Stok akan dikembalikan ke toko.');">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-white text-[#991b1b] px-4 py-4 brutalist-border font-black uppercase text-xs hover:bg-[#991b1b] hover:text-white transition-all shadow-[4px_4px_0_0_#000] active:translate-y-1 active:shadow-none">
                                <i data-lucide="x-circle" class="w-5 h-5"></i> Batalkan Pesanan
                            </button>
                        </form>
                        @endif

                        @if($cleanStatus == 'selesai' || $cleanStatus == 'batal')
                        <form action="{{ route('user.orders.hide', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membersihkan pesanan ini dari riwayatmu? Transaksi tidak dapat dikembalikan.');">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#ff6b6b] text-black px-4 py-4 brutalist-border font-black uppercase text-xs hover:bg-[#991b1b] hover:text-white transition-all shadow-[4px_4px_0_0_#000] active:translate-y-1 active:shadow-none">
                                <i data-lucide="trash-2" class="w-5 h-5"></i> Hapus Riwayat
                            </button>
                        </form>
                        @endif

                    </div>

                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white brutalist-border p-10 sm:p-20 text-center shadow-[16px_16px_0px_0px_#000] relative overflow-hidden bg-diagonal-lines">
            <div class="relative z-10">
                <div class="bg-black text-white w-20 h-20 sm:w-24 sm:h-24 rounded-full flex items-center justify-center mx-auto mb-8 brutalist-border shadow-[6px_6px_0_0_#991b1b]">
                    <i data-lucide="package-x" class="w-10 h-10 sm:w-12 sm:h-12"></i>
                </div>
                <h2 class="text-3xl sm:text-4xl font-black uppercase mb-4 text-black tracking-tighter">Kosong Melompong!</h2>
                <p class="font-bold text-gray-600 max-w-md mx-auto mb-10 leading-relaxed uppercase text-sm sm:text-base">Anabulmu mulai protes karena belum ada belanjaan baru. Yuk, cari sesuatu yang spesial!</p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 bg-[#fde047] text-black font-black uppercase px-10 py-5 brutalist-border shadow-[6px_6px_0_0_#000] hover:bg-[#4ade80] hover:-translate-y-1 transition-all text-sm sm:text-base">
                    <i data-lucide="shopping-cart" class="w-6 h-6"></i> Jelajahi Toko
                </a>
            </div>
        </div>
        @endif

    </main>

    @include('partials.footer')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();
        });
    </script>
</body>

</html>