<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Pembayaran Pesanan - Meow Catshop</title>

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

        @if(session('error'))
        <div class="max-w-5xl mx-auto px-4 mt-6">
            <div class="p-5 bg-[#991b1b] brutalist-border text-white font-black uppercase shadow-[8px_8px_0px_0px_#000] flex items-center gap-3 animate-pulse">
                <i data-lucide="alert-triangle" class="w-8 h-8 stroke-[3px]"></i>
                <span class="text-xl">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <section class="max-w-5xl mx-auto px-4 sm:px-6 py-12 sm:py-16">

            <div class="text-center mb-12">
                <div class="inline-block bg-[#22d3ee] brutalist-border p-4 shadow-[8px_8px_0px_0px_#000] transform -rotate-2 mb-6">
                    <i data-lucide="wallet" class="w-16 h-16 stroke-[2px] text-black"></i>
                </div>
                <h1 class="text-4xl sm:text-6xl font-black uppercase tracking-tighter text-black drop-shadow-[2px_2px_0px_#991b1b] mb-4">
                    SELESAIKAN PEMBAYARAN
                </h1>
                <p class="font-bold text-xl text-gray-600">ID Pesanan: <span class="bg-[#fde047] text-black px-2 brutalist-border border-[2px]">#INV-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                <div class="flex flex-col gap-8">

                    <div class="bg-black text-white brutalist-border shadow-[10px_10px_0px_0px_#991b1b] p-8">
                        <p class="font-black text-sm uppercase text-gray-400 mb-2 border-b-[3px] border-white/20 pb-2">Total yang harus ditransfer:</p>
                        <h2 class="font-900 text-5xl sm:text-6xl text-[#4ade80] break-words my-4">
                            Rp {{ number_format($order->total_price ?? $order->total, 0, ',', '.') }}
                        </h2>
                        <p class="text-sm font-bold text-gray-300">Mohon transfer tepat sampai 3 digit terakhir agar mudah dicek admin.</p>
                    </div>

                    <div class="bg-white brutalist-border shadow-[10px_10px_0px_0px_#000] p-8 relative overflow-hidden">
                        <div class="absolute inset-0 bg-lines opacity-5 pointer-events-none"></div>
                        <h3 class="font-black text-2xl uppercase mb-6 flex items-center gap-2 relative z-10">
                            <i data-lucide="building" class="w-6 h-6 text-[#22d3ee]"></i> Rekening Tujuan
                        </h3>

                        <div class="flex flex-col gap-5 relative z-10">
                            <div onclick="salinNomor('1234567890', 'status-bca')" class="p-4 border-[3px] border-black bg-[#f4f4f0] hover:bg-[#fde047] transition-colors group cursor-pointer">
                                <p class="font-black text-lg uppercase text-[#991b1b] mb-1">BCA SYARIAH</p>
                                <div class="flex items-center justify-between">
                                    <p class="font-900 text-2xl tracking-wider">0720101310</p>
                                    <div class="flex items-center gap-2">
                                        <span id="status-bca" style="display: none;" class="text-[10px] text-black font-black bg-white border-[2px] border-black px-2 py-0.5 animate-pulse">TERSALIN!</span>
                                        <i data-lucide="copy" class="w-5 h-5 text-gray-400 group-hover:text-black"></i>
                                    </div>
                                </div>
                                <p class="font-bold text-sm text-gray-600 mt-1 uppercase">a.n. KHASRIANI</p>
                            </div>

                            <div onclick="salinNomor('1234567890', 'status-bsi')" class="p-4 border-[3px] border-black bg-[#f4f4f0] hover:bg-[#fde047] transition-colors group cursor-pointer">
                                <p class="font-black text-lg uppercase text-[#22d3ee] mb-1">BSI</p>
                                <div class="flex items-center justify-between">
                                    <p class="font-900 text-2xl tracking-wider">7111620018</p>
                                    <div class="flex items-center gap-2">
                                        <span id="status-bsi" style="display: none;" class="text-[10px] text-black font-black bg-white border-[2px] border-black px-2 py-0.5 animate-pulse">TERSALIN!</span>
                                        <i data-lucide="copy" class="w-5 h-5 text-gray-400 group-hover:text-black"></i>
                                    </div>
                                </div>
                                <p class="font-bold text-sm text-gray-600 mt-1 uppercase">a.n. KHASRIANI</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="h-full">
                    <div class="bg-[#fde047] brutalist-border shadow-[10px_10px_0px_0px_#000] p-8 h-full flex flex-col">
                        <h3 class="font-black text-3xl uppercase mb-2">Upload Bukti</h3>
                        <p class="font-bold text-gray-700 mb-8 border-l-[4px] border-black pl-3">Sudah transfer? Jangan lupa kirim buktinya di sini agar pesanan cepat diproses!</p>

                        <form action="{{ route('cart.uploadReceipt', $order->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-grow">
                            @csrf

                            <div class="mb-8 flex-grow">
                                <label class="block font-black text-sm uppercase mb-3 text-black">Pilih Gambar / Struk (JPG, PNG)</label>
                                <div class="relative">
                                    <input type="file" name="bukti_pembayaran" accept="image/*" required
                                        class="block w-full text-sm font-bold text-black border-[4px] border-black bg-white cursor-pointer focus:outline-none
                                        file:mr-4 file:py-4 file:px-6 file:border-0 file:border-r-[4px] file:border-black file:font-black file:uppercase file:bg-black file:text-[#fde047] hover:file:bg-[#991b1b] hover:file:text-white transition-all">
                                </div>
                                <p class="text-xs font-bold text-gray-600 mt-3">* Maksimal ukuran file 2MB.</p>
                            </div>

                            <button type="submit" class="w-full flex items-center justify-center gap-3 bg-[#4ade80] text-black font-black uppercase px-8 py-5 brutalist-border shadow-[6px_6px_0px_0px_#000] hover:bg-white hover:translate-y-1 hover:shadow-[4px_4px_0px_0px_#000] active:translate-y-2 active:shadow-none transition-all text-xl mt-auto">
                                KIRIM BUKTI <i data-lucide="upload-cloud" class="w-6 h-6 stroke-[3px]"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </section>
    </main>

    @include('partials.footer')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();
        });

        // FUNGSI JAVASCRIPT KLASIK UNTUK COPY TEXT (ANTI-GAGAL)
        function salinNomor(teks, elemenId) {
            // 1. Buat elemen input teks sementara yang tidak terlihat
            var tempInput = document.createElement("textarea");
            tempInput.value = teks;
            document.body.appendChild(tempInput);

            // 2. Pilih teks di dalamnya dan eksekusi perintah Copy bawaan browser
            tempInput.select();
            document.execCommand("copy");

            // 3. Hapus elemen sementara tersebut agar HTML tetap bersih
            document.body.removeChild(tempInput);

            // 4. Munculkan tulisan "TERSALIN!"
            var statusBadge = document.getElementById(elemenId);
            statusBadge.style.display = "inline-block";

            // 5. Sembunyikan kembali tulisan setelah 2 detik
            setTimeout(function() {
                statusBadge.style.display = "none";
            }, 2000);
        }
    </script>
</body>

</html>