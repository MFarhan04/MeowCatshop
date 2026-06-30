@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-900">Manajemen Pengguna</h2>
    <p class="text-slate-500 text-sm mt-1">Daftar pelanggan terdaftar, kontrol hak akses, dan monitoring aktivitas belanja Meow Catshop.</p>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-bold text-sm shadow-sm flex items-center gap-2">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl font-bold text-sm shadow-sm flex items-center gap-2">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    {{ session('error') }}
</div>
@endif

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-200 bg-slate-50/50">
        <h3 class="font-bold text-slate-800 text-lg">Semua Data Akun</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-xs border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 font-semibold">Nama Pengguna</th>
                    <th class="px-6 py-4 font-semibold">Alamat Email</th>
                    <th class="px-6 py-4 font-semibold text-center">Hak Akses (Role)</th>
                    <th class="px-6 py-4 font-semibold text-center">Total Pesanan</th>
                    <th class="px-6 py-4 font-semibold">Tanggal Bergabung</th>
                    <th class="px-6 py-4 font-semibold text-right">Tindakan Moderen</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $user)
                <tr class="hover:bg-slate-50/50 transition-colors">

                    <td class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                        {{ $user->name }}
                        @if($user->id == auth()->id())
                        <span class="ml-1 text-[9px] bg-slate-200 text-slate-700 px-1.5 py-0.5 rounded font-normal">Anda</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>

                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        <span class="{{ $user->role == 'admin' ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-indigo-50 text-indigo-700 border-indigo-200' }} border px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider">
                            {{ $user->role ?? 'Pelanggan' }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        <span class="font-black text-slate-800 bg-slate-100 border border-slate-200 px-2 py-0.5 rounded text-xs">
                            {{ $user->orders_count }} Transaksi
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500">
                        {{ $user->created_at->format('d M Y') }}
                    </td>

                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <div class="flex justify-end gap-3 items-center">

                            <form action="{{ route('admin.users.toggleRole', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengubah hak akses pengguna ini?');">
                                @csrf
                                <button type="submit" class="text-xs font-bold text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-2.5 py-1.5 rounded-lg transition-all border border-indigo-100" {{ $user->id == auth()->id() ? 'disabled style=opacity:0.5' : '' }}>
                                    Ubah Akses
                                </button>
                            </form>

                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Peringatan: Menghapus pengguna ini akan menghilangkan akses login mereka secara permanen!');">
                                @csrf
                                <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 px-2.5 py-1.5 rounded-lg transition-all border border-rose-100" {{ $user->id == auth()->id() ? 'disabled style=opacity:0.5' : '' }}>
                                    Hapus Akun
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center text-slate-400">Tidak ada data pengguna lain.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="p-6 border-t border-slate-100">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection