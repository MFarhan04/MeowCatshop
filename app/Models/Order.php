<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Mengizinkan kolom ini diisi
    protected $fillable = [
        'user_id',
        'customer_name',
        'phone',
        'address',
        'shipping_method',
        'payment_method',
        'shipping_cost',
        'total_price',
        'status',
        'payment_receipt'

    ];

    // Relasi: Satu pesanan punya banyak barang (items)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi: Pesanan ini milik siapa (user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
