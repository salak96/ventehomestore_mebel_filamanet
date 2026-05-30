<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'sku',
        'images',
        'description',
        'price',
        'stock',
        'is_active',
        'is_featured',
        'on_sale',
        'access_link',
        'access_username',
        'access_password',
    ];

    protected $casts = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function getImagesAttribute($value)
    {
        $decoded = $value;

        while (is_string($decoded) && strlen($decoded) > 0) {
            $next = json_decode($decoded, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $decoded = $next;
                if (is_array($decoded)) break;
            } else {
                break;
            }
        }

        if (is_array($decoded)) {
            return array_values(array_map(fn ($v) => str_replace('\\', '/', (string) $v), $decoded));
        }

        return [];
    }

    public function setImagesAttribute($value)
    {
        if (is_array($value)) {
            $normalized = array_values(array_filter(
                array_map(fn ($v) => str_replace('\\', '/', trim((string) $v)), $value)
            ));
            $this->attributes['images'] = json_encode($normalized, JSON_UNESCAPED_SLASHES);
        } elseif (is_null($value) || $value === '') {
            $this->attributes['images'] = null;
        }
    }
}
