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
     return $this->morphMany(Photos::class, 'imageable');
    }
    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function scopeOfCategory($query, $categoryId)
    {
        if (!empty($categoryId)) {
            return $query->where('category_id', $categoryId);
        }
        return $query;
    }

    public function scopeOfSearch($query, $searchTerm)
    {
        if (!empty($searchTerm)) {
            return $query->where('product_name', 'LIKE', "%{$searchTerm}%")
                         ->orWhere('short_des', 'LIKE', "%{$searchTerm}%");
        }
        return $query;
    }
    
    public function scopeOfPrice($query, $price)
    {
        if ($price) {
            return $query->wherebetween('selling_price', [$price[0], $price[1]]);
        } else {
            return $query;
        }
    }


public static function filterProducts(array $conditions)
{
    $query = self::query();

    foreach ($conditions as $field => $value) {
        if (in_array($field, ['week_deals', 'special_offer', 'discount_products']) && $value === true) {
            $query->where($field, $value);
        }
    }

    return $query;
}


}
