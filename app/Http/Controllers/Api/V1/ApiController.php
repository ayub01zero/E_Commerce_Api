<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    protected $policyClass;
    public function include(string $relationship) : bool
    {
        $param = request()->get('include');
        if (!$param) {
         return false;
        }
        $includeValues = explode(',',strtolower($param));
        return in_array(strtolower($relationship), $includeValues);

    }
      

    public function isAble($ability, $model)
    {
       return $this->authorize($ability, [$model , $this->policyClass]);
    }
}
