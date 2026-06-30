<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Checkout - Meow Catshop</title>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
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

        .bg-dots {
            background-image: radial-gradient(#000 20%, transparent 20%);
            background-size: 15px 15px;
        }
    </style>
</head>

<body class="antialiased flex flex-col min-h-screen">

    @include('partials.header')

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">

        <div class="mb-10 relative">
            <h1 class="text-4xl sm:text-5xl font-black uppercase tracking-tighter bg-[#ffde59] text-black px-6 py-3 inline-block brutalist-border shadow-[6px_6px_0px_0px_#000] transform -rotate-1">
                FORM CHECKOUT
            </h1>
            <p class="font-bold text-lg mt-4 text-gray-600 border-l-[6px] border-black pl-4">Pastikan alamat kirimmu sudah benar agar kurir tidak tersesat!</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-10">

            <div class="w-full lg:w-2/3 bg-white brutalist-border p-6 sm:p-8 shadow-[8px_8px_0px_0px_#000]">

                <div class="mb-6 p-4 bg-[#38bdf8] brutalist-border text-black font-bold uppercase text-xs shadow-[4px_4px_0_0_#000] flex items-center gap-2">
                    <i data-lucide="info" class="w-5 h-5 stroke-[3px]"></i>
                    Data di bawah ini otomatis terisi dari pengaturan profil brutalmu!
                </div>

                @if(session('error'))
                <div class="mb-6 p-4 bg-[#991b1b] brutalist-border text-white font-black uppercase shadow-[4px_4px_0_0_#000] flex items-center gap-3 text-sm">
                    <i data-lucide="alert-triangle" class="w-5 h-5 stroke-[3px] shrink-0"></i>
                    {{ session('error') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="mb-6 p-4 bg-[#991b1b] brutalist-border text-white font-black uppercase shadow-[4px_4px_0_0_#000] flex items-start gap-3 text-sm">
                    <i data-lucide="alert-circle" class="w-5 h-5 stroke-[3px] shrink-0 mt-0.5"></i>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="{{ route('cart.store_order') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block font-black text-sm uppercase mb-2">Nama Penerima</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" required
                            class="w-full px-4 py-3 bg-[#f4f4f0] brutalist-border focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#ffde59] transition-all font-bold">
                    </div>

                    <div>
                        <label class="block font-black text-sm uppercase mb-2">Nomor WA / HP Aktif</label>
                        <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required
                            placeholder="Contoh: 08123456789"
                            class="w-full px-4 py-3 bg-[#f4f4f0] brutalist-border focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#ffde59] transition-all font-bold">
                    </div>

                    <div>
                        <label class="block font-black text-sm uppercase mb-2">Alamat Lengkap Pengiriman</label>
                        <textarea name="address" rows="4" required
                            placeholder="Tulis nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, dan kota/kabupaten..."
                            class="w-full px-4 py-3 bg-[#f4f4f0] brutalist-border focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#ffde59] transition-all font-bold leading-relaxed">{{ old('address', auth()->user()->address) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ shipping: '{{ old('shipping_method') }}', payment: '{{ old('payment_method') }}' }">

                        <div>
                            <label class="block font-black text-sm uppercase mb-2 text-[#38bdf8]">Opsi Pengiriman</label>
                            <select name="shipping_method" x-model="shipping"
                                @change="if(shipping === 'delivery' && payment === 'cash') payment = ''"
                                required class="w-full px-4 py-3 bg-[#f4f4f0] brutalist-border focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#38bdf8] transition-all font-bold uppercase cursor-pointer">
                                <option value="">-- Pilih Cara Kirim --</option>
                                <option value="delivery">Dikirim Kurir (Delivery)</option>
                                <option value="pickup">Ambil di Toko (Pickup)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-black text-sm uppercase mb-2 text-[#c084fc]">Opsi Pembayaran</label>
                            <select name="payment_method" x-model="payment" required class="w-full px-4 py-3 bg-[#f4f4f0] brutalist-border focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#c084fc] transition-all font-bold uppercase cursor-pointer">
                                <option value="">-- Pilih Pembayaran --</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="cash" x-show="shipping !== 'delivery'" x-bind:disabled="shipping === 'delivery'">Bayar Tunai di Kasir</option>
                            </select>

                            <p x-cloak x-show="shipping === 'delivery'" class="text-[10px] text-[#991b1b] font-black mt-2 uppercase">
                                * Bayar tunai tidak berlaku untuk opsi pengiriman kurir.
                            </p>
                        </div>

                    </div>
                    <div>
                        <label class="block font-black text-sm uppercase mb-2 text-gray-500">Catatan Tambahan (Opsional)</label>
                        <input type="text" name="note" placeholder="Contoh: Titip ke satpam jika rumah kosong"
                            class="w-full px-4 py-3 bg-[#f4f4f0] brutalist-border border-dashed focus:border-solid focus:bg-white focus:outline-none focus:ring-4 focus:ring-black transition-all font-bold">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full flex items-center justify-center gap-3 bg-[#4ade80] text-black font-black uppercase px-8 py-5 brutalist-border shadow-[6px_6px_0px_0px_#000] hover:bg-[#ffde59] hover:translate-y-1 hover:shadow-[2px_2px_0px_0px_#000] active:translate-y-2 active:shadow-none transition-all text-xl">
                            BUAT PESANAN SEKARANG <i data-lucide="check-square" class="w-6 h-6 stroke-[3px]"></i>
                        </button>
                    </div>

                </form>
            </div>

            <div class="w-full lg:w-1/3">
                <div class="bg-black text-white brutalist-border p-6 shadow-[8px_8px_0px_0px_#991b1b] sticky top-32">
                    <h2 class="font-black text-2xl uppercase mb-6 border-b-[4px] border-[#ffde59] pb-4 flex items-center gap-2">
                        <i data-lucide="shopping-bag" class="w-6 h-6 text-[#ffde59]"></i> Ringkasan Belanja
                    </h2>

                    <div class="space-y-4 max-h-60 overflow-y-auto pr-2 border-b-[4px] border-white/10 pb-6 mb-6">
                        @php $total = 0; @endphp
                        @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                        @php $total += $details['price'] * $details['quantity']; @endphp
                        <div class="flex gap-3 items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-white border-2 border-white p-1 flex items-center justify-center shrink-0">
                                    <img src="{{ asset('storage/' . ($details['image'] ?? 'default.jpg')) }}" alt="Produk" class="max-h-full object-contain">
                                </div>
                                <div>
                                    <p class="font-black text-sm uppercase line-clamp-1 text-white">{{ $details['name'] }}</p>
                                    <p class="text-xs text-gray-400 font-bold">{{ $details['quantity'] }} x Rp {{ number_format($details['price'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <span class="font-bold text-sm bg-gray-800 px-2 py-0.5 border border-gray-700">
                                Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                            </span>
                        </div>
                        @endforeach
                        @endif
                    </div>

                    <div class="space-y-3 font-bold text-sm mb-6 text-gray-300">
                        <div class="flex justify-between">
                            <span>Subtotal Produk</span>
                            <span class="text-white">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Ongkos Kirim</span>
                            <span class="text-[#ffde59] text-xs font-black uppercase bg-gray-800 px-2 py-1 border border-gray-700">Menunggu Admin</span>
                        </div>
                    </div>

                    <div class="border-t-[4px] border-white/20 pt-4 text-left">
                        <p class="font-black text-xs uppercase text-gray-400 mb-1">Total Sementara</p>
                        <p class="font-900 text-3xl text-[#4ade80]">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </p>
                    </div>

                </div>
            </div>

        </div>

    </main>

    @include('partials.footer')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();
        });
    </script>
</body>

</html>