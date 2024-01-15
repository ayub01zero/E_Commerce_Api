<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ip', 'city', 'region', 'location', 'postal'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
