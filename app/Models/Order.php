<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
{
    return $this->belongsTo(User::class);
}

  public function scopeStatus($query, $status)
    {
        if (!is_null($status)) {
            return $query->where('status', $status);
        }

        return $query;
    }

    public function scopeUserId($query, $userId)
    {
        if (!is_null($userId)) {
            return $query->where('user_id', $userId);
        }

        return $query;
    }
}
