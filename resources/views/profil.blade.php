<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Profil Saya - Meow Catshop</title>

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

        .bg-grid-layout {
            background-size: 30px 30px;
            background-image:
                linear-gradient(to right, rgba(0, 0, 0, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0, 0, 0, 0.05) 1px, transparent 1px);
        }
    </style>
</head>

<body class="antialiased flex flex-col min-h-screen bg-grid-layout">

    @include('partials.header')

    <main class="flex-grow max-w-5xl mx-auto px-4 sm:px-6 py-12 w-full">

        @if(session('success'))
        <div class="mb-8 p-5 bg-[#4ade80] brutalist-border font-black uppercase shadow-[6px_6px_0px_0px_#000] flex items-center gap-3">
            <i data-lucide="check-circle" class="w-6 h-6 stroke-[3px]"></i>
            {{ session('success') }}
        </div>
        @endif
        @if ($errors->any())
        <div class="mb-8 p-5 bg-[#991b1b] brutalist-border text-white font-black uppercase shadow-[6px_6px_0px_0px_#000] flex items-start gap-3">
            <i data-lucide="alert-triangle" class="w-6 h-6 stroke-[3px] shrink-0 mt-0.5"></i>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-white brutalist-border shadow-[12px_12px_0px_0px_#000] overflow-hidden flex flex-col lg:flex-row relative">

            <div class="lg:w-1/3 bg-[#c084fc] p-8 border-b-[4px] lg:border-b-0 lg:border-r-[4px] border-black flex flex-col items-center justify-center text-center">

                <div class="w-32 h-32 bg-white brutalist-border rounded-full shadow-[6px_6px_0_0_#000] flex items-center justify-center mb-6 overflow-hidden">
                    @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Foto Profil" class="w-full h-full object-cover">
                    @else
                    <i data-lucide="user" class="w-16 h-16 stroke-[2px] text-gray-400"></i>
                    @endif
                </div>

                <h2 class="font-black text-2xl uppercase mb-1">{{ $user->name }}</h2>
                <p class="font-bold text-sm bg-black text-white px-3 py-1 brutalist-border uppercase tracking-widest mt-2">
                    {{ $user->role == 'admin' ? 'Administrator' : 'Pelanggan Setia' }}
                </p>

                @if($user->bio)
                <p class="text-xs font-bold mt-4 text-black bg-white/40 p-3 border-2 border-black border-dashed rounded-lg max-w-xs">
                    "{{ $user->bio }}"
                </p>
                @endif

                <p class="text-xs font-bold mt-6 text-black/70 uppercase tracking-widest">Bergabung Sejak:<br>{{ $user->created_at->format('d M Y') }}</p>
            </div>

            <div class="lg:w-2/3 p-6 sm:p-8 bg-white">
                <h1 class="text-3xl font-black uppercase tracking-tighter mb-6 border-b-[4px] border-black pb-2 inline-block bg-[#fde047] px-4 brutalist-border shadow-[4px_4px_0_0_#000]">Pengaturan Profil</h1>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                        <div>
                            <label class="block font-black text-xs uppercase mb-2 tracking-wider">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full px-4 py-3 bg-[#f4f4f0] brutalist-border focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#fde047] transition-all font-bold text-sm">
                        </div>

                        <div>
                            <label class="block font-black text-xs uppercase mb-2 tracking-wider text-gray-500">Alamat Email (Permanen)</label>
                            <input type="email" value="{{ $user->email }}" readonly
                                class="w-full px-4 py-3 bg-gray-200 brutalist-border text-gray-500 font-bold cursor-not-allowed outline-none text-sm">
                        </div>

                        <div>
                            <label class="block font-black text-xs uppercase mb-2 tracking-wider">Nomor WA / HP</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789"
                                class="w-full px-4 py-3 bg-[#f4f4f0] brutalist-border focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#22d3ee] transition-all font-bold text-sm">
                        </div>

                        <div>
                            <label class="block font-black text-xs uppercase mb-2 tracking-wider">Usia (Tahun)</label>
                            <input type="number" name="age" value="{{ old('age', $user->age) }}" placeholder="Contoh: 21" min="0" max="100"
                                class="w-full px-4 py-3 bg-[#f4f4f0] brutalist-border focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#22d3ee] transition-all font-bold text-sm">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block font-black text-xs uppercase mb-2 tracking-wider">Username Instagram</label>
                            <div class="relative flex items-stretch">
                                <span class="bg-black text-white font-black px-4 flex items-center brutalist-border border-r-0 text-sm">@</span>
                                <input type="text" name="instagram" value="{{ old('instagram', $user->instagram) }}" placeholder="meow_catshop"
                                    class="w-full px-4 py-3 bg-[#f4f4f0] brutalist-border focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#38bdf8] transition-all font-bold text-sm">
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block font-black text-xs uppercase mb-2 tracking-wider">Alamat Lengkap Pengiriman</label>
                            <textarea name="address" rows="3" placeholder="Tulis jalan, nomor rumah, kelurahan, dan kecamatan..."
                                class="w-full px-4 py-3 bg-[#f4f4f0] brutalist-border focus:bg-white focus:outline-none focus:ring-4 focus:ring-black transition-all font-bold text-sm leading-relaxed">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block font-black text-xs uppercase mb-2 tracking-wider">Catatan Lainnya / Bio Singkat</label>
                            <textarea name="bio" rows="2" placeholder="Tulis deskripsi singkat dirimu atau catatan khusus untuk toko..."
                                class="w-full px-4 py-3 bg-[#f4f4f0] brutalist-border border-dashed focus:border-solid focus:bg-white focus:outline-none focus:ring-4 focus:ring-black transition-all font-bold text-sm leading-relaxed">{{ old('bio', $user->bio) }}</textarea>
                        </div>

                        <div class="sm:col-span-2 mt-2 p-5 border-[4px] border-black bg-white shadow-[4px_4px_0_0_#000]">
                            <label class="block font-black text-xs uppercase mb-3 tracking-wider">Unggah / Ganti Foto Profil</label>
                            <input type="file" name="avatar" accept="image/*"
                                class="w-full bg-[#f4f4f0] brutalist-border border-dashed p-2 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-black file:text-[#fde047] file:font-black file:uppercase hover:file:bg-gray-800 transition-all cursor-pointer">
                            <p class="text-[10px] text-gray-500 mt-2 font-bold uppercase">* Kosongkan jika tidak ingin mengganti foto. Maksimal 2MB (JPG/PNG).</p>
                        </div>

                    </div>

                    <div class="p-5 border-[4px] border-black bg-[#ffde59] mt-8 relative shadow-[4px_4px_0_0_#000]">
                        <span class="absolute -top-3.5 left-4 bg-black text-white px-2 font-black text-[10px] uppercase tracking-widest border-[3px] border-black">Ganti Password (Opsional)</span>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                            <div>
                                <label class="block font-black text-xs uppercase mb-1.5">Password Baru</label>
                                <input type="password" name="password" placeholder="Minimal 8 karakter"
                                    class="w-full px-3 py-2 bg-white brutalist-border border-[3px] focus:outline-none focus:ring-2 focus:ring-black transition-all font-bold text-sm">
                            </div>
                            <div>
                                <label class="block font-black text-xs uppercase mb-1.5">Ulangi Password</label>
                                <input type="password" name="password_confirmation" placeholder="Konfirmasi password"
                                    class="w-full px-3 py-2 bg-white brutalist-border border-[3px] focus:outline-none focus:ring-2 focus:ring-black transition-all font-bold text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 flex justify-end">
                        <button type="submit" class="w-full sm:w-fit bg-black text-[#4ade80] font-black uppercase tracking-widest px-8 py-4 brutalist-border shadow-[4px_4px_0_0_#4ade80] hover:bg-[#4ade80] hover:text-black hover:shadow-[4px_4px_0_0_#000] active:translate-y-1 active:shadow-none transition-all flex items-center justify-center gap-2 text-sm">
                            <i data-lucide="save" class="w-5 h-5 stroke-[3px]"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
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