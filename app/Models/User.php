<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Cog\Contracts\Ban\Bannable as BannableInterface;
use Cog\Laravel\Ban\Traits\Bannable;
use App\Http\Filters\V1\QueryFilter;
use Illuminate\Database\Eloquent\Builder;




class User extends Authenticatable implements BannableInterface
{
    use HasApiTokens, HasFactory, Notifiable, Bannable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
    ];
     protected $appends = ['Registered'];    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function scopefilter(Builder $query, QueryFilter $filters)
{
    return $filters->apply($query);
}

    public function scopeOfRole($query, $role)
    {
        if ($role) {
            return $query->where('role', $role);
        } else {
            return $query;
        }
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public function getRegisteredAttribute()
    {
        return $this->created_at->diffForHumans();
        
    }
    public function isAdmin(): bool
    {
        return $this->role === 'admin'; // Adjust this based on your role implementation
    }


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
