<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = ['user_id', 'product_id', 'rating', 'name', 'message'];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
