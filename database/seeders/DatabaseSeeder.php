<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Sistem akan membuat atau memperbarui akun admin ini
        User::updateOrCreate(
            ['email' => 'admin@meow.com'], 
            [
                'name' => 'Admin Meow Catshop',
                'password' => Hash::make('password123'), // Ini adalah Password kamu
                'role' => 'admin' // Menjadikan akun ini sebagai Admin
            ]
        );
    }
}
