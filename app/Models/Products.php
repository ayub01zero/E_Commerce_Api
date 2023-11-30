<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function category()
    {
    return $this->belongsTo(Category::class);
    }
    public function images()
    {
    return $this->hasMany(ProductImage::class, 'product_id');
    }
    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function scopeOfCategory($query, $category_id)
    {
        if ($category_id) {
            return $query->where('category_id', $category_id);
        } else {
            return $query;
        }
    }

    public function scopeOfSearch($query, $search)
    {
        if ($search) {
            return $query->where('Product_name', 'LIKE', '%' . $search . '%')->orWhere('long_des', 'LIKE', '%' . $search . '%');
        } else {
            return $query;
        }
    }
    
    public function scopeOfPrice($query, $price)
    {
        if ($price) {
            return $query->wherebetween('selling_price', [$price[0], $price[1]]);
        } else {
            return $query;
        }
    }
}
