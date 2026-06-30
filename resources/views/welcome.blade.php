<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MeowCatshop Lhokseumawe</title>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: #fde047;
            color: #000;
            overflow-x: hidden;
        }

        /* Custom Brutalist Utilities */
        .brutalist-border {
            border: 4px solid #000;
        }

        .brutalist-shadow-red {
            box-shadow: 6px 6px 0px 0px #991b1b;
        }

        @media (min-width: 640px) {
            .brutalist-shadow-red {
                box-shadow: 8px 8px 0px 0px #991b1b;
            }
        }

        /* Pattern Backgrounds */
        .bg-dots {
            background-image: radial-gradient(#000 20%, transparent 20%);
            background-size: 15px 15px;
        }

        .bg-lines {
            background-image: repeating-linear-gradient(-45deg, transparent, transparent 10px, rgba(0, 0, 0, 0.1) 10px, rgba(0, 0, 0, 0.1) 20px);
        }

        /* Text Stroke Effect */
        .text-stroke-white {
            -webkit-text-stroke: 1.5px white;
            color: transparent;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="antialiased flex flex-col min-h-screen">

    @include('partials.header')

    <main class="flex-grow relative">

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
        <section class="border-b-[8px] border-black bg-[#991b1b] relative overflow-hidden">
            <div class="absolute inset-0 bg-lines opacity-20"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 lg:py-32 relative z-10 grid grid-cols-1 md:grid-cols-12 gap-10 lg:gap-12 items-center">
                <div class="md:col-span-8 relative">
                    <div class="absolute -top-10 -left-10 w-24 h-24 sm:w-40 sm:h-40 bg-[#fde047] brutalist-border opacity-50 rotate-12"></div>

                    <div class="inline-block bg-black text-[#fde047] font-black uppercase tracking-widest px-4 sm:px-5 py-2 brutalist-border shadow-[4px_4px_0px_0px_white] sm:shadow-[6px_6px_0px_0px_white] mb-6 sm:mb-8 transform -rotate-2 text-xs sm:text-sm md:text-base">
                        ⚡ MEOW CATSHOP ⚡
                    </div>

                    <h1 class="text-5xl sm:text-7xl lg:text-8xl font-900 uppercase tracking-tighter leading-[0.95] mb-6 sm:mb-8 relative">
                        <span class="block text-white drop-shadow-[3px_3px_0px_#000] sm:drop-shadow-[4px_4px_0px_#000]">MARKASNYA</span>
                        <span class="block text-[#fde047] drop-shadow-[3px_3px_0px_#000] sm:drop-shadow-[4px_4px_0px_#000]">MAJIKAN</span>
                        <span class="block text-stroke-white opacity-90">KECILKU.</span>
                    </h1>

                    <p class="text-lg sm:text-xl lg:text-2xl font-bold border-l-[6px] sm:border-l-[8px] border-[#fde047] pl-4 sm:pl-6 mb-8 sm:mb-12 max-w-2xl text-white opacity-90 py-1 sm:py-2">
                        Penyedia perlengkapan kucing paling keras, paling lengkap, dan paling jujur se-Indonesia raya. Belanja brutal sekarang!
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 sm:gap-6">
                        <a href="#katalog" class="group flex items-center justify-center gap-3 bg-[#fde047] text-black px-6 sm:px-10 py-4 sm:py-5 brutalist-border font-black text-xl sm:text-2xl uppercase shadow-[6px_6px_0px_0px_#000] sm:shadow-[8px_8px_0px_0px_#000] hover:bg-white hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all duration-150">
                            GAS BELANJA <i data-lucide="shopping-cart" class="w-6 h-6 sm:w-7 sm:h-7 stroke-[4px] group-hover:rotate-12"></i>
                        </a>
                    </div>
                </div>

                <div class="md:col-span-4 relative flex justify-center items-center mt-8 md:mt-0">
                    <div class="w-64 h-64 sm:w-80 sm:h-80 brutalist-border bg-dots bg-white p-4 sm:p-6 shadow-[10px_10px_0px_0px_#fde047] sm:shadow-[15px_15px_0px_0px_#fde047] transform rotate-3 relative group">
                        <div class="absolute -top-4 -right-4 sm:-top-5 sm:-right-5 w-12 h-12 sm:w-16 sm:h-16 bg-[#22d3ee] brutalist-border transform rotate-45 z-0"></div>
                        <div class="w-full h-full bg-[#991b1b] brutalist-border flex items-center justify-center relative z-10 overflow-hidden group-hover:bg-black transition-colors">
                            <i data-lucide="cat" class="w-32 h-32 sm:w-40 sm:h-40 stroke-[1px] text-[#fde047] drop-shadow-[6px_6px_0px_#000] transform group-hover:scale-110 group-hover:-rotate-12 transition-transform duration-300"></i>
                            <div class="absolute bottom-2 right-2 text-white font-black uppercase text-[10px] sm:text-xs bg-black px-2 py-1">#BRUTALCAT</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="kategori" class="py-12 sm:py-16 bg-white border-b-[6px] sm:border-b-[8px] border-black bg-lines opacity-90">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex flex-col md:flex-row items-center justify-between mb-8">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black uppercase tracking-tighter bg-white text-black px-4 sm:px-6 py-2 sm:py-3 brutalist-border shadow-[4px_4px_0px_0px_#991b1b] sm:shadow-[6px_6px_0px_0px_#991b1b] transform -rotate-1 text-center w-full md:w-auto">
                        PILIH SENJATAMU
                    </h2>

                    <div class="mt-6 md:mt-0 w-full md:w-auto">
                        <form action="{{ route('home') }}" method="GET" class="flex w-full brutalist-border shadow-[4px_4px_0px_0px_#000]">
                            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari amunisi..." class="px-4 py-3 bg-white font-bold text-black focus:outline-none focus:bg-[#22d3ee] transition-colors placeholder:text-gray-400 w-full md:w-64 text-sm sm:text-base">
                            <button type="submit" class="bg-black text-[#fde047] border-l-[4px] border-black px-5 py-3 hover:bg-[#991b1b] hover:text-white transition-colors">
                                <i data-lucide="search" class="w-5 h-5 sm:w-6 sm:h-6 stroke-[3px]"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="bg-white brutalist-border shadow-[6px_6px_0px_0px_#991b1b] sm:shadow-[10px_10px_0px_0px_#991b1b] p-5 sm:p-8 flex flex-col lg:flex-row gap-8 lg:gap-12 relative overflow-hidden">
                    @if(request('jenis') || request('usia') || request('cari'))
                    <a href="{{ route('home') }}#katalog" class="absolute top-2 right-2 sm:top-4 sm:right-4 bg-black text-white font-black text-[10px] sm:text-xs uppercase px-2 py-1.5 sm:px-3 sm:py-2 brutalist-border hover:bg-[#991b1b] transition-colors z-10 flex items-center gap-1.5 shadow-[2px_2px_0_0_#fde047] sm:shadow-[4px_4px_0_0_#fde047]">
                        <i data-lucide="x-circle" class="w-3 h-3 sm:w-4 sm:h-4"></i> Reset
                    </a>
                    @endif

                    <div class="flex-1">
                        <h3 class="font-black uppercase text-lg sm:text-xl mb-3 sm:mb-4 bg-black text-[#fde047] inline-block px-3 sm:px-4 py-1.5 brutalist-border shadow-[3px_3px_0_0_#991b1b] sm:shadow-[4px_4px_0_0_#991b1b] transform -rotate-1">Tipe Produk</h3>
                        <div class="flex flex-wrap gap-2 sm:gap-3 mt-2">
                            <a href="/?jenis=Makanan+Basah" class="text-sm sm:text-base brutalist-border px-3 py-1.5 sm:px-4 sm:py-2 font-bold hover:bg-black hover:text-white hover:-translate-y-1 hover:shadow-[3px_3px_0_0_#000] sm:hover:shadow-[4px_4px_0_0_#000] transition-all {{ request('jenis') == 'Makanan Basah' ? 'bg-black text-white shadow-[3px_3px_0_0_#991b1b] sm:shadow-[4px_4px_0_0_#991b1b]' : 'bg-[#fde047] text-black' }}">Makanan Basah</a>
                            <a href="/?jenis=Makanan+Kering" class="text-sm sm:text-base brutalist-border px-3 py-1.5 sm:px-4 sm:py-2 font-bold hover:bg-black hover:text-white hover:-translate-y-1 hover:shadow-[3px_3px_0_0_#000] sm:hover:shadow-[4px_4px_0_0_#000] transition-all {{ request('jenis') == 'Makanan Kering' ? 'bg-black text-white shadow-[3px_3px_0_0_#991b1b] sm:shadow-[4px_4px_0_0_#991b1b]' : 'bg-[#fde047] text-black' }}">Makanan Kering</a>
                            <a href="/?jenis=Pasir" class="text-sm sm:text-base brutalist-border px-3 py-1.5 sm:px-4 sm:py-2 font-bold hover:bg-black hover:text-white hover:-translate-y-1 hover:shadow-[3px_3px_0_0_#000] sm:hover:shadow-[4px_4px_0_0_#000] transition-all {{ request('jenis') == 'Pasir' ? 'bg-black text-white shadow-[3px_3px_0_0_#991b1b] sm:shadow-[4px_4px_0_0_#991b1b]' : 'bg-[#fde047] text-black' }}">Pasir Kucing</a>
                        </div>
                    </div>

                    <div class="hidden lg:block w-[4px] sm:w-1.5 bg-black"></div>
                    <div class="block lg:hidden h-[4px] sm:h-1.5 w-full bg-black my-2"></div>

                    <div class="flex-1">
                        <h3 class="font-black uppercase text-lg sm:text-xl mb-3 sm:mb-4 bg-[#991b1b] text-white inline-block px-3 sm:px-4 py-1.5 brutalist-border shadow-[3px_3px_0_0_#000] sm:shadow-[4px_4px_0_0_#000] transform rotate-1">Usia Kucing</h3>
                        <div class="flex flex-wrap gap-2 sm:gap-3 mt-2">
                            <a href="/?usia=Kitten+Food" class="text-sm sm:text-base brutalist-border px-3 py-1.5 sm:px-4 sm:py-2 font-bold hover:bg-black hover:text-white hover:-translate-y-1 hover:shadow-[3px_3px_0_0_#000] sm:hover:shadow-[4px_4px_0_0_#000] transition-all {{ request('usia') == 'Kitten Food' ? 'bg-black text-white shadow-[3px_3px_0_0_#991b1b] sm:shadow-[4px_4px_0_0_#991b1b]' : 'bg-white text-black' }}">Kitten</a>
                            <a href="/?usia=Adult+Cat+Food" class="text-sm sm:text-base brutalist-border px-3 py-1.5 sm:px-4 sm:py-2 font-bold hover:bg-black hover:text-white hover:-translate-y-1 hover:shadow-[3px_3px_0_0_#000] sm:hover:shadow-[4px_4px_0_0_#000] transition-all {{ request('usia') == 'Adult Cat Food' ? 'bg-black text-white shadow-[3px_3px_0_0_#991b1b] sm:shadow-[4px_4px_0_0_#991b1b]' : 'bg-white text-black' }}">Adult</a>
                            <a href="/?usia=Senior+Cat+Food" class="text-sm sm:text-base brutalist-border px-3 py-1.5 sm:px-4 sm:py-2 font-bold hover:bg-black hover:text-white hover:-translate-y-1 hover:shadow-[3px_3px_0_0_#000] sm:hover:shadow-[4px_4px_0_0_#000] transition-all {{ request('usia') == 'Senior Cat Food' ? 'bg-black text-white shadow-[3px_3px_0_0_#991b1b] sm:shadow-[4px_4px_0_0_#991b1b]' : 'bg-white text-black' }}">Senior</a>
                            <a href="/?usia=Mother" class="text-sm sm:text-base brutalist-border px-3 py-1.5 sm:px-4 sm:py-2 font-bold hover:bg-black hover:text-white hover:-translate-y-1 hover:shadow-[3px_3px_0_0_#000] sm:hover:shadow-[4px_4px_0_0_#000] transition-all {{ request('usia') == 'Mother' ? 'bg-black text-white shadow-[3px_3px_0_0_#991b1b] sm:shadow-[4px_4px_0_0_#991b1b]' : 'bg-white text-black' }}">Mother</a>
                            <a href="/?usia=Mother+and+Kitten" class="text-sm sm:text-base brutalist-border px-3 py-1.5 sm:px-4 sm:py-2 font-bold hover:bg-black hover:text-white hover:-translate-y-1 hover:shadow-[3px_3px_0_0_#000] sm:hover:shadow-[4px_4px_0_0_#000] transition-all {{ request('usia') == 'Mother and Kitten' ? 'bg-black text-white shadow-[3px_3px_0_0_#991b1b] sm:shadow-[4px_4px_0_0_#991b1b]' : 'bg-white text-black' }}">Mother & Kitten</a>
                            <a href="/?usia=All+Stages" class="text-sm sm:text-base brutalist-border px-3 py-1.5 sm:px-4 sm:py-2 font-bold hover:bg-black hover:text-white hover:-translate-y-1 hover:shadow-[3px_3px_0_0_#000] sm:hover:shadow-[4px_4px_0_0_#000] transition-all {{ request('usia') == 'All Stages' ? 'bg-black text-white shadow-[3px_3px_0_0_#991b1b] sm:shadow-[4px_4px_0_0_#991b1b]' : 'bg-white text-black' }}">All Stages</a>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section id="katalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-24">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8 lg:gap-10">

                @forelse($products as $product)
                <div x-data="{ showDesc: false }" class="bg-white brutalist-border flex flex-col group brutalist-shadow-red hover:-translate-y-1 hover:shadow-[8px_8px_0px_0px_#000] sm:hover:-translate-y-2 sm:hover:shadow-[12px_12px_0px_0px_#000] transition-all duration-300 relative overflow-hidden">

                    <div class="absolute inset-0 bg-dots opacity-5 z-0 pointer-events-none"></div>

                    <div class="h-48 sm:h-60 border-b-4 border-black bg-white relative p-4 sm:p-5 flex items-center justify-center overflow-hidden z-10">
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="max-h-full object-contain group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 drop-shadow-[5px_5px_0px_rgba(153,27,27,0.3)]" />

                        @if($product->stock < 1)
                            <div class="absolute inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-20 brutalist-border border-none">
                            <span class="bg-[#991b1b] text-white font-900 text-2xl sm:text-3xl uppercase px-4 py-1.5 sm:px-6 sm:py-2 brutalist-border transform -rotate-12 shadow-[4px_4px_0px_0px_white] sm:shadow-[6px_6px_0px_0px_white] tracking-tight">HABIS!</span>
                    </div>
                    @endif
                </div>

                <div class="p-4 sm:p-5 flex flex-col flex-grow relative z-10 bg-white">

                    <div class="flex flex-wrap gap-1.5 sm:gap-2 mb-3 sm:mb-4">
                        <span class="bg-[#22d3ee] text-black font-black text-[9px] sm:text-[10px] px-2 sm:px-3 py-1 brutalist-border border-[2px] uppercase tracking-wider shadow-[2px_2px_0_0_#000]">
                            {{ $product->jenis_barang }}
                        </span>
                        <span class="bg-[#4ade80] text-black font-black text-[9px] sm:text-[10px] px-2 sm:px-3 py-1 brutalist-border border-[2px] uppercase tracking-wider shadow-[2px_2px_0_0_#000]">
                            {{ $product->usia_kucing }}
                        </span>
                    </div>

                    <h3 class="font-black text-xl sm:text-2xl uppercase leading-tight mb-2 text-black line-clamp-2" title="{{ $product->name }}">
                        {{ $product->name }}
                    </h3>

                    <div class="mb-3 sm:mb-4">
                        <p class="text-xs sm:text-sm font-bold text-gray-600 leading-snug transition-all duration-200 whitespace-pre-line"
                            :class="showDesc ? '' : 'line-clamp-2'">
                            {{ $product->description ?? 'Deskripsi produk belum tersedia.' }}
                        </p>

                        <button type="button" @click.prevent="showDesc = !showDesc" class="text-[10px] sm:text-xs font-black uppercase text-[#991b1b] hover:text-black mt-2 flex items-center gap-1.5 transition-colors group/btn">
                            <i data-lucide="book-open" x-show="!showDesc" class="w-3.5 h-3.5 sm:w-4 sm:h-4 group-hover/btn:scale-110 transition-transform"></i>
                            <i data-lucide="minimize-2" x-show="showDesc" style="display:none;" class="w-3.5 h-3.5 sm:w-4 sm:h-4 group-hover/btn:scale-110 transition-transform"></i>
                            <span x-text="showDesc ? 'Tutup Deskripsi' : 'Baca Selengkapnya'"></span>
                        </button>
                    </div>

                    <div class="mt-auto pt-3 sm:pt-4 flex flex-col gap-2 sm:gap-3 border-t-2 border-gray-100 mb-4 sm:mb-5">
                        <div class="flex items-end justify-between">
                            <div>
                                <p class="text-[10px] sm:text-xs font-bold text-gray-500 mb-0.5 sm:mb-1 uppercase">Harga Spesial</p>
                                <p class="font-900 text-xl sm:text-2xl lg:text-3xl text-black bg-[#fde047] px-2 w-fit brutalist-border border-[2px] shadow-[2px_2px_0_0_#000]">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[9px] sm:text-[11px] font-black uppercase text-white bg-[#991b1b] px-1.5 py-0.5 sm:px-2 sm:py-1 brutalist-border border-[2px] shadow-[2px_2px_0_0_#000]">
                                    STOK: {{ $product->stock }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit"
                            @if($product->stock < 1) disabled @endif
                                class="w-full flex items-center justify-center gap-2 sm:gap-3 bg-black text-white font-black text-sm sm:text-base uppercase py-3 sm:py-4 brutalist-border shadow-[4px_4px_0px_0px_#991b1b] hover:bg-[#991b1b] hover:shadow-[4px_4px_0px_0px_#000] active:translate-y-1 active:shadow-none transition-all duration-150 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-black disabled:hover:shadow-[4px_4px_0px_0px_#991b1b]">
                                <i data-lucide="shopping-cart" class="w-4 h-4 sm:w-5 sm:h-5 stroke-[3px]"></i> SIKAT BARANGNYA
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-[#991b1b] brutalist-border p-8 sm:p-16 text-center shadow-[8px_8px_0px_0px_#000] sm:shadow-[12px_12px_0px_0px_#000] relative overflow-hidden mt-6 sm:mt-10">
                <div class="absolute inset-0 bg-lines opacity-10"></div>
                <div class="relative z-10 text-white">
                    <i data-lucide="frown" class="w-20 h-20 sm:w-28 sm:h-28 mx-auto mb-6 sm:mb-8 stroke-[1.5px] text-[#fde047] animate-pulse drop-shadow-[3px_3px_0px_#000] sm:drop-shadow-[5px_5px_0px_#000]"></i>
                    <h3 class="text-3xl sm:text-4xl lg:text-5xl font-black uppercase mb-4 sm:mb-6 text-white drop-shadow-[3px_3px_0px_#000] sm:drop-shadow-[4px_4px_0px_#000]">WADUH, STOK AMBLAS!</h3>
                    <p class="font-bold text-base sm:text-lg lg:text-xl text-[#fde047] max-w-3xl mx-auto leading-tight bg-black/30 p-3 sm:p-4 brutalist-border border-white/50 shadow-[3px_3px_0_0_white] sm:shadow-[5px_5px_0_0_white]">Sepertinya barang yang kamu cari lagi hilang atau diborong majikan lain. Coba reset pencarian!</p>
                    <a href="{{ route('home') }}" class="inline-block mt-8 sm:mt-12 bg-[#fde047] text-black font-black uppercase px-6 sm:px-10 py-3 sm:py-5 brutalist-border text-lg sm:text-xl shadow-[6px_6px_0px_0px_#000] sm:shadow-[8px_8px_0px_0px_#000] hover:bg-white active:translate-y-1 active:shadow-none transition-all">TAMPILKAN SEMUA BARANG</a>
                </div>
            </div>
            @endforelse

            </div>
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