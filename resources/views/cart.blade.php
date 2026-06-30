<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Keranjang Belanja - Meow Catshop</title>

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

        .bg-dots {
            background-image: radial-gradient(#000 20%, transparent 20%);
            background-size: 15px 15px;
        }

        .bg-lines {
            background-image: repeating-linear-gradient(-45deg, transparent, transparent 10px, rgba(0, 0, 0, 0.1) 10px, rgba(0, 0, 0, 0.1) 20px);
        }
    </style>
</head>

<body class="antialiased flex flex-col min-h-screen">

    @include('partials.header')

    <main class="flex-grow">

        @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="p-5 bg-[#4ade80] brutalist-border text-black font-black uppercase shadow-[8px_8px_0px_0px_#000] flex items-center gap-3 animate-pulse">
                <i data-lucide="check-circle" class="w-8 h-8 stroke-[3px]"></i>
                <span class="text-xl">{{ session('success') }}</span>
            </div>
        </div>
        @endif
        @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="p-5 bg-[#991b1b] brutalist-border text-white font-black uppercase shadow-[8px_8px_0px_0px_#000] flex items-center gap-3 animate-pulse">
                <i data-lucide="alert-triangle" class="w-8 h-8 stroke-[3px]"></i>
                <span class="text-xl">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">

            <div class="mb-10 relative">
                <h1 class="text-5xl sm:text-6xl font-black uppercase tracking-tighter bg-[#fde047] text-black px-6 py-3 brutalist-border shadow-[8px_8px_0px_0px_#991b1b] inline-block transform -rotate-1">
                    KERANJANG BRUTAL
                </h1>
                <p class="font-bold text-xl mt-4 text-gray-600 border-l-[6px] border-[#991b1b] pl-4">Cek lagi amunisimu sebelum di-checkout, majikan!</p>
            </div>

            @php $total = 0; @endphp

            @if(session('cart') && count((array) session('cart')) > 0)
            <div class="flex flex-col lg:flex-row gap-10">

                <div class="w-full lg:w-2/3 flex flex-col gap-6">

                    @foreach(session('cart') as $id => $details)
                    @php
                    $subtotal = $details['price'] * $details['quantity'];
                    $total += $subtotal;
                    @endphp

                    <div class="bg-white brutalist-border flex flex-col sm:flex-row shadow-[8px_8px_0px_0px_#000] hover:-translate-y-1 hover:shadow-[12px_12px_0px_0px_#991b1b] transition-all duration-200">

                        <div class="w-full sm:w-48 h-48 border-b-[4px] sm:border-b-0 sm:border-r-[4px] border-black bg-[#fde047] flex items-center justify-center p-4 bg-dots">
                            <img src="{{ asset('storage/' . ($details['image'] ?? 'default.jpg')) }}" alt="{{ $details['name'] }}" class="max-h-full object-contain drop-shadow-[4px_4px_0px_rgba(0,0,0,0.5)]">
                        </div>

                        <div class="p-5 sm:p-6 flex flex-col flex-grow">

                            <div class="flex justify-between items-start gap-4 mb-2">
                                <h3 class="font-black text-2xl uppercase leading-tight text-black">{{ $details['name'] }}</h3>

                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="text-[#991b1b] hover:text-white hover:bg-[#991b1b] p-2 brutalist-border border-[2px] transition-colors" title="Hapus Barang">
                                        <i data-lucide="trash-2" class="w-5 h-5 stroke-[3px]"></i>
                                    </button>
                                </form>
                            </div>

                            <p class="font-900 text-xl text-gray-500 mb-6">Rp {{ number_format($details['price'], 0, ',', '.') }} <span class="text-sm font-bold">/ pcs</span></p>

                            <div class="mt-auto flex flex-wrap items-end justify-between gap-4">

                                <div class="flex items-center brutalist-border shadow-[4px_4px_0_0_#000] bg-white h-10 w-fit">

                                    <form action="{{ route('cart.updateQuantity', $id) }}" method="POST" class="m-0 h-full">
                                        @csrf
                                        <input type="hidden" name="quantity" value="{{ $details['quantity'] - 1 }}">
                                        <button type="submit" {{ $details['quantity'] <= 1 ? 'disabled' : '' }}
                                            class="h-full px-3 font-black bg-[#22d3ee] text-black hover:bg-[#fde047] border-r-[4px] border-black disabled:opacity-50 disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors flex items-center justify-center">
                                            <i data-lucide="minus" class="w-4 h-4 stroke-[4px]"></i>
                                        </button>
                                    </form>

                                    <div class="h-full px-5 flex items-center justify-center font-black text-lg bg-white select-none min-w-[3rem]">
                                        {{ $details['quantity'] }}
                                    </div>

                                    <form action="{{ route('cart.updateQuantity', $id) }}" method="POST" class="m-0 h-full">
                                        @csrf
                                        <input type="hidden" name="quantity" value="{{ $details['quantity'] + 1 }}">
                                        <button type="submit"
                                            class="h-full px-3 font-black bg-[#22d3ee] text-black hover:bg-[#4ade80] border-l-[4px] border-black transition-colors flex items-center justify-center">
                                            <i data-lucide="plus" class="w-4 h-4 stroke-[4px]"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="text-right mt-4 sm:mt-0">
                                    <p class="text-xs font-black uppercase text-gray-500 mb-1">Subtotal</p>
                                    <p class="font-900 text-2xl text-black bg-[#4ade80] px-2 brutalist-border border-[2px] shadow-[2px_2px_0_0_#000]">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="w-full lg:w-1/3">
                    <div class="bg-black text-white brutalist-border p-6 sm:p-8 shadow-[12px_12px_0px_0px_#991b1b] sticky top-32">
                        <h2 class="font-black text-3xl uppercase mb-6 border-b-[4px] border-[#fde047] pb-4 flex items-center gap-3">
                            <i data-lucide="receipt" class="w-8 h-8 text-[#fde047]"></i> Tagihan
                        </h2>

                        <div class="space-y-4 font-bold text-lg mb-8">
                            <div class="flex justify-between items-center text-gray-300">
                                <span>Total Item</span>
                                <span class="text-white">{{ count((array) session('cart')) }} Macam</span>
                            </div>
                            <div class="flex justify-between items-center text-gray-300">
                                <span>Ongkos Kirim</span>
                                <span class="text-[#fde047] text-sm">Dihitung saat Checkout</span>
                            </div>
                        </div>

                        <div class="border-t-[4px] border-white/20 pt-6 mb-8">
                            <p class="font-black text-sm uppercase text-gray-400 mb-1">Total Sementara</p>
                            <p class="font-900 text-4xl sm:text-5xl text-[#4ade80] break-words">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </p>
                        </div>

                        <a href="{{ route('cart.checkout_form') }}" class="w-full flex items-center justify-center gap-3 bg-[#fde047] text-black font-black uppercase px-8 py-5 brutalist-border border-white shadow-[6px_6px_0px_0px_white] hover:bg-[#4ade80] hover:translate-y-1 hover:shadow-[2px_2px_0px_0px_white] active:translate-y-2 active:shadow-none transition-all text-xl mt-4">
                            CHECKOUT SEKARANG <i data-lucide="arrow-right" class="w-6 h-6 stroke-[3px]"></i>
                        </a>

                        <a href="{{ route('home') }}#katalog" class="block text-center mt-6 font-bold uppercase text-sm text-gray-400 hover:text-white underline decoration-2 underline-offset-4 transition-colors">
                            Lanjut Belanja Dulu
                        </a>
                    </div>
                </div>
            </div>

            @else
            <div class="bg-white brutalist-border p-12 sm:p-20 text-center shadow-[16px_16px_0px_0px_#000] relative overflow-hidden mt-6">
                <div class="absolute inset-0 bg-lines opacity-10 pointer-events-none"></div>

                <div class="relative z-10">
                    <div class="w-32 h-32 bg-[#ffde59] brutalist-border shadow-[6px_6px_0px_0px_#000] rounded-full mx-auto flex items-center justify-center mb-8 transform -rotate-12">
                        <i data-lucide="shopping-cart" class="w-16 h-16 stroke-[2px] text-black"></i>
                    </div>
                    <h2 class="text-4xl sm:text-5xl font-black uppercase tracking-tight mb-4 drop-shadow-[2px_2px_0px_#991b1b]">Keranjangmu Masih Kosong!</h2>
                    <p class="font-bold text-xl text-gray-600 max-w-2xl mx-auto mb-10">Kucingmu sudah menatap tajam karena mangkuk makannya kosong. Ayo segera isi dengan produk-produk brutal kami!</p>

                    <a href="{{ route('home') }}#katalog" class="inline-flex items-center gap-3 bg-[#4ade80] text-black font-black uppercase px-10 py-5 brutalist-border text-xl shadow-[8px_8px_0px_0px_#000] hover:bg-[#fde047] active:translate-y-1 active:shadow-none transition-all">
                        <i data-lucide="rocket" class="w-6 h-6 stroke-[3px]"></i> BERBURU BARANG SEKARANG
                    </a>
                </div>
            </div>
            @endif

        </section>
    </main>

    @include('partials.footer')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();
        });
    </script>
</body>

</html>
