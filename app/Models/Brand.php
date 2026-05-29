<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'is_active',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? url('storage', $this->image)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0D9488&color=fff&size=128';
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
