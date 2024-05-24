<?php

namespace App\Http\Filters\V1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter 
{
    protected $builder;
    protected $request;

    protected $sortable = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;
    }


    protected function sort($value)
    {
        $sortFields = explode(',', $value);
        foreach ($sortFields as $sortField) {
            $direction = 'asc';
            if (strpos($sortField, '-') === 0) {
                $direction = 'desc';
                $sortField = substr($sortField, 1);
            }

                if(!in_array($sortField, $this->sortable))
                {
                    continue;
                }
    
            $this->builder->orderBy($sortField, $direction);
        }   
    }
    
    
}