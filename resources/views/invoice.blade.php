<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Invoice #INV-{{ $order->id }} - Meow Catshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
        }

        /* CSS Khusus Pencetakan */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background-color: white !important;
                padding: 0;
            }

            .print-container {
                box-shadow: none !important;
                border: 2px solid black !important;
                margin: 0 !important;
                max-width: 100% !important;
                border-radius: 0 !important;
            }
        }
    </style>
</head>

<body class="antialiased bg-gray-100 text-gray-800 min-h-screen pb-12">

    <div class="no-print bg-white border-b-4 border-black p-4 sticky top-0 z-50 mb-8">
        <div class="max-w-4xl mx-auto flex items-center justify-between gap-4">
            <a href="{{ route('user.orders') }}" class="text-black bg-gray-100 border-2 border-black px-5 py-2 rounded font-bold hover:bg-yellow-400 transition-all flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
                Kembali
            </a>

            <button onclick="window.print()" class="bg-black text-white px-5 py-2 rounded font-bold hover:bg-indigo-600 transition-all flex items-center gap-2 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] active:shadow-none active:translate-x-1 active:translate-y-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                    <path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6" />
                    <rect x="6" y="14" width="12" height="8" rx="1" />
                </svg>
                Cetak Invoice
            </button>
        </div>
    </div>

    <div class="print-container max-w-4xl mx-auto bg-white p-8 sm:p-12 border-4 border-black shadow-[10px_10px_0px_0px_rgba(0,0,0,1)] relative overflow-hidden">

        @if($order->status == 'selesai' || $order->status == 'dikirim')
        <div class="absolute top-20 right-10 sm:right-20 border-8 border-green-500 text-green-500 font-black text-5xl sm:text-7xl uppercase px-6 py-2 transform rotate-12 opacity-20 pointer-events-none select-none">
            LUNAS
        </div>
        @endif

        <div class="flex flex-col sm:flex-row justify-between items-start border-b-4 border-black pb-8 mb-8">
            <div>
                <h1 class="font-black text-3xl uppercase tracking-tighter text-black">Meow Catshop</h1>
                <p class="text-sm font-bold text-gray-600">Lhokseumawe, Aceh (Banda Sakti)</p>
                <p class="text-sm font-bold text-gray-600">WhatsApp: 0812-3456-7890</p>
            </div>
            <div class="mt-6 sm:mt-0 text-left sm:text-right">
                <h2 class="text-4xl font-black text-black uppercase tracking-tighter mb-2">Invoice</h2>
                <p class="text-sm font-black bg-yellow-400 border-2 border-black px-2 inline-block">#INV-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                <p class="text-sm font-bold text-gray-500 mt-1">Tanggal: {{ $order->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            <div>
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Ditagihkan Kepada:</h3>
                <p class="font-black text-gray-900 text-xl uppercase">{{ $order->customer_name }}</p>
                <p class="text-sm font-bold text-gray-600 mt-1 leading-relaxed">{{ $order->address }}</p>
                <p class="text-sm font-black text-black mt-1">Telp: {{ $order->phone }}</p>
            </div>

            <div class="md:text-right">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Informasi Pesanan:</h3>
                <p class="text-sm font-bold text-gray-600"><span class="text-black uppercase">Metode Kirim:</span> {{ strtoupper($order->shipping_method) }}</p>
                <p class="text-sm font-bold text-gray-600 mt-1"><span class="text-black uppercase">Pembayaran:</span> {{ strtoupper($order->payment_method) }}</p>
                <p class="text-sm font-bold text-gray-600 mt-1"><span class="text-black uppercase">Status:</span> {{ strtoupper($order->status) }}</p>
            </div>
        </div>

        <div class="overflow-x-auto mb-8">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b-4 border-black">
                        <th class="py-3 px-2 text-xs font-black uppercase text-black w-12 text-center">No</th>
                        <th class="py-3 px-2 text-xs font-black uppercase text-black">Deskripsi Amunisi kucingmu</th>
                        <th class="py-3 px-2 text-xs font-black uppercase text-black text-right">Harga</th>
                        <th class="py-3 px-2 text-xs font-black uppercase text-black text-center w-20">Qty</th>
                        <th class="py-3 px-2 text-xs font-black uppercase text-black text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $index => $item)
                    <tr class="border-b-2 border-gray-100">
                        <td class="py-4 px-2 text-sm font-bold text-gray-600 text-center">{{ $index + 1 }}</td>
                        <td class="py-4 px-2 text-sm text-black font-black uppercase">{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                        <td class="py-4 px-2 text-sm font-bold text-gray-600 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="py-4 px-2 text-sm font-black text-black text-center">{{ $item->quantity }}</td>
                        <td class="py-4 px-2 text-sm text-black text-right font-black">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end mb-12">
            <div class="w-full sm:w-1/2 md:w-1/3 space-y-2">
                <div class="flex justify-between text-sm font-bold text-gray-600">
                    <span>SUBTOTAL</span>
                    <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm font-bold text-gray-600 border-b-2 border-black pb-2">
                    <span>ONGKOS KIRIM</span>
                    <span>Rp {{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 text-xl font-black text-black bg-yellow-400 border-2 border-black px-2 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <span>TOTAL</span>
                    <span>Rp {{ number_format($order->total_price + ($order->shipping_cost ?? 0), 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="border-t-4 border-black pt-8 mt-8 text-center sm:text-left">
            <h4 class="font-black text-lg uppercase text-black mb-1 italic">Terima Kasih, Majikan!</h4>
            <p class="text-xs font-bold text-gray-500 leading-relaxed max-w-2xl uppercase">
                Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan kecuali ada perjanjian sebelumnya.
                Pastikan kucingmu senang dengan belanjaan hari ini!
            </p>
        </div>
    </div>
</body>

</html>
