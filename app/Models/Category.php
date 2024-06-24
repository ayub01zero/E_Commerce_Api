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


    // public function scopeFilter($query, array $filters)
    // {
    //     $query->when($filters['search']['name'] ?? null, function ($query, $name) {
    //         $query->whereAny([
    //             'first_name',
	// 		   'lastname',			
    //             'email',
    //         ],
    //             'LIKE',
    //             "%$name%");

    //     })->when($filters['search']['status'] ?? null, function ($query, $status) {
	// 					$query->where('status', $status);
	// 		});
    // }


    // use Illuminate\Support\Facades\Request as RequestFacade;

    // public function index()
    // {
    //     return UsersResource::collection(User::query()->with('ticket')
    //      ->filter(RequestFacade::only('search'))
    //      ->paginate()
    //      ->withQueryString());
    // } 


 
    public function images()
    {
        return $this->morphMany(Photos::class, 'imageable');
    }
    public function scopeOfName($query, $name)
    {
        if ($name) {
            return $query->where('category_name', 'LIKE', "%{$name}%");
        } else {
            return $query;
        }
    }

}
