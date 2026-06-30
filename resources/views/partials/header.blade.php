<style>
    html {
        scroll-behavior: smooth;
    }
</style>

<script src="https://unpkg.com/lucide@latest"></script>

<header x-data="{ mobileMenuOpen: false, openKategori: false }" class="sticky top-0 z-50 bg-[#f4f4f0] border-b-[4px] sm:border-b-[6px] border-black shadow-[0_4px_0_0_rgba(0,0,0,1)] transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-24">

            <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center group">
                <div class="font-black text-2xl sm:text-3xl tracking-tighter bg-[#ffde59] px-3 py-1 border-[4px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] group-hover:translate-x-1 group-hover:translate-y-1 group-hover:shadow-none transition-all cursor-pointer">
                    MEOW<span class="text-white bg-black px-2 ml-1 border-l-[4px] border-black">CATSHOP</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-6">

                <div class="relative" @click.away="openKategori = false">
                    <button @click="openKategori = !openKategori" class="flex items-center gap-1.5 font-black text-sm tracking-widest text-black uppercase group px-4 py-2 border-[3px] border-transparent hover:border-black hover:bg-[#ffde59] shadow-[0px_0px_0px_0px_rgba(0,0,0,1)] hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-1 transition-all focus:outline-none">
                        Kategori <i data-lucide="chevron-down" class="w-4 h-4 stroke-[3px] transition-transform" :class="openKategori ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="openKategori" x-transition style="display: none;" class="absolute top-full left-0 mt-4 w-60 bg-white border-[4px] border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] p-4 space-y-4 z-50">
                        <div>
                            <p class="text-[10px] font-black uppercase text-gray-500 mb-2 border-b-2 border-black pb-1">Tipe Produk</p>
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('home') }}/?jenis=Makanan+Basah" class="font-bold text-sm text-black hover:bg-[#ffde59] border-2 border-transparent hover:border-black p-2 transition-all">Makanan Basah</a>
                                <a href="{{ route('home') }}/?jenis=Makanan+Kering" class="font-bold text-sm text-black hover:bg-[#ffde59] border-2 border-transparent hover:border-black p-2 transition-all">Makanan Kering</a>
                                <a href="{{ route('home') }}/?jenis=Pasir" class="font-bold text-sm text-black hover:bg-[#ffde59] border-2 border-transparent hover:border-black p-2 transition-all">Pasir Kucing</a>
                            </div>
                        </div>
                        <div class="pt-2">
                            <p class="text-[10px] font-black uppercase text-gray-500 mb-2 border-b-2 border-black pb-1">Usia Kucing</p>
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('home') }}/?usia=Kitten+Food" class="font-bold text-sm text-black hover:bg-[#4ade80] border-2 border-transparent hover:border-black p-2 transition-all">Kitten</a>
                                <a href="{{ route('home') }}/?usia=Adult+Cat+Food" class="font-bold text-sm text-black hover:bg-[#4ade80] border-2 border-transparent hover:border-black p-2 transition-all">Adult</a>
                                <a href="{{ route('home') }}/?usia=Senior+Cat+Food" class="font-bold text-sm text-black hover:bg-[#4ade80] border-2 border-transparent hover:border-black p-2 transition-all">Senior</a>
                                <a href="{{ route('home') }}/?usia=Mother" class="font-bold text-sm text-black hover:bg-[#4ade80] border-2 border-transparent hover:border-black p-2 transition-all">Mother</a>
                                <a href="{{ route('home') }}/?usia=Mother+and+Kitten" class="font-bold text-sm text-black hover:bg-[#4ade80] border-2 border-transparent hover:border-black p-2 transition-all">Mother & Kitten</a>
                                <a href="{{ route('home') }}/?usia=All+Stages" class="font-bold text-sm text-black hover:bg-[#4ade80] border-2 border-transparent hover:border-black p-2 transition-all">All Stages</a>
                            </div>
                        </div>
                    </div>
                </div>

                @auth
                @if(Auth::user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-1.5 font-black text-sm tracking-widest text-black uppercase px-4 py-2 border-[3px] border-transparent hover:border-black hover:bg-[#ffde59] hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-1 transition-all">
                    Admin
                </a>
                @else
                <a href="{{ route('user.orders') }}" class="flex items-center gap-1.5 font-black text-sm tracking-widest text-black uppercase px-4 py-2 border-[3px] border-transparent hover:border-black hover:bg-[#f80c3f] hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-1 transition-all">
                    Pesanan
                </a>
                @endif
                @endauth

                <a href="#kontak" class="flex items-center gap-1.5 font-black text-sm tracking-widest text-black uppercase px-4 py-2 border-[3px] border-transparent hover:border-black hover:bg-[#38bdf8] hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-1 transition-all">
                    Kontak
                </a>

            </nav>

            <div class="flex items-center gap-3">

                @php $cartCount = session('cart') ? count((array) session('cart')) : 0; @endphp
                <a href="{{ route('cart.index') }}" class="relative flex items-center justify-center w-12 h-12 bg-white border-[4px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:bg-[#4ade80] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all group">
                    <i data-lucide="shopping-cart" class="w-6 h-6 stroke-[3px] group-hover:scale-110 transition-transform"></i>
                    @if($cartCount > 0)
                    <span class="absolute -top-3 -right-3 bg-[#ffde59] text-black font-black text-xs w-6 h-6 flex items-center justify-center border-[3px] border-black rounded-full shadow-[2px_2px_0px_0px_#000]">{{ $cartCount }}</span>
                    @endif
                </a>

                <div class="hidden md:flex items-center gap-3">
                    @auth
                    <a href="{{ route('profile.index') }}" class="flex items-center justify-center w-12 h-12 bg-[#c084fc] border-[4px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:bg-[#a855f7] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all group overflow-hidden" title="Profil Saya">
                        @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                        <i data-lucide="user" class="w-6 h-6 stroke-[3px] text-white"></i>
                        @endif
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="flex items-center justify-center h-12 px-6 bg-black text-white font-black text-sm uppercase tracking-widest border-[4px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:bg-[#ff6b6b] hover:text-black hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all">
                            Keluar
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="flex items-center justify-center h-12 px-6 bg-[#91D06C] text-black font-black text-sm uppercase tracking-widest border-[4px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:bg-[#4C8CE4] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center justify-center h-12 px-6 bg-[#c084fc] text-black font-black text-sm uppercase tracking-widest border-[4px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:bg-[#ffde59] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all">
                        Daftar
                    </a>
                    @endauth
                </div>

                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden flex items-center justify-center w-12 h-12 bg-[#ffde59] border-[4px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all focus:outline-none">
                    <i data-lucide="menu" x-show="!mobileMenuOpen" class="w-6 h-6 stroke-[3px]"></i>
                    <i data-lucide="x" x-show="mobileMenuOpen" style="display: none;" class="w-6 h-6 stroke-[3px]"></i>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileMenuOpen"
        style="display: none;"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-5"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="md:hidden absolute top-full left-0 w-full bg-[#f4f4f0] border-b-[6px] border-black shadow-[0_8px_0_0_rgba(0,0,0,1)] z-40 overflow-y-auto max-h-[85vh]">

        <div class="flex flex-col p-6 space-y-6">

            @auth
            <div class="flex flex-col gap-3">
                @if(Auth::user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between h-14 px-5 bg-[#ffde59] border-[4px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-black font-black text-sm uppercase active:translate-y-1 transition-all">
                    Admin Panel <i data-lucide="arrow-right" class="w-5 h-5 stroke-[3px]"></i>
                </a>
                @else
                <a href="{{ route('user.orders') }}" class="flex items-center justify-between h-14 px-5 bg-[#ffde59] border-[4px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-black font-black text-sm uppercase active:translate-y-1 transition-all">
                    Pesanan Saya <i data-lucide="arrow-right" class="w-5 h-5 stroke-[3px]"></i>
                </a>
                @endif

                <a href="{{ route('profile.index') }}" class="flex items-center justify-between h-14 px-5 bg-[#c084fc] border-[4px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-black font-black text-sm uppercase active:translate-y-1 transition-all">
                    Profil Saya
                    @if(Auth::user()->avatar)
                    <div class="w-8 h-8 rounded-full border-2 border-black overflow-hidden bg-white shadow-[1px_1px_0_0_#000]">
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                    </div>
                    @else
                    <i data-lucide="user" class="w-5 h-5 stroke-[3px]"></i>
                    @endif
                </a>

                <a href="#kontak" @click="mobileMenuOpen = false" class="flex items-center justify-between h-14 px-5 bg-[#38bdf8] border-[4px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-black font-black text-sm uppercase active:translate-y-1 transition-all">
                    Hubungi Kami <i data-lucide="phone" class="w-5 h-5 stroke-[3px]"></i>
                </a>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="m-0 mt-2">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center h-14 bg-black text-white border-[4px] border-black font-black text-lg uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] active:translate-y-1 active:shadow-none hover:bg-[#ff6b6b] hover:text-black transition-all">
                    Keluar
                </button>
            </form>
            @else
            <div class="flex flex-col gap-3">
                <a href="{{ route('login') }}" class="flex items-center justify-center h-14 bg-[#91D06C] border-[4px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-black font-black text-lg uppercase active:translate-y-1 active:shadow-none transition-all">
                    Login
                </a>

                <a href="{{ route('register') }}" class="flex items-center justify-center h-14 bg-[#c084fc] border-[4px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-black font-black text-lg uppercase active:translate-y-1 active:shadow-none transition-all">
                    Daftar Akun
                </a>

                <a href="#kontak" @click="mobileMenuOpen = false" class="flex items-center justify-center h-14 bg-[#38bdf8] border-[4px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-black font-black text-lg uppercase active:translate-y-1 active:shadow-none transition-all gap-2">
                    Hubungi Kami <i data-lucide="phone" class="w-5 h-5 stroke-[3px]"></i>
                </a>
            </div>
            @endauth
        </div>
    </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons();
    });
</script>