<?php

namespace App\Http\Filters\V1;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\V1\QueryFilter;


class UserFilter extends QueryFilter
{

    protected $sortable = ['id', 'created_at', 'updated_at', 'role', 'name', 'email'];
    public function include(string $value)
    {
        return $this->builder->with($value);
    }

    public function role(string $role)
    {

        return $this->builder->where('role', $role);

    }

    public function CreatedAt($value)
    {
        $date  =explode(',', $value);
        if (count($date) > 1) {
            return $this->builder->whereBetween('created_at', $date);
        }
        return $this->builder->whereDate('created_at', $date);
     
    }

   



}


