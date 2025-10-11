<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = ['user_id','token','ip_address'];
    public function items(){ return $this->hasMany(WishlistItem::class); }
}

// app/Models/WishlistItem.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishlistItem extends Model
{
    protected $fillable = ['wishlist_id','product_id','product_size_id'];
    public function product(){ return $this->belongsTo(Product::class); }
    public function size(){ return $this->belongsTo(ProductSize::class,'product_size_id'); }
}
