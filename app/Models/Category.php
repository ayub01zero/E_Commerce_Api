<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function scopeOfName($query, $name)
    {
        if ($name) {
            return $query->where('category_name', 'LIKE', "%{$name}%");
        } else {
            return $query;
        }
      }

}
