<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    
   protected $guarded = [];
    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
