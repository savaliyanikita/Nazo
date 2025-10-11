<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        return view('frontend.category', compact('category'));
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
