<?php

namespace App\Models;

use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'stock',
        'price',
        'attributes',
        'is_active',
    ];

    protected $casts = [
        'attributes' => 'array',
        'is_active'  => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getEffectivePrice()
    {
        return $this->price ?? $this->product->price;
    }
}
