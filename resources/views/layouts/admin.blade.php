<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title') - Admin Meow Catshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col shadow-sm">

            <div class="flex items-center justify-center h-20 border-b border-gray-100">
                <span class="text-xl font-black text-red-800 tracking-tight">MEOW ADMIN.</span>
            </div>

            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-3 rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-red-50 text-red-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Data Produk
                </a>

                <a href="{{ route('admin.orders') }}" class="flex items-center gap-3 p-3 rounded-xl transition-colors {{ request()->routeIs('admin.orders') || request()->routeIs('admin.orders.show') ? 'bg-red-50 text-red-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Pesanan Masuk
                </a>

                <a href="{{ route('admin.report') }}" class="flex items-center gap-3 p-3 rounded-xl transition-colors {{ request()->routeIs('admin.report') ? 'bg-red-50 text-red-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m4 2v-4m4 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Laporan Penjualan
                </a>

                <a href="{{ route('admin.create') }}" class="flex items-center gap-3 p-3 rounded-xl transition-colors {{ request()->routeIs('admin.create') ? 'bg-red-50 text-red-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Produk
                </a>

                <a href="{{ route('admin.users') }}" class="flex items-center gap-3 p-3 rounded-xl transition-colors {{ request()->routeIs('admin.users') ? 'bg-red-50 text-red-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Manajemen Pengguna
                </a>
            </nav>

            <div class="p-4 border-t border-gray-100 space-y-3">
                <a href="/" class="flex items-center justify-center w-full p-2.5 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                    Liat Toko Utama
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center justify-center w-full p-2.5 text-sm font-bold text-white bg-red-600 rounded-xl hover:bg-red-700 transition shadow-sm">
                        Logout System
                    </button>
                </form>
            </div>
        </aside>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm md:hidden" style="display: none;"></div>

        <main class="flex-1 overflow-y-auto bg-gray-50/50">
            <header class="flex items-center justify-between p-4 bg-white border-b border-gray-200 md:hidden sticky top-0 z-30">
                <span class="text-lg font-black text-red-800">MEOW ADMIN.</span>
                <button @click="sidebarOpen = true" class="p-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </header>

            <div class="p-6 md:p-10 max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>

    </div>
</body>

</html>