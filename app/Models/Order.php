<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\V1\QueryFilter;

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

public function scopefilter(Builder $query, QueryFilter $filters)
{
    return $filters->apply($query);
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
