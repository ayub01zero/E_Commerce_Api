<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Products extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('posts');
        });
    }
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

    public function scopeOfSearch($query, string $terms = null)
    {
        collect(explode(' ', $terms))->filter()->each(function ($term) use ($query) {
            $term = '%' . $term . '%';

            $query->where(function ($query) use ($term) {
                $query->whereAny([
                    'product_name',
                    'short_des',
                ], 'LIKE', $term)
                    ->orWhereHas('category', function ($query) use ($term) {
                        $query->where('category_name', 'like', $term);
                    });
            });
        });
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


//  public function scopeOfSearch($query, string $terms = null)
//     {
//         collect(explode(' ', $terms))->filter()->each(function ($term) use ($query) {
//             $term = '%' . $term . '%';
    
//             $query->where(function ($query) use ($term) {
//                 $query->where('product_name', 'like', $term)
//                     ->orWhere('short_des', 'like', $term)
//                     ->orWhereHas('category', function ($query) use ($term) {
//                         $query->where('category_name', 'like', $term);
//                     });
//             });
//         });
//     }

// }
}
