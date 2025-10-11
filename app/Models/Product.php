<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'price', 'stock', 'category_id'];
    protected $appends = ['min_price'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_main', 1);
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

     // Eager the minimum size price -> gives sizes_min_price
    public function scopeWithMinPrice($q)
    {
        return $q->withMin('sizes', 'price');
    }

    // Convenient accessor everywhere in Blade/Controllers
    public function getMinPriceAttribute()
    {
        if (! is_null($this->sizes_min_price ?? null)) {
            return (float) $this->sizes_min_price;
        }
        if ($this->relationLoaded('sizes')) {
            return (float) optional($this->sizes->min('price')) ?? 0;
        }
        return (float) ProductSize::where('product_id', $this->id)->min('price');
    }
}
