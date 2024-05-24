<?php

namespace App\Http\Filters\V1;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\V1\QueryFilter;


class OrderFilter extends QueryFilter
{

    protected $sortable = ['id', 'created_at', ,'amount'];

    public function include(string $value)
    {
        return $this->builder->with($value);
    }
    
    public function status(string $status)
    {
        return $this->builder->whereIn('status',explode(',', $status));
    }


    

    // public function title(string $title)
    // {
    //     $LikeStr = str_replace('*', '%', $title);
    //     return $this->builder->where('title', 'like', $LikeStr);
    // }

    // public function CreatedAt($value)
    // {
    //     $date  =explode(',', $value);
    //     if (count($date) > 1) {
    //         return $this->builder->whereBetween('created_at', $date);
    //     }
    //     return $this->builder->whereDate('created_at', $date);
     
    // }

   



}


