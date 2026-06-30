<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    // Menampilkan Halaman Profil
    public function index()
    {
        $user = Auth::user();
        return view('profil', compact('user'));
    }

    // Memproses Perubahan Data Profil
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        // Validasi input (Semuanya pakai 'avatar', bukan 'photo')
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'instagram' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0|max:100',
            'bio' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'password.confirmed' => 'Konfirmasi password baru tidak cocok!',
            'password.min' => 'Password minimal harus 8 karakter!',
            'age.integer' => 'Usia harus berupa angka!',
            'avatar.image' => 'File harus berupa gambar!',
            'avatar.max' => 'Ukuran foto maksimal 2MB!',
        ]);

        // Menyimpan data ke dalam database
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->instagram = $request->instagram;
        $user->age = $request->age;
        $user->bio = $request->bio;

        // Update Password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Proses Upload Foto Profil (Menggunakan kolom avatar)
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan avatar baru
            $user->avatar = $request->file('avatar')->store('profile_photos', 'public');
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil brutalmu berhasil diperbarui!');
    }
}
