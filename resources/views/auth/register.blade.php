<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Daftar - Meow Catshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: #f4f4f0;
        }
    </style>
</head>

<body class="antialiased text-black flex flex-col min-h-screen selection:bg-black selection:text-white">

    @include('partials.header')

    <main class="flex-grow flex items-center justify-center p-4 py-16">
        <div class="w-full max-w-lg bg-white border-8 border-black p-8 shadow-[16px_16px_0px_0px_rgba(0,0,0,1)]">

            <div class="text-center mb-8 border-b-4 border-black pb-6">
                <h2 class="text-4xl font-black uppercase tracking-tighter text-[#991b1b]">Buat Akun</h2>
                <p class="font-bold text-gray-600 mt-2">Daftar untuk mulai berbelanja kebutuhan kucing!</p>
            </div>

            @if ($errors->any())
            <div class="bg-red-200 border-4 border-black p-4 mb-6 text-black font-bold shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block font-black uppercase mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full p-4 border-4 border-black focus:outline-none focus:bg-[#ffde59] transition-colors font-bold text-lg">
                </div>
                <div>
                    <label class="block font-black uppercase mb-2">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full p-4 border-4 border-black focus:outline-none focus:bg-[#ffde59] transition-colors font-bold text-lg">
                </div>
                <div>
                    <label class="block font-black uppercase mb-2">Password</label>
                    <input type="password" name="password" required class="w-full p-4 border-4 border-black focus:outline-none focus:bg-[#ffde59] transition-colors font-bold text-lg">
                </div>
                <div>
                    <label class="block font-black uppercase mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="w-full p-4 border-4 border-black focus:outline-none focus:bg-[#ffde59] transition-colors font-bold text-lg">
                </div>

                <button type="submit" class="w-full bg-[#991b1b] text-white px-6 py-4 border-4 border-black font-black text-xl uppercase hover:bg-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-y-1 hover:shadow-none transition-all mt-4">
                    DAFTAR SEKARANG
                </button>
            </form>

            <div class="mt-8 text-center pt-6 border-t-4 border-black">
                <p class="font-bold">Sudah punya akun?</p>
                <a href="{{ route('login') }}" class="inline-block mt-2 bg-[#ffde59] border-4 border-black px-6 py-2 font-black uppercase hover:bg-black hover:text-white transition-colors">Login Di Sini</a>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>

</html>
