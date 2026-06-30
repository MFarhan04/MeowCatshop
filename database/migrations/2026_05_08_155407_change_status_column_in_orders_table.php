<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Mengubah tipe kolom menjadi string (VARCHAR) bebas dengan panjang 255 karakter
            $table->string('status', 255)->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Kembalikan ke pengaturan awal jika di-rollback
            $table->string('status')->change();
        });
    }
};
