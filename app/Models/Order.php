<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // optional kalau table mengikuti konvensi 'orders' bisa dihilangkan
    protected $table = 'orders';

    // isi sesuai kolom yang ingin di-mass assign
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'payment_method',
        'grand_total',
    ];

    // cast supaya grand_total jadi integer (atau 'decimal:0' jika pakai decimal)
    protected $casts = [
        'grand_total' => 'integer',
    ];

    // relasi (opsional) kalau kamu punya order_items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
